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
             GamesTableSeeder::class,
             GameModsTableSeeder::class,
             UsersTableSeeder::class,
             PermissionsSeeder::class,
         ]);
    }
}
