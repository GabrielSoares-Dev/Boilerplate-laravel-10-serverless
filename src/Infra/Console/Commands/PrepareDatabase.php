<?php

namespace Infra\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareDatabase extends Command
{
    protected $signature = 'db:prepare';

    protected $description = 'Prepare database';

    public function handle()
    {
        try {
            $bar = $this->output->createProgressBar(3);
            $this->info('Start Prepare DB...');
            $databaseName = env('DB_DATABASE');
            $connection = env('DB_CONNECTION');

            config(["database.connections.$connection.database" => null]);
            DB::reconnect();

            $this->info('Creating database...');
            DB::connection($connection)->statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");
            $this->alert('Database created');
            $bar->advance();

            config(["database.connections.$connection.database" => $databaseName]);
            DB::reconnect();

            $this->call('migrate');
            $bar->advance(2);

            $this->call('db:seed');
            $bar->advance(3);

            $bar->finish();
            $this->alert('Database prepared');

        } catch (Exception $error) {
            $this->error("error: $error->getMessage()");
        }
    }
}
