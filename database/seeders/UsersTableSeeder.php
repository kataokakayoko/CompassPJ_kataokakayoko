<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '片岡',
                'under_name' => '太郎',
                'over_name_kana' => 'カタオカ',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'kataoka@gmail.com',
                'sex' => 1,
                'birth_day' => '2002-04-03',
                'role' => 1,
                'password' => Hash::make('11111111'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'over_name' => '佐藤',
                'under_name' => '佳代子',
                'over_name_kana' => 'サトウ',
                'under_name_kana' => 'カヨコ',
                'mail_address' => 'kayoko@gmail.com',
                'sex' => 2,
                'birth_day' => '2002-04-03',
                'role' => 2,
                'password' => Hash::make('11111111'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
