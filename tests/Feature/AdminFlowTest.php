<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Mobil;
use App\Models\Sewa;
use App\Models\Supir;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFlowTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Admin
    {
        return Admin::create([
            'username' => 'admin1',
            'nama' => 'Admin',
            'alamat' => 'Jakarta',
            'password' => bcrypt('secret123'),
        ]);
    }

    private function transaksi(): Sewa
    {
        return Sewa::create([
            'no_invoice' => 'RNT00001',
            'customer_id' => null,
            'nama_customer' => 'Customer',
            'nohp' => '081200000099',
            'alamat' => 'Jakarta',
            'nama_mobil' => 'Toyota Avanza',
            'nopol' => 'B 1234 ABC',
            'nama_supir' => 'Agus',
            'tanggal_pinjam' => '2026-10-01 08:00:00',
            'tanggal_kembali' => '2026-10-02 08:00:00',
            'jaminan' => 'KTP',
            'total_biaya' => '450000',
            'verifikasi' => 'Requested',
            'bukti' => null,
        ]);
    }

    private function mobil(string $status = 'TERSEDIA'): Mobil
    {
        return Mobil::create([
            'nopol' => 'B 1234 ABC',
            'nama_mobil' => 'Toyota Avanza',
            'type' => 'MPV',
            'tgl_pjk' => '2026-12-31',
            'status' => $status,
            'warna' => 'Putih',
            'sewa' => 300000,
            'foto' => 'foto-mobil/avanza.jpg',
        ]);
    }

    private function supir(string $status = 'TERSEDIA'): Supir
    {
        return Supir::create([
            'noktp' => '3201012345678901',
            'nama' => 'Agus',
            'alamat' => 'Jakarta',
            'nohpsupir' => '081200000002',
            'image' => 'foto-supir/agus.jpg',
            'sewa' => 150000,
            'status' => $status,
        ]);
    }

    public function test_guest_is_redirected_from_admin_area(): void
    {
        $this->get('/transaksi')->assertRedirect('/login');
    }

    public function test_customer_cannot_approve_transaction(): void
    {
        Customer::create([
            'username' => 'customer1',
            'nama' => 'Customer Satu',
            'email' => 'customer1@example.com',
            'alamat' => 'Jakarta',
            'nohp' => '081200000001',
            'password' => bcrypt('secret123'),
        ]);
        $transaksi = $this->transaksi();

        $this->actingAs(Customer::first(), 'web')
            ->post('/approve_transaksi/'.$transaksi->id)
            ->assertRedirect('/login');

        $this->assertSame('Requested', $transaksi->fresh()->verifikasi);
    }

    public function test_approve_uses_post_and_marks_car_as_disewa(): void
    {
        $this->mobil();
        $this->supir();
        $transaksi = $this->transaksi();

        $this->actingAs($this->admin(), 'admin')
            ->post('/approve_transaksi/'.$transaksi->id)
            ->assertSessionHasNoErrors();

        $this->assertSame('DITERIMA', $transaksi->fresh()->verifikasi);
        $this->assertSame('DISEWA', Mobil::where('nama_mobil', 'Toyota Avanza')->first()->status);
    }

    public function test_get_approve_route_is_not_allowed(): void
    {
        $transaksi = $this->transaksi();

        $this->actingAs($this->admin(), 'admin')
            ->get('/approve_transaksi/'.$transaksi->id)
            ->assertStatus(405);
    }

    public function test_pengembalian_marks_car_available_again(): void
    {
        $this->mobil('DISEWA');
        $this->supir('DISEWA');
        $transaksi = $this->transaksi();
        $transaksi->update(['verifikasi' => 'DITERIMA']);

        $this->actingAs($this->admin(), 'admin')
            ->post('/pengembalian/'.$transaksi->id)
            ->assertRedirect();

        $this->assertSame('SELESAI', Sewa::find($transaksi->id)->verifikasi);
        $this->assertSame('TERSEDIA', Mobil::where('nama_mobil', 'Toyota Avanza')->first()->status);
        $this->assertSame('TERSEDIA', Supir::where('nama', 'Agus')->first()->status);
    }
}
