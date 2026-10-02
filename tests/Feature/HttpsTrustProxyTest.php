<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class HttpsTrustProxyTest extends TestCase
{
    use RefreshDatabase;

    public function test_trusted_proxy_recognizes_forwarded_https_header(): void
    {
        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
            'X-Forwarded-Host' => 'brickbeam-construction-management-system-production.up.railway.app',
            'X-Forwarded-Port' => '443',
        ])->get('/');

        $response->assertStatus(200);

        // Verify that the request within Laravel was treated as secure HTTPS
        $this->assertTrue(request()->isSecure());
        $this->assertEquals('https', request()->getScheme());
        $this->assertEquals('brickbeam-construction-management-system-production.up.railway.app', request()->getHost());

        // Verify that URL generator generates HTTPS URLs for incoming HTTPS proxy requests
        $this->assertStringStartsWith('https://brickbeam-construction-management-system-production.up.railway.app', url('/login'));
    }

    public function test_url_force_scheme_enforces_https(): void
    {
        URL::forceScheme('https');

        $generatedUrl = url('/login');

        $this->assertStringStartsWith('https://', $generatedUrl);
    }
}
