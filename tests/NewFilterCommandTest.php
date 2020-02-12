<?php

namespace tiagomichaelsousa\LaravelFilters\Tests;

use Illuminate\Support\Facades\File;
use tiagomichaelsousa\LaravelFilters\Commands\NewFilterCommand;
use tiagomichaelsousa\LaravelFilters\Exceptions\File as ExceptionsFile;
use tiagomichaelsousa\LaravelFilters\Tests\TestCase;

class NewFilterCommandTest extends TestCase
{

    /** @test */
    public function it_creates_the_filter_in_the_config_namespace()
    {
        $this->artisan('make:filter', ['name' => $class = 'UserFilter'])
            ->expectsOutput('Filter created successfully 🚀')
            ->assertExitCode(NewFilterCommand::EXIT_CODE_SUCCESS);


        $this->assertFalse(File::exists(app_path("/{$class}.php")));
    }

    /** @test */
    public function it_returns_an_exception_if_the_filter_already_exits()
    {
        $this->artisan('make:filter', ['name' => $class = 'UserFilter'])
                    ->expectsOutput('Filter created successfully 🚀')
                    ->assertExitCode(NewFilterCommand::EXIT_CODE_SUCCESS);

        
        $this->artisan('make:filter', ['name' => $class = 'UserFilter'])
                    ->expectsOutput("The filter {$class} already exists!")
                    ->assertExitCode(NewFilterCommand::EXIT_CODE_ERROR);
    }
}
