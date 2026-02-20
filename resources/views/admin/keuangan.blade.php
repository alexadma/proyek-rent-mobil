@extends('layouts.mainkeuangan')

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
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Saldo Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                   
                        @foreach($status as $data)
                        <tr>
                            <td class="px-4 py-2">{{ $data->no_invoice }}</td>
                            <td class="px-4 py-2">{{ $data->tanggal_kembali }}</td>
                            <td class="px-4 py-2">Rp. {{ $data->total_biaya }}</td>
                        @endforeach

                        <tr style="border-top: 2px solid #fff;">
                            <td colspan="2" class="px-4 py-2 font-medium"><strong>Total</td>
                            <td class="px-4 py-2 font-medium"><strong>Rp. {{ $status->sum('total_biaya') }}</td>
                            <td colspan="3"></td>
                        </tr>

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