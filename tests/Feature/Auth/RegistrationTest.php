<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_customers_can_register(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'alamat' => 'Jakarta',
            'nohp' => '081300000001',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('customers', ['username' => 'testuser']);
    }

    public function test_short_passwords_are_rejected(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'alamat' => 'Jakarta',
            'nohp' => '081300000001',
            'password' => 'abc12',
            'password_confirmation' => 'abc12',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('customers', ['username' => 'testuser']);
    }
}
