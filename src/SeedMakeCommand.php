<?php

namespace AmestSantim\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class SeedMakeCommand extends Command
{
    protected $signature = 'make:seeder-with-data 
                            {tableName : The name of the DB table} 
                            {data=[] : The data, as a named index array} 
                            {--path= : Path where the seeder file should be saved}';

    protected $description = 'Create a new database seeder-with-data class';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    protected function replaceClassName(&$stub, $name)
    {
        $stub = str_replace('{{class}}', $name, $stub);
        return $this;
    }

    protected function replaceDataArray(&$stub, $arr)
    {
        $stub = str_replace('{{dataArray}}', $arr, $stub);
        return $this;
    }

    protected function replaceTableName(&$stub, $name)
    {
        $stub = str_replace('{{table}}', $name, $stub);
        return $this;
    }

    protected function compileSeederStub($name)
    {
        $stub = $this->files->get(__DIR__ . '/stubs/seed.stub');

        $this->replaceClassName($stub, $name)
            ->replaceDataArray($stub, $this->argument('data'))
            ->replaceTableName($stub, $this->argument('tableName'));
        return $stub;
    }

    public function handle()
    {
        $name = ucwords(camel_case($this->argument('tableName'))) . 'TableSeeder';

        $path = ($this->option('path'))
            ? base_path().$this->option('path') . '/'. str_replace('\\', '/', $name) . '.php'
            : base_path().'/database/seeds/' . str_replace('\\', '/', $name) . '.php';

        $this->files->put($path, $this->compileSeederStub($name));

        $this->info('Seeder created successfully.');
    }
}