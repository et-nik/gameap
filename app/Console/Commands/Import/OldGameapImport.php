<?php

namespace Gameap\Console\Commands\Import;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Config;

class OldGameapImport extends Command
{
    protected $name = 'gameap:import-old';

    protected $description = 'Import and convert from old GameAP database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getOptions()
    {
        return [
            ['db-driver', null, InputOption::VALUE_OPTIONAL, 'Database Driver', 'mysql'],
            ['db-host', null, InputOption::VALUE_OPTIONAL, 'Database Host', 'localhost'],
            ['db-username', null, InputOption::VALUE_OPTIONAL, 'Database UserName', 'gameap'],
            ['db-password', null, InputOption::VALUE_OPTIONAL, 'Database Password'],
            ['db-name', null, InputOption::VALUE_OPTIONAL, 'Database Name', 'gameap'],
        ];
    }

    public function handle()
    {
        $dbDriver = $this->input->getOption('db-driver');
        $dbHost = $this->input->getOption('db-host');
        $dbUsername = $this->input->getOption('db-username');
        $dbPassword = $this->input->getOption('db-password');
        $dbName = $this->input->getOption('db-name');

        $this->info("Imported");

        Config::set('database.connections.temp', array(
            'driver'    => $dbDriver,
            'host'      => $dbHost,
            'database'  => $dbName,
            'username'  => $dbUsername,
            'password'  => $dbPassword,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));

        $dbOldGameap = DB::connection('temp');

        // Convert dedicated servers
        $dbOldGameap->table('dedicated_servers')->get();

        // Convert ds_stats
        // Rename ds_id to dedicated_server_id
        // Convert time. unixtime to time

        // Convert ds_users
        // Rename ds_id to dedicated_server_id

        // Convert game_mods
        // Rename aliases -> vars
    }
}