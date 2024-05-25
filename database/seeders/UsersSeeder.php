<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Owner',
                'username' => 'owner',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ],
            [
                'name' => 'Manager',
                'username' => 'manage',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Cashier',
                'username' => 'cashier',
                'password' => Hash::make('password'),
                'role' => 'cashier',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => $user['password'],
                'role' => $user['role'],
            ]);
        }
    }
}
