<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['first_name' => 'John', 'last_name' => 'Admin', 'name' => 'John Admin', 'email' => 'admin@gmail.com', 'role' => 'admin'],
            ['first_name' => 'Mark', 'last_name' => 'Supervisor', 'name' => 'Mark Supervisor', 'email' => 'supervisor@gmail.com', 'role' => 'supervisor'],
            ['first_name' => 'Pedro', 'last_name' => 'Mechanic', 'name' => 'Pedro Mechanic', 'email' => 'mechanic@gmail.com', 'role' => 'mechanic'],
        ];
        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data + ['middle_name' => null, 'password' => '03132006']);
        }
    }
}
