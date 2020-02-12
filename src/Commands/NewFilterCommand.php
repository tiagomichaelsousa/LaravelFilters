<?php

namespace tiagomichaelsousa\LaravelFilters\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class NewFilterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter
                            {name : The name for the query filter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter for eloquent model';

    /**
     * The name of the filter class.
     *
     * @var array
     */
    private $class;

    /**
     * The success exit code.
     *
     * @var int
     */
    public const EXIT_CODE_SUCCESS = 1;

    /**
     * The error exit code.
     *
     * @var int
     */
    public const EXIT_CODE_ERROR = -1;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->class = $this->argument('name');

        $directory = $this->namespace_path(config('laravel-filters.namespace'));
        $path = "{$directory}/{$this->class}.php";

        if (File::exists($path)) {
            $this->error("The filter {$this->class} already exists!");

            return self::EXIT_CODE_ERROR;
        }

        $this->directoryExists($directory);

        $replaces = $this->replacements();
        $stub = str_replace(array_keys($replaces), array_values($replaces), $this->getStub());

        file_put_contents($path, $stub);

        $this->line('');
        $this->info('Filter created successfully 🚀');

        return self::EXIT_CODE_SUCCESS;
    }

    /**
     * Verify if the directory and create one if it doesn't.
     *
     * @param string $path
     * @return bool
     */
    private function directoryExists(string $path)
    {
        return (bool) File::isDirectory($path) ?: File::makeDirectory($path);
    }

    /**
     * Receive a namespace and convert it to a path.
     *
     * @param  string  $path
     * @return string
     */
    private function namespace_path(string $path)
    {
        return base_path(lcfirst(str_replace('\\', '/', $path)));
    }

    /**
     * Get the Stub for the request.
     *
     * @return string
     */
    public function getStub()
    {
        return File::get(__DIR__.'/../Stubs/filter.stub');
    }

    /**
     * Get the replacements for the stub.
     *
     * @return array
     */
    public function replacements()
    {
        return array_merge([
            '{{NAMESPACE}}' => config('laravel-filters.namespace'),
            '{{CLASS_NAME}}' => "{$this->class}",
        ]);
    }
}
