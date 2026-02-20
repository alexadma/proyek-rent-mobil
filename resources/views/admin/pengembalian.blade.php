@extends('layouts.mainverifikasi')

@section('head')
<!-- CSS DataTables -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection

@section('container')

<div class="flex flex-col text-white ml-20">
    <!-- Adjust ml-64 for sidebar width -->
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8 mt-16">
        <!-- Added mt-16 (top margin) -->
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8 pr-16">
            <div class="overflow-hidden">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="border-b font-medium dark:border-neutral-500">
                        <tr>
                            <th class="px-4 py-2">No. Invoice</th>
                            <th class="px-4 py-2">Nama Customer</th>
                            <th class="px-4 py-2">No.Hp Cust</th>
                            <th class="px-4 py-2">Mobil</th>
                            <th class="px-4 py-2">Plat Mobil</th>
                            <th class="px-4 py-2">Nama Supir</th>
                            <th class="px-4 py-2">Tanggal Pinjam</th>
                            <th class="px-4 py-2">Tanggal Kembali</th>
                            <th class="px-4 py-2">Jaminan</th>
                            <th class="px-4 py-2">Total Biaya</th>
                            <th class="px-4 py-2">Bukti TF</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($status as $data)
                        <tr>
                            <td class="px-4 py-2">{{ $data->no_invoice }}</td>
                            <td class="px-4 py-2">{{ $data->nama_customer }}</td>
                            <td class="px-4 py-2">{{ $data->nohp }}</td>
                            <td class="px-4 py-2">{{ $data->nama_mobil }}</td>
                            <td class="px-4 py-2">{{ $data->nopol }}</td>
                            <td class="px-4 py-2">{{ $data->nama_supir }}</td>
                            <td class="px-4 py-2">{{ $data->tanggal_pinjam }}</td>
                            <td class="px-4 py-2">{{ $data->tanggal_kembali }}</td>
                            <td class="px-4 py-2">{{ $data->jaminan }}</td>
                            <td class="px-4 py-2">{{ $data->total_biaya }}</td>
                            <td class="px-4 py-2">
                                <img src="{{ asset('storage/' . $data->bukti) }}" alt="Bukti-Tf">
                            </td>
                            <td>
                                <label class="badge" style="display: inline-block;min-width: 90px;">{{ $data->verifikasi }}</label>
                            </td>
                            <td>
                                <a onclick="return confirm('Apakah Anda yakin Mobil sudah kembali ?')" href="{{url('pengembalian', $data->id)}}" class="btn btn-warning">Selesai</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#rentalTable').DataTable({
            "lengthMenu": [10, 25, 50, 75, 100],
            "pageLength": 10
        });
    });
</script>

@endsection