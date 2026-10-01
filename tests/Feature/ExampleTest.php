<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_health_check_endpoint_returns_successful_response(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }

    public function test_health_check_endpoint_fails_when_database_is_unreachable(): void
    {
        $fail = true;
        $realDb = $this->app['db'];

        \Illuminate\Support\Facades\DB::shouldReceive('connection')->andReturnUsing(function ($name = null) use ($realDb, &$fail) {
            if ($fail) {
                throw new \PDOException('Simulated database connection failure');
            }
            return $realDb->connection($name);
        });

        config(['app.debug' => false]);

        $response = $this->get('/up');

        $response->assertStatus(500);

        $fail = false;
    }
}
