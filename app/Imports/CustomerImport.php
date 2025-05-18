<?php
namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class CustomerImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Customer([
            'id' => 'C' . strtoupper(Str::random(8)),
            'name' => $row['name'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
            'nik' => $row['nik'],
            'photo' => null, // Tidak bisa import gambar via Excel
            'address' => $row['address'],
            'phone' => $row['phone'],
            'installation_date' => $row['installation_date'],
            'network_type' => $row['network_type'],
            'package_id' => $row['package_id'], // Pastikan ID paket valid
            'status' => $row['status'],
        ]);
    }
}
