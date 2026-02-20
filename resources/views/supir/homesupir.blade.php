@extends('layouts.mainadmin')

@section('container')
<section class="m-6" id="">
    <div class="m-6">
        <p class="text-white">
            Daftar Supir DVJR RentCar
        </p>
        <a href="supir/create" class="">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                Tambah
            </button>
        </a>
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            {{ session('success') }}
        </div>
        @endif
    </div>
    <div class="flex flex-wrap">
        @foreach($supirs as $supir)
        <div class="bg-black">
            <div class="rounded bg-gray-900 border-gray-500 border-4 overflow-hidden shadow-lg m-2">
                <img src="{{ asset('storage/' . $supir->image) }}" alt="Supir" class="w-72 h-80 border-b-4 border-black ">
                <div class="px-6 py-4">
                    <div class="flex space-x-6">
                        <p class="text-white text-base">Nama</p>
                        <p class="text-white text-base">: {{ $supir->nama}}</p>
                    </div>
                    <div class="flex space-x-2.5">
                        <p class="text-white text-base">No. KTP</p>
                        <div class="text-white text-base">: {{ $supir->noktp}}</div>
                    </div>
                    <div class="flex space-x-4">
                        <p class="text-white text-base">Alamat</p>
                        <p class="text-white text-base">: {{ $supir->alamat}}</p>
                    </div>
                    <div class="flex space-x-2.5">
                        <p class="text-white text-base">No. Tepl</p>
                        <p class="text-white text-base">: {{ $supir->nohpsupir}}</p>
                    </div>
                </div>
                <div class="flex flex-wrap p-2">
                    <form action="/supir/{{ $supir->noktp }}" method="post" class="p-2">
                        @method('delete')
                        @csrf
                        <button class="bg-red-500 hover:bg-red-800 text-white font-bold py-2 px-4 border border-red-600 rounded" onclick="return confirm('Anda yakin akan menghapus data supir ini?')">
                            Hapus
                        </button>
                    </form>
                    <a href="/supir/{{ $supir->noktp }}/edit" class="p-2">
                        <button class="bg-red-500 hover:bg-red-800 text-white font-bold py-2 px-4 border border-red-600 rounded">
                            update
                        </button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection