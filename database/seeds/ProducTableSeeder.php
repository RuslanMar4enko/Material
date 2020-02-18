<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProducTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@green-conseil.com',
                'password' => bcrypt('qweasd'),
            ],
        ]);
    }
}
