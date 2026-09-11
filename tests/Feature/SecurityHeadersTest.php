<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_sent_on_responses(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy');
        $response->assertHeader('Content-Security-Policy');
    }

    public function test_ignition_routes_are_not_blocked_in_local(): void
    {
        $this->app['env'] = 'local';

        $this->get('/_ignition/health-check')->assertOk();
    }

    public function test_ignition_routes_are_blocked_in_production(): void
    {
        $this->app['env'] = 'production';

        $this->get('/_ignition/health-check')->assertNotFound();
        $this->post('/_ignition/update-config')->assertNotFound();
    }

    public function test_production_blocks_ignition_even_when_runnable_solutions_enabled(): void
    {
        $this->app['env'] = 'production';
        config(['ignition.enable_runnable_solutions' => true]);

        $this->get('/_ignition/health-check')->assertNotFound();
    }

    public function test_https_requests_receive_hsts(): void
    {
        $this->get('https://localhost/login')
            ->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }
}
