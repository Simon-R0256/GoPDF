<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        //Admins

        User::create([
            'username' => 'Administrator',
            'email' => 'admin@gmx.de',
            'password' => Hash::make('123'),
            'role' => 'Admin'
        ]);

        //User

        User::create([
            'username' => 'Max',
            'email' => 'max@gmx.de',
            'password' => Hash::make('123'),
            'role' => 'Redakteur',
            'created_at' => '2020-02-07 12:44:15'
        ]);
        User::create([
            'username' => 'Robert',
            'email' => 'rober@roberto.de',
            'password' => Hash::make('test'),
            'role' => 'Redakteur'
        ]);
        User::create([
            'username' => 'Lisa',
            'email' => 'lisa@lisanne.de',
            'password' => Hash::make('test'),
            'role' => 'Redakteur'
        ]);
        User::create([
            'username' => 'Theo',
            'email' => 'theo@westphal.de',
            'password' => Hash::make('test'),
            'role' => 'Redakteur'
        ]);
    }
}
