<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
             ClientCertificatesTableSeeder::class,
             DedicatedServersTableSeeder::class,
             GamesTableSeeder::class,
             GameModsTableSeeder::class,
             ServersTableSeeder::class,
             UsersTableSeeder::class,
             PermissionsSeeder::class,
         ]);
    }
}
