<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sewa;
use App\Models\Mobil;
use App\Models\Supir;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSewaRequest;
use App\Http\Requests\UpdateSewaRequest;

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
            "title" => "Sewa Mobil",
            "mobils" => $mobils,
            "supirs" => $supirs,
            "customers" => $customers,
            "customer" => $customer,
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

    if (!$user) {
        return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
    }

    $customer = Customer::where('username', $user->username)->first();

    $validateData = $request->validate([
        'mobil'   => ['required'],
        'supir'   => ['required'],
        'total'   => ['required'],
        'durasi'  => ['required', 'integer', 'min:1'],
        'tgl_pjm' => ['required', 'date', 'after_or_equal:' . Carbon::today()->toDateString()],
    ]);

    $nama     = $request->input('nama') ?: ($customer->nama ?? $user->username);
    $nohp     = $request->input('nohp') ?: ($customer->nohp ?? '');
    $alamat   = $request->input('alamat') ?: ($customer->alamat ?? '');
    $nopol    = $request->input('nopol');
    $jaminan  = $request->input('jaminan') ?: 'KTP';
    $mobil    = $request->input('mobil');
    $supir    = $request->input('supir');
    $total    = $request->input('total');
    $durasi   = $request->input('durasi');

    // konversi format datetime-local → format MySQL
    $waktu_pjm   = Carbon::parse($request->input('tgl_pjm'))->format('Y-m-d H:i:s');
    $waktu_balik = Carbon::parse($waktu_pjm)->addHours((int)$durasi)->format('Y-m-d H:i:s');

    $lastRecord = Sewa::orderBy('id', 'desc')->first();
    $newId      = $lastRecord ? $lastRecord->id + 1 : 1;
    $no_invoice = 'RNT' . str_pad($newId, 5, '0', STR_PAD_LEFT);

    Sewa::create([
        'no_invoice'      => $no_invoice,
        'nama_customer'   => $nama,
        'nohp'            => $nohp,
        'alamat'          => $alamat,
        'nama_mobil'      => $mobil,
        'nopol'           => $nopol,
        'nama_supir'      => $supir,
        'tanggal_pinjam'  => $waktu_pjm,
        'tanggal_kembali' => $waktu_balik,
        'jaminan'         => $jaminan,
        'total_biaya'     => $total,
        'verifikasi'      => 'Requested',
        'bukti'           => null,
    ]);

    return redirect('/invoice');
}

    /**
     * Display the specified resource.
     */
    public function show(Sewa $sewa)
    {
        return view('admin/verifikasi', [
            "title" => "Daftar Transaksi",
            "transaksi" => Sewa::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sewa $sewa)
    {
    }

    public function invoice()
    {
        // Ambil data sewa terakhir milik customer yang sedang login
        $user = Auth::guard('web')->user();
        $query = Sewa::query();

        if ($user) {
            $customer = Customer::where('username', $user->username)->first();
            $nama = $customer->nama ?? $user->username;
            $query->where('nama_customer', $nama);
        }

        $sewa = $query->latest()->first();

        // Jika tidak ada data sewa, redirect ke halaman sebelumnya
        if (!$sewa) {
            return redirect()->route('home');
        }

        $mobil = Mobil::where('nama_mobil', $sewa->nama_mobil)->first();
        $supir = Supir::where('nama', $sewa->nama_supir)->first();

        // Tampilkan halaman invoice dengan data sewa
        return view('customer/invoice', [
            'sewa' => $sewa,
            'mobil' => $mobil,
            'supir' => $supir
        ]);
    }

    public function updateInvoice(Request $request)
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('login')->with('fail', 'Silakan login terlebih dahulu.');
        }

        $customer = Customer::where('username', $user->username)->first();
        $nama = $customer->nama ?? $user->username;

        $sewa = Sewa::where('nama_customer', $nama)->latest()->first();
        if (!$sewa) {
            return redirect()->route('home')->with('error', 'Tidak ada transaksi yang ditemukan.');
        }

        $validateData = $request->validate([
            'bukti' => 'required|image|file|max:5000'
        ]);

        if ($request->file('bukti')) {
            $validateData['bukti'] = $request->file('bukti')->store('bukti-tf');
        }

        Sewa::where('id', $sewa->id)->update($validateData);

        return redirect('home')->with('success', 'Bukti transfer telah diunggah! Halaman akan kembali ke home...');
    }

    public function laporan(Sewa $sewa)
    {
        return view('admin/keuangan', [
            "title" => "Daftar Transaksi",
            "transaksi" => Sewa::all()
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
