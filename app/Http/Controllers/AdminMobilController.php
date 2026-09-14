<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Mobil;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;

class AdminMobilController extends Controller
{
    public function __construct(
        private SupabaseStorageService $storage
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mobil/homemobil', [
            'mobils' => Mobil::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mobil/tambahmobil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_mobil' => 'required',
            'nopol' => 'required',
            'warna' => 'required',
            'type' => 'required',
            'sewa' => 'required',
            'tgl_pjk' => 'required',
            'foto' => 'required|image|file|max:5000',
        ]);

        if ($request->file('foto')) {
            $validateData['foto'] = $this->storage->upload($request->file('foto'), 'foto-mobil');
        }

        $validateData['status'] = 'TERSEDIA';

        Mobil::create($validateData);

        ActivityLog::log('mobil', 'create', 'Menambahkan mobil baru: ' . $validateData['nama_mobil'] . ' (' . $validateData['nopol'] . ')');

        return redirect('mobil')->with('success', 'Mobil Baru telah ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mobil $mobil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);

        return view('mobil/updatemobil', compact('mobil'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $rules = [
            'nama_mobil' => 'required',
            'nopol' => 'required',
            'warna' => 'required',
            'type' => 'required',
            'sewa' => 'required',
            'status' => 'required',
            'tgl_pjk' => 'required',
            'foto' => 'image|file|max:5000',
        ];

        $validateData = $request->validate($rules);

        if ($validateData['status'] === 'Tersedia') {
            $validateData['status'] = 'TERSEDIA';
        } elseif ($validateData['status'] === 'Disewa') {
            $validateData['status'] = 'DISEWA';
        } elseif ($validateData['status'] === 'Maintenance') {
            $validateData['status'] = 'MAINTENANCE';
        }

        if ($request->file('foto')) {
            if ($request->oldfoto) {
                $this->storage->delete($request->oldfoto);
            }
            $validateData['foto'] = $this->storage->upload($request->file('foto'), 'foto-mobil');
        }

        Mobil::where('id', $mobil->id)
            ->update($validateData);

        ActivityLog::log('mobil', 'update', 'Mengupdate data mobil: ' . $validateData['nama_mobil'] . ' (' . $validateData['nopol'] . ')');

        return redirect('mobil')->with('success', 'Data Mobil telah Di Update');
    }

    public function destroy(Mobil $mobil)
    {
        $nama = $mobil->nama_mobil;
        $nopol = $mobil->nopol;

        if ($mobil->foto) {
            $this->storage->delete($mobil->foto);
        }
        Mobil::destroy($mobil->id);

        ActivityLog::log('mobil', 'delete', 'Menghapus mobil: ' . $nama . ' (' . $nopol . ')');

        return redirect('mobil')->with('success', 'Data Mobil telah dihapus');
    }
}
