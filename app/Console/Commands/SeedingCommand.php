<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class SeedingCommand
 *
 * @package App\Console\Commands
 */
class SeedingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute seed class like a migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $disk = Storage::disk('root');
        $ran = collect(DB::select("select * from seeding order by batch asc,seeder asc;"))->pluck('seeder')->all();
        $files = collect($disk->allFiles('database/seeds/update'))
            ->filter()->values()->keyBy(function ($file) {
                return $this->getSeederName($file);
            })->sortBy(function ($file, $key) {
                return $key;
            })->reject(function ($file) use ($ran) {
                return in_array($this->getSeederName($file), $ran);
            })->values()->all();

        if (count($files) === 0) {
            $this->info('Nothing to seed');
            return;
        }

        $batchId = $this->getLastBatchNumber() + 1;
        foreach ($files as $file) {
            $file = $this->getSeederName($file);
            $this->comment("Seeding: $file");
            $startTime = microtime(true);

            $seeder = $this->resolve($file);
            $seeder->run();
            DB::insert("insert into seeding (`seeder`,`batch`) value ('$file','$batchId')");

            $runTime = round(microtime(true) - $startTime, 2);
            $this->info("Seeded: $file ($runTime seconds)");
        }
    }

    /**
     * Get the name of the migration.
     *
     * @param string $path
     *
     * @return string
     */
    public function getSeederName($path)
    {
        return str_replace('.php', '', basename($path));
    }

    /**
     * Get the last migration batch number.
     *
     * @return int
     */
    public function getLastBatchNumber()
    {
        return DB::select("select max(batch) batch from seeding order by batch asc,seeder asc;")[0]->batch;
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param string $file
     *
     * @return object
     */
    public function resolve($file)
    {
        $class = Str::studly(implode('_', array_slice(explode('_', $file), 4)));

        return new $class;
    }
}
