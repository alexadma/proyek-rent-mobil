<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function customer(array $attrs = []): Customer
    {
        return Customer::create(array_merge([
            'username' => 'customer1',
            'nama' => 'Customer Satu',
            'email' => 'customer1@example.com',
            'alamat' => 'Jakarta',
            'nohp' => '081200000001',
            'password' => bcrypt('secret123'),
        ], $attrs));
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_customers_can_authenticate_using_the_login_screen(): void
    {
        $this->customer();

        $response = $this->post('/login', [
            'username' => 'customer1',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticated('web');
        $response->assertRedirect(route('home'));
    }

    public function test_admin_can_authenticate_using_the_login_screen(): void
    {
        Admin::create([
            'username' => 'admin1',
            'nama' => 'Admin',
            'alamat' => 'Jakarta',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'username' => 'admin1',
            'password' => 'secret123',
        ]);

        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('home.admin'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $this->customer();

        $this->post('/login', [
            'username' => 'customer1',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = $this->customer();

        $response = $this->actingAs($user, 'web')->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/home');
    }

    public function test_login_is_throttled_after_multiple_failed_attempts(): void
    {
        $this->customer();

        foreach (range(1, 5) as $i) {
            $this->post('/login', [
                'username' => 'customer1',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post('/login', [
            'username' => 'customer1',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }
}
