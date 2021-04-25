<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
    DB::table('users')->insert([
    'name' => 'amarsoni',
    'email' => 'test@gmail.com',
    'mobile'=> '9988776655',
    'password' => Hash::make('password')
]);
    }
}
