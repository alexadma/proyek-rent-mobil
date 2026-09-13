<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSewaRequest;
use App\Models\Customer;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SewaController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
            'pickup_datetime' => ['required', 'date', 'after_or_equal:'.Carbon::today()->toDateString()],
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
        $nama = $customer->nama ?? $user->username;
        $nohp = $request->input('nohp') ?: ($customer->nohp ?? '');
        $alamat = $request->input('alamat') ?: ($customer->alamat ?? '');
        $jaminan = $request->input('jaminan') ?: 'KTP';
        $mobilName = $request->input('mobil');
        $supirName = $request->input('supir');
        $isTanpaSupir = ($supirName === 'TANPA SUPIR');

        $waktu_pjm = Carbon::parse($request->input('pickup_datetime'))->format('Y-m-d H:i:s');
        $waktu_balik = Carbon::parse($request->input('return_datetime'))->format('Y-m-d H:i:s');

        $durasiJam = (int) Carbon::parse($waktu_pjm)->diffInHours(Carbon::parse($waktu_balik));
        if ($durasiJam < 1) {
            $durasiJam = 1;
        }

        try {
            $sewa = DB::transaction(function () use ($mobilName, $supirName, $isTanpaSupir, $durasiJam, $waktu_pjm, $waktu_balik, $nama, $nohp, $alamat, $jaminan, $customer) {
                $mobil = Mobil::where('nama_mobil', $mobilName)->lockForUpdate()->first();
                if (! $mobil || $mobil->status !== 'TERSEDIA') {
                    throw ValidationException::withMessages(['mobil' => 'Mobil tidak tersedia untuk disewa.']);
                }

                $supirNama = $supirName;
                if (! $isTanpaSupir) {
                    $supir = Supir::where('nama', $supirName)->lockForUpdate()->first();
                    if (! $supir || $supir->status !== 'TERSEDIA') {
                        throw ValidationException::withMessages(['supir' => 'Supir tidak tersedia untuk disewa.']);
                    }
                }

                if ($this->overlapExists('mobil', $mobilName, $waktu_pjm, $waktu_balik)) {
                    throw ValidationException::withMessages(['mobil' => 'Kendaraan sudah dipesan pada rentang waktu tersebut.']);
                }
                if (! $isTanpaSupir && $this->overlapExists('supir', $supirName, $waktu_pjm, $waktu_balik)) {
                    throw ValidationException::withMessages(['supir' => 'Supir sudah dipesan pada rentang waktu tersebut.']);
                }

                $hari = max(1, (int) ceil($durasiJam / 24));
                $supirBiaya = $isTanpaSupir ? 0 : (int) $supir->sewa;
                $totalBiaya = ((int) $mobil->sewa + $supirBiaya) * $hari;

                $lastRecord = Sewa::orderBy('id', 'desc')->lockForUpdate()->first();
                $newId = $lastRecord ? $lastRecord->id + 1 : 1;
                $no_invoice = 'RNT'.str_pad($newId, 5, '0', STR_PAD_LEFT);

                return Sewa::create([
                    'no_invoice' => $no_invoice,
                    'customer_id' => $customer->id ?? null,
                    'nama_customer' => $nama,
                    'nohp' => $nohp,
                    'alamat' => $alamat,
                    'nama_mobil' => $mobil->nama_mobil,
                    'nopol' => $mobil->nopol,
                    'nama_supir' => $supirNama,
                    'tanggal_pinjam' => $waktu_pjm,
                    'tanggal_kembali' => $waktu_balik,
                    'jaminan' => $jaminan,
                    'total_biaya' => $totalBiaya,
                    'verifikasi' => 'Requested',
                    'bukti' => null,
                ]);
            });
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect('/invoice');
    }

    private function overlapExists(string $type, string $name, string $waktuPjm, string $waktuBalik): bool
    {
        $query = Sewa::query()
            ->whereIn('verifikasi', ['Requested', 'DITERIMA'])
            ->where($type === 'mobil' ? 'nama_mobil' : 'nama_supir', $name);

        $query->where(function ($q) use ($waktuPjm, $waktuBalik) {
            $q->whereBetween('tanggal_pinjam', [$waktuPjm, $waktuBalik])
                ->orWhereBetween('tanggal_kembali', [$waktuPjm, $waktuBalik])
                ->orWhere(function ($q2) use ($waktuPjm, $waktuBalik) {
                    $q2->where('tanggal_pinjam', '<=', $waktuPjm)
                        ->where('tanggal_kembali', '>=', $waktuBalik);
                });
        });

        return $query->exists();
    }

    public function calculatePrice(Request $request)
    {
        $mobil = $request->input('mobil') ? Mobil::where('nama_mobil', $request->input('mobil'))->first() : null;
        $supirName = $request->input('supir');
        $isTanpaSupir = ($supirName === 'TANPA SUPIR');
        $supir = (! $isTanpaSupir && $supirName) ? Supir::where('nama', $supirName)->first() : null;

        $pickup = $request->input('pickup_datetime');
        $return = $request->input('return_datetime');

        $durasiJam = 24;
        if ($pickup && $return) {
            $durasiJam = max(1, (int) Carbon::parse($pickup)->diffInHours(Carbon::parse($return)));
        }

        $hari = max(1, (int) ceil($durasiJam / 24));
        $supirBiaya = $isTanpaSupir ? 0 : (int) ($supir->sewa ?? 0);
        $total = ((int) ($mobil->sewa ?? 0) + $supirBiaya) * $hari;

        $hariDisplay = $durasiJam >= 24 ? floor($durasiJam / 24) : 0;
        $jamSisa = $durasiJam % 24;
        $durasiText = '';
        if ($hariDisplay > 0) {
            $durasiText .= $hariDisplay.' Hari';
        }
        if ($jamSisa > 0) {
            $durasiText .= ($hariDisplay > 0 ? ' ' : '').$jamSisa.' Jam';
        }
        if ($durasiText === '') {
            $durasiText = '1 Hari';
        }

        return response()->json([
            'total' => $total,
            'nopol' => $mobil->nopol ?? null,
            'hari' => $hari,
            'durasi_jam' => $durasiJam,
            'durasi_text' => $durasiText,
            'harga_mobil' => (int) ($mobil->sewa ?? 0),
            'harga_supir' => $supirBiaya,
            'is_tanpa_supir' => $isTanpaSupir,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sewa $sewa)
    {
        return view('admin/verifikasi', [
            'title' => 'Daftar Transaksi',
            'transaksi' => Sewa::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sewa $sewa) {}

    public function invoice()
    {
        $user = Auth::guard('web')->user();
        $sewa = $user
            ? Sewa::where('customer_id', $user->id)->latest()->first()
            : Sewa::latest()->first();

        if (! $sewa) {
            return redirect()->route('home');
        }

        $mobil = Mobil::where('nama_mobil', $sewa->nama_mobil)->first();
        $supir = Supir::where('nama', $sewa->nama_supir)->first();

        return view('customer/invoice', [
            'sewa' => $sewa,
            'mobil' => $mobil,
            'supir' => $supir,
        ]);
    }

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
            $validateData['bukti'] = $request->file('bukti')->store('bukti-tf', 'public');
        }

        Sewa::where('id', $sewa->id)->update($validateData);

        return redirect('home')->with('success', 'Bukti transfer telah diunggah! Halaman akan kembali ke home...');
    }

    public function laporan(Sewa $sewa)
    {
        return view('admin/keuangan', [
            'title' => 'Daftar Transaksi',
            'transaksi' => Sewa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSewaRequest $request, Sewa $sewa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sewa $sewa)
    {
        //
    }
}
