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
        $mobils = Mobil::where('status','Tersedia')->get();
        $supirs = Supir::where('status','Tersedia')->get();
        $customers = Customer::all();
        return view('customer/sewa', [
            "title" => "Sewa Mobil",
            "mobils" => $mobils, // Ubah variabel $mobil menjadi $mobils
            "supirs" => $supirs,  // Melewatkan data sopir ke tampilan jika diperlukan
            "customers" => $customers
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
    $customer = Customer::where('username', $user->username)->first();

    $validateData = $request->validate([
        'tgl_pjm' => ['required', 'date', 'after_or_equal:' . Carbon::today()->toDateString()],
    ]);

    $nama     = $request->input('nama');
    $nohp     = $request->input('nohp');
    $alamat   = $request->input('alamat');
    $nopol    = $request->input('nopol');
    $jaminan  = $request->input('jaminan');
    $mobil    = $request->input('mobil');
    $supir    = $request->input('supir');
    $total    = $request->input('total');
    $durasi   = $request->input('durasi');

    // ✅ Fix: konversi format datetime-local → format MySQL
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
        'tanggal_pinjam'  => $waktu_pjm,   // ✅ Format sudah benar
        'tanggal_kembali' => $waktu_balik,
        'jaminan'         => $jaminan,
        'total_biaya'     => $total,
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

    public function invoice(Sewa $sewa)
    {
        $sewa = new Sewa;
        // Ambil data sewa terakhir
        $sewa = Sewa::latest()->first();
        $mobil = Mobil::latest()->first();
        $supir = Supir::latest()->first();

        // Jika tidak ada data sewa, redirect ke halaman sebelumnya
        if (!$sewa) {
            return redirect()->back();
        }

        // Tampilkan halaman invoice dengan data sewa
        return view('customer/invoice', [
            'sewa' => $sewa,
            'mobil' => $mobil,
            'supir' => $supir
        ]);
    }

    public function updateInvoice(Request $request)
    {


        // $sewa = Sewa::latest()->first();
        // $sewa->save();


        $request->validate([
            $sewa = Sewa::latest()->first(),
            'bukti' => 'image|file|max:5000'
        ]);

        if ($request->file('bukti')) {
            $validateData['bukti'] = $request->file('bukti')->store('bukti-tf');
        }
        Sewa::where('id', $sewa->id)
            ->update($validateData);

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
