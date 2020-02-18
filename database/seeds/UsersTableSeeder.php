<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'name' => 'admin',
                'email' => 'admin@green-conseil.com',
                'password' => bcrypt('qweasd'),
            ],
            [
                'name' => 'user',
                'email' => 'user@green-conseil.com',
                'password' => bcrypt('qweasd'),
            ],

            [
                'name' => 'user1',
                'email' => 'user@green-conseil1.com',
                'password' => bcrypt('qweasd'),
            ]
        ]);

    }
}
