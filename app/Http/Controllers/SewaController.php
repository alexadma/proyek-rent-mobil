<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use App\Services\SewaService;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SewaController extends Controller
{
    public function __construct(
        private SewaService $sewaService,
        private SupabaseStorageService $storage
    ) {}

    /**
     * Form sewa mobil (customer).
     */
    public function index()
    {
        $mobils = Mobil::where('status', 'TERSEDIA')->get();
        $supirs = Supir::where('status', 'TERSEDIA')->get();
        $customers = Customer::all();
        $customer = Auth::guard('web')->user();

        return view('customer/sewa', [
            'title' => 'Sewa Mobil',
            'mobils' => $mobils,
            'supirs' => $supirs,
            'customers' => $customers,
            'customer' => $customer,
        ]);
    }

    /**
     * Proses penyewaan mobil.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (! $user) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'mobil' => ['required'],
            'supir' => ['required'],
            'pickup_datetime' => ['required', 'date', 'after_or_equal:'.now()->toDateString()],
            'return_datetime' => ['required', 'date', 'after:pickup_datetime'],
            'jaminan' => ['required', 'string'],
        ], [
            'pickup_datetime.required' => 'Tanggal & waktu pengambilan wajib diisi.',
            'pickup_datetime.after_or_equal' => 'Tanggal pengambilan tidak boleh di masa lalu.',
            'return_datetime.required' => 'Tanggal & waktu pengembalian wajib diisi.',
            'return_datetime.after' => 'Tanggal pengembalian harus setelah tanggal pengambilan.',
            'mobil.required' => 'Silakan pilih mobil.',
            'supir.required' => 'Silakan pilih supir.',
            'jaminan.required' => 'Jaminan wajib diisi.',
        ]);

        $customer = Customer::where('username', $user->username)->first();

        try {
            $this->sewaService->createSewa([
                'mobil' => $request->input('mobil'),
                'supir' => $request->input('supir'),
                'pickup_datetime' => $request->input('pickup_datetime'),
                'return_datetime' => $request->input('return_datetime'),
                'jaminan' => $request->input('jaminan'),
                'nama' => $customer->nama ?? $user->username,
                'nohp' => $request->input('nohp') ?: ($customer->nohp ?? ''),
                'alamat' => $request->input('alamat') ?: ($customer->alamat ?? ''),
            ], $customer->id ?? null);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect('/invoice');
    }

    /**
     * AJAX: hitung harga sewa.
     */
    public function calculatePrice(Request $request)
    {
        return response()->json(
            $this->sewaService->calculatePrice(
                $request->input('mobil'),
                $request->input('supir'),
                $request->input('pickup_datetime'),
                $request->input('return_datetime')
            )
        );
    }

    /**
     * Invoice terakhir customer.
     */
    public function invoice()
    {
        $user = Auth::guard('web')->user();
        $sewa = $user
            ? Sewa::where('customer_id', $user->id)->latest()->first()
            : Sewa::latest()->first();

        if (! $sewa) {
            return redirect()->route('home');
        }

        return view('customer/invoice', [
            'sewa' => $sewa,
            'mobil' => Mobil::where('nama_mobil', $sewa->nama_mobil)->first(),
            'supir' => Supir::where('nama', $sewa->nama_supir)->first(),
        ]);
    }

    /**
     * Upload bukti transfer.
     */
    public function updateInvoice(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (! $user) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $sewa = Sewa::where('customer_id', $user->id)->latest()->first();
        if (! $sewa) {
            return redirect()->route('home')->with('error', 'Tidak ada transaksi yang ditemukan.');
        }

        $validateData = $request->validate([
            'bukti' => 'required|image|file|max:5000',
        ]);

        if ($request->file('bukti')) {
            $validateData['bukti'] = $this->storage->upload($request->file('bukti'), 'bukti-tf');
        }

        Sewa::where('id', $sewa->id)->update($validateData);

        return redirect('home')->with('success', 'Bukti transfer telah diunggah! Halaman akan kembali ke home...');
    }

    /**
     * Riwayat transaksi customer.
     */
    public function riwayat()
    {
        $user = Auth::guard('web')->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $transaksis = Sewa::where('customer_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('customer/riwayat', [
            'transaksis' => $transaksis,
        ]);
    }
}
