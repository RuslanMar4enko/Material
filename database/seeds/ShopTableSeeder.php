<?php

use Illuminate\Database\Seeder;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'user_id' => '1',
                'company_name' => 'Test',
                'full_name' => 'Test',
                'phone_number' => '0992581965',
            ],

            [
                'user_id' => '1',
                'company_name' => 'Test2',
                'full_name' => 'Test2',
                'phone_number' => '0992581965',
            ],
        ]);
    }
}
