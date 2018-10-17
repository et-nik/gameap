<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login'         => 'admin',
            'email'         => 'admin@yousite.local',
            'password'      => '$2a$10$Fke.QmsyW3p0hEyCGXbIaeh3xkKEQwjyxH7syHdVxl68FRlho5KVq', // fpwPOuZD
            'name'          => 'Admin',
        ]);
    }
}
