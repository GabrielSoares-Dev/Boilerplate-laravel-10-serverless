<?php

namespace Infra\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareDatabase extends Command
{
    protected $signature = 'db:prepare';

    protected $description = 'Prepare database';

    public function handle()
    {
        try {
            $this->info('Start Prepare DB...');
            $databaseName = env('DB_DATABASE');
            $connection = env('DB_CONNECTION');

            config(["database.connections.$connection.database" => null]);
            DB::reconnect();

            $this->info('Creating database...');
            DB::connection($connection)->statement("CREATE DATABASE IF NOT EXISTS `$databaseName`");
            $this->alert('Database created');

            config(["database.connections.$connection.database" => $databaseName]);
            DB::reconnect();

            $this->call('migrate');

            $this->call('db:seed');

            $this->alert('Database prepared');

        } catch (Exception $error) {
            $this->error("error: $error->getMessage()");
        }
    }
}
