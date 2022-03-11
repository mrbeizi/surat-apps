<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name'	=> 'administrator',
            'email'	=> 'admin'. '@gmail.com',
            'password'	=> bcrypt('123456')
        ]);
    }
}
