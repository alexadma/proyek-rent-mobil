<?php

namespace App\Services;

use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SewaService
{
    /**
     * Calculate rental price based on mobil, supir, and duration.
     */
    public function calculatePrice(?string $mobilName, ?string $supirName, ?string $pickup, ?string $return): array
    {
        $mobil = $mobilName ? Mobil::where('nama_mobil', $mobilName)->first() : null;
        $isTanpaSupir = ($supirName === 'TANPA SUPIR');
        $supir = (! $isTanpaSupir && $supirName) ? Supir::where('nama', $supirName)->first() : null;

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

        return [
            'total' => $total,
            'nopol' => $mobil->nopol ?? null,
            'hari' => $hari,
            'durasi_jam' => $durasiJam,
            'durasi_text' => $durasiText,
            'harga_mobil' => (int) ($mobil->sewa ?? 0),
            'harga_supir' => $supirBiaya,
            'is_tanpa_supir' => $isTanpaSupir,
        ];
    }

    /**
     * Calculate duration in hours from pickup and return datetimes.
     */
    public function calculateDuration(string $waktuPjm, string $waktuBalik): int
    {
        $durasiJam = (int) Carbon::parse($waktuPjm)->diffInHours(Carbon::parse($waktuBalik));

        return max(1, $durasiJam);
    }

    /**
     * Generate unique invoice number: RNT00001, RNT00002, etc.
     */
    public function generateInvoiceNumber(): string
    {
        $lastId = Sewa::max('id') ?? 0;

        return 'RNT'.str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new sewa (rental) record inside a DB transaction.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createSewa(array $data, int $customerId): Sewa
    {
        $mobilName = $data['mobil'];
        $supirName = $data['supir'];
        $isTanpaSupir = ($supirName === 'TANPA SUPIR');
        $waktuPjm = Carbon::parse($data['pickup_datetime'])->format('Y-m-d H:i:s');
        $waktuBalik = Carbon::parse($data['return_datetime'])->format('Y-m-d H:i:s');
        $durasiJam = $this->calculateDuration($waktuPjm, $waktuBalik);
        $hari = max(1, (int) ceil($durasiJam / 24));

        return DB::transaction(function () use ($mobilName, $supirName, $isTanpaSupir, $durasiJam, $waktuPjm, $waktuBalik, $hari, $data, $customerId) {
            $mobil = Mobil::where('nama_mobil', $mobilName)->lockForUpdate()->first();
            if (! $mobil || $mobil->status !== 'TERSEDIA') {
                throw ValidationException::withMessages(['mobil' => 'Mobil tidak tersedia untuk disewa.']);
            }

            if (! $isTanpaSupir) {
                $supir = Supir::where('nama', $supirName)->lockForUpdate()->first();
                if (! $supir || $supir->status !== 'TERSEDIA') {
                    throw ValidationException::withMessages(['supir' => 'Supir tidak tersedia untuk disewa.']);
                }
            }

            if (Sewa::hasOverlap('mobil', $mobilName, $waktuPjm, $waktuBalik)) {
                throw ValidationException::withMessages(['mobil' => 'Kendaraan sudah dipesan pada rentang waktu tersebut.']);
            }
            if (! $isTanpaSupir && Sewa::hasOverlap('supir', $supirName, $waktuPjm, $waktuBalik)) {
                throw ValidationException::withMessages(['supir' => 'Supir sudah dipesan pada rentang waktu tersebut.']);
            }

            $supirBiaya = $isTanpaSupir ? 0 : (int) ($supir->sewa ?? 0);
            $totalBiaya = ((int) $mobil->sewa + $supirBiaya) * $hari;

            return Sewa::create([
                'no_invoice' => $this->generateInvoiceNumber(),
                'customer_id' => $customerId,
                'nama_customer' => $data['nama'],
                'nohp' => $data['nohp'] ?? '',
                'alamat' => $data['alamat'] ?? '',
                'nama_mobil' => $mobil->nama_mobil,
                'nopol' => $mobil->nopol,
                'nama_supir' => $isTanpaSupir ? 'TANPA SUPIR' : $supirName,
                'tanggal_pinjam' => $waktuPjm,
                'tanggal_kembali' => $waktuBalik,
                'jaminan' => $data['jaminan'] ?? 'KTP',
                'total_biaya' => $totalBiaya,
                'verifikasi' => 'Requested',
                'bukti' => null,
            ]);
        });
    }
}
