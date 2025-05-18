<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Operator
        if (!Admin::where('email', 'operator@example.com')->exists()) {
            Admin::create([
                'id' => 'A' . strtoupper(Str::random(8)),
                'name' => 'Admin Operator',
                'email' => 'operator@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567891'
            ]);
        }
    }
}
