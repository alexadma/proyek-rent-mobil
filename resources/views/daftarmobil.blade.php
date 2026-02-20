@extends('layouts.mainsewa')

@section('container')
<section class="" id="">
    <div class="pt-16 px-4 flex flex-wrap">
        @foreach( $mobil as $mobil )
        <div class="bg-black">
            <a href="/sewa" class="no-underline">
                <div class="rounded bg-gray-900 border-gray-500 border-4 overflow-hidden shadow-lg m-2">
                    <img src="{{ asset('storage/' . $mobil->foto) }}" alt="mobil" class="w-80 h-56 border-b-4 border-black ">
                    <div class="px-6 py-4">
                        <div class="font-bold text-white text-xl mb-2">{{ $mobil->nama_mobil }}</div>
                        <div class="flex space-x-2.5">
                            <p class="text-white text-base">Plat Nomor</p>
                            <p class="text-white text-base">: {{ $mobil->nopol }}</p>
                        </div>
                        <div class="flex space-x-4">
                            <p class="text-white text-base">Tipe Mobil</p>
                            <p class="text-white text-base">: {{ $mobil->type }}</p>
                        </div>
                        <div class="flex space-x-11">
                            <p class="text-white text-base">Warna </p>
                            <p class="text-white text-base">: {{ $mobil->warna }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <p class="text-white text-base">Harga Sewa</p>
                            <p class="text-white text-base">: {{ $mobil->sewa }}</p>
                        </div>
                        <div class="flex space-x-12">
                            <p class="text-white text-base">Status</p>
                            <p class="text-white text-base">: {{ $mobil->status }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endsection