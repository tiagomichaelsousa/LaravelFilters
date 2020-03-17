<?php

namespace tiagomichaelsousa\LaravelFilters\Tests;

use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;
use tiagomichaelsousa\LaravelFilters\Tests\Models\User;
use tiagomichaelsousa\LaravelFilters\LaravelFiltersServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * The users that will be seeded.
     *
     * @var array
     */
    private $users = [
        ['name' => 'John', 'last_name' => 'Doe'],
        ['name' => 'Jane', 'last_name' => 'Doe'],
        ['name' => 'Foo', 'last_name' => 'Bar'],
        ['name' => 'Foo', 'last_name' => null],
    ];

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->initialize();
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }


    /**
    * Define environment setup.
    *
    * @param  \Illuminate\Foundation\Application $app
    * @return void
    */
    protected function getEnvironmentSetUp($app)
    {
        // set up database configuration
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    /**
     * Create the test suite default folder structure.
     *
     * @return void
     */
    private function initialize()
    {
        $this->artisan('migrate', ['--database' => 'testbench']);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');
            File::cleanDirectory(app_path());
        });

        $this->createUsers();
    }

    /**
    * Seed the users table for the test env.
    *
    * @return void
    */
    private function createUsers()
    {
        foreach ($this->users as $user) {
            User::create(['name' => $user['name'], 'last_name' => $user['last_name']]);
        }
    }

    /**
     * Create the test suite default folder structure.
     *
     * @return void
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelFiltersServiceProvider::class,
            TestServiceProvider::class
        ];
    }
}
