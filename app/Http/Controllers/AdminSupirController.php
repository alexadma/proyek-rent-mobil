<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supir/homesupir', [
            'supirs' => Supir::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supir/tambahsupir');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'noktp' => 'required|min:16|max:16',
            'nama' => 'required',
            'alamat' => 'required',
            'nohpsupir' => 'required|min:10|max:12',
            'image' => 'required|image|file|max:5000',
        ]);

        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('foto-supir', 'public');
        }

        Supir::create($validateData);

        ActivityLog::log('supir', 'create', 'Menambahkan supir baru: ' . $validateData['nama']);

        return redirect('supir')->with('success', 'Supir Baru telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supir $supir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($noktp)
    {
        $supir = Supir::findOrFail($noktp);

        return view('supir/updatesupir', compact('supir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supir $supir)
    {
        $rules = [
            'noktp' => 'required|min:16|max:16',
            'nama' => 'required',
            'alamat' => 'required',
            'nohpsupir' => 'required|min:10|max:12',
            'image' => 'image|file|max:5000',
        ];

        $validateData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldimage && str_starts_with($request->oldimage, 'foto-supir/')) {
                Storage::delete('foto-supir/'.basename($request->oldimage));
            }
            $validateData['image'] = $request->file('image')->store('foto-supir', 'public');
        }

        Supir::where('noktp', $supir->noktp)
            ->update($validateData);

        ActivityLog::log('supir', 'update', 'Mengupdate data supir: ' . $supir->nama);

        return redirect('supir')->with('success', 'Data Supir  telah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supir $supir)
    {
        $nama = $supir->nama;

        if ($supir->image) {
            Storage::delete($supir->image);
        }
        Supir::destroy($supir->noktp);

        ActivityLog::log('supir', 'delete', 'Menghapus supir: ' . $nama);

        return redirect('supir')->with('success', 'Data Supir telah dihapus');
    }
}
