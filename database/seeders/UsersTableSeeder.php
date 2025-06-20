<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        DB::table('users')->insert([
            [
                'name' => '片岡',
                'email' => 'kataoka@gmail.com',
                'password' => Hash::make('11111111'),
            ],
            [
                'name' => '佳代子',
                'email' => 'kayoko@gmail.com',
                'password' => Hash::make('11111111'),
            ],
        ]);
    }
}
