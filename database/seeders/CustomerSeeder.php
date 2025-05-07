<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Memastikan ada package yang tersedia untuk customer
        $package = Package::first();
        
        if (!$package) {
            // Jika tidak ada package, buat package default
            $package = Package::create([
                'name' => 'Paket Basic',
                'price' => 150000,
                'description' => 'Paket internet basic dengan kecepatan 10 Mbps',
                'duration' => 30, // 30 hari
            ]);
        }

        // Customer 1
        if (!Customer::where('email', 'budi@example.com')->exists()) {
            Customer::create([
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
                'nik' => '3201012345678901',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'phone' => '081234567892',
                'installation_date' => Carbon::now(),
                'network_type' => 'Fiber', // Mengubah dari 'Fiber Optik' ke 'Fiber'
                'package_id' => $package->id,
                'role' => 'customer',
                'status' => 'active'
            ]);
        }

        // Customer 2
        if (!Customer::where('email', 'siti@example.com')->exists()) {
            Customer::create([
                'name' => 'Siti Rahma',
                'email' => 'siti@example.com',
                'password' => Hash::make('password'),
                'nik' => '3201012345678902',
                'address' => 'Jl. Pahlawan No. 45, Bandung',
                'phone' => '081234567893',
                'installation_date' => Carbon::now()->subDays(15),
                'network_type' => 'Fiber', // Mengubah dari 'Fiber Optik' ke 'Fiber'
                'package_id' => $package->id,
                'role' => 'customer',
                'status' => 'active'
            ]);
        }

        // Customer 3
        if (!Customer::where('email', 'ahmad@example.com')->exists()) {
            Customer::create([
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'nik' => '3201012345678903',
                'address' => 'Jl. Diponegoro No. 78, Surabaya',
                'phone' => '081234567894',
                'installation_date' => Carbon::now()->subDays(25),
                'network_type' => 'Wireless',
                'package_id' => $package->id,
                'role' => 'customer',
                'status' => 'active'
            ]);
        }
    }
}
