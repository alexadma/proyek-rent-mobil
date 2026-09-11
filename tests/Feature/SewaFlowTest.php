<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SewaFlowTest extends TestCase
{
    use RefreshDatabase;

    private function customer(): Customer
    {
        return Customer::create([
            'username' => 'customer1',
            'nama' => 'Customer Satu',
            'email' => 'customer1@example.com',
            'alamat' => 'Jakarta',
            'nohp' => '081200000001',
            'password' => bcrypt('secret123'),
        ]);
    }

    private function mobil(): Mobil
    {
        return Mobil::create([
            'nopol' => 'B 1234 ABC',
            'nama_mobil' => 'Toyota Avanza',
            'type' => 'MPV',
            'tgl_pjk' => '2026-12-31',
            'status' => 'TERSEDIA',
            'warna' => 'Putih',
            'sewa' => 300000,
            'foto' => 'foto-mobil/avanza.jpg',
        ]);
    }

    private function supir(): Supir
    {
        return Supir::create([
            'noktp' => '3201012345678901',
            'nama' => 'Agus',
            'alamat' => 'Jakarta',
            'nohpsupir' => '081200000002',
            'image' => 'foto-supir/agus.jpg',
            'sewa' => 150000,
            'status' => 'TERSEDIA',
        ]);
    }

    public function test_guest_is_redirected_from_sewa_form(): void
    {
        $this->get('/sewa')->assertRedirect('/login');
    }

    public function test_booking_ignores_tampered_total_and_computes_server_side(): void
    {
        $this->mobil();
        $this->supir();
        $customer = $this->customer();

        $response = $this->actingAs($customer, 'web')->post('/sewa', [
            'mobil' => 'Toyota Avanza',
            'supir' => 'Agus',
            'durasi' => 24,
            'tgl_pjm' => date('Y-m-d H:i', strtotime('+1 day 08:00')),
            'total' => 1,
        ]);

        $response->assertRedirect('/invoice');

        $sewa = Sewa::first();
        $this->assertNotNull($sewa);
        $this->assertSame('450000', (string) $sewa->total_biaya);
        $this->assertEquals($customer->id, $sewa->customer_id);
        $this->assertStringStartsWith('RNT', $sewa->no_invoice);
    }

    public function test_overlapping_booking_is_rejected(): void
    {
        $this->mobil();
        $this->supir();
        $customer = $this->customer();

        $from = Carbon::parse('+1 day 08:00');
        $to = Carbon::parse('+2 day 08:00');

        Sewa::create([
            'no_invoice' => 'RNT00001',
            'customer_id' => null,
            'nama_customer' => 'Customer',
            'nohp' => '081200000099',
            'alamat' => 'Jakarta',
            'nama_mobil' => 'Toyota Avanza',
            'nopol' => 'B 1234 ABC',
            'nama_supir' => 'Agus',
            'tanggal_pinjam' => $from->format('Y-m-d H:i:s'),
            'tanggal_kembali' => $to->format('Y-m-d H:i:s'),
            'jaminan' => 'KTP',
            'total_biaya' => '450000',
            'verifikasi' => 'Requested',
            'bukti' => null,
        ]);

        $response = $this->actingAs($customer, 'web')->post('/sewa', [
            'mobil' => 'Toyota Avanza',
            'supir' => 'Agus',
            'durasi' => 24,
            'tgl_pjm' => $from->format('Y-m-d H:i'),
        ]);

        $response->assertSessionHasErrors('mobil');
        $this->assertSame(1, Sewa::count());
    }
}
