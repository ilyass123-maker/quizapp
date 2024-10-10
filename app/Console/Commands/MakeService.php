<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    // Command signature and description
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';

    // FileSystem object to interact with the file system
    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        // Get the name of the service from the command argument
        $name = $this->argument('name');
        $path = $this->getPath($name);

        // Check if the service class already exists
        if ($this->files->exists($path)) {
            $this->error("Service class {$name} already exists!");
            return false;
        }

        // Create the directory if it doesn't exist
        $this->makeDirectory($path);

        // Generate the service class file
        $this->files->put($path, $this->buildClass($name));

        $this->info("Service class {$name} created successfully.");
    }

    protected function getPath($name)
    {
        // Path where the service class will be created
        return base_path('app/Services') . '/' . $name . '.php';
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function buildClass($name)
    {
        // Stub for the service class
        $stub = "<?php\n\nnamespace App\Services;\n\nclass {$name}\n{\n    public function __construct()\n    {\n        // Constructor\n    }\n\n    public function someMethod()\n    {\n        // Service logic\n    }\n}";

        return $stub;
    }
}
