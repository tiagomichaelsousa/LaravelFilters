<?php

namespace tiagomichaelsousa\LaravelFilters\Tests;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use tiagomichaelsousa\LaravelFilters\Tests\TestCase;
use tiagomichaelsousa\LaravelFilters\Tests\Models\User;
use tiagomichaelsousa\LaravelFilters\Tests\Filters\UserFilters;

class FiltersTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_returns_the_data_filtered()
    {
        /* register the route in the app */
        $router = $this->app->make(Registrar::class);
        $router->get('/users', function (UserFilters $filters) {
            return User::filter($filters)->resolve();
        });

        /* execute the request to the created route */
        $response = $this->get('/users?search=john');
        $response->assertSuccessful();
        $payload = $response->decodeResponseJson();

        $this->assertTrue($response->original instanceof Collection);
        $this->assertEquals(1, count($payload));
    }

    /** @test */
    public function it_returns_the_data_filtered_with_pagination()
    {
        $this->withoutExceptionHandling();

        /* register the route in the app */
        $router = $this->app->make(Registrar::class);
        $router->get('/users', function (UserFilters $filters) {
            return User::filter($filters)->resolve();
        });

        /* execute the request to the created route */
        $response = $this->get('/users?search=john&paginate=10');
        $response->assertSuccessful();
        $payload = $response->decodeResponseJson();

        $this->assertTrue($response->original instanceof LengthAwarePaginator);
        $this->assertEquals(1, $payload['total']);
    }

    /** @test */
    public function it_returns_the_matching_records()
    {
        $this->withoutExceptionHandling();

        /* register the route in the app */
        $router = $this->app->make(Registrar::class);
        $router->get('/users', function (UserFilters $filters) {
            return User::filter($filters)->resolve();
        });

        /* execute the request to the created route */
        $response = $this->get('/users?search=doe');
        $response->assertSuccessful();
        $payload = $response->decodeResponseJson();

        $this->assertEquals(2, count($payload));
    }
}
