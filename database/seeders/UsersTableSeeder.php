<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Tagihan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        'nama'  => 'Norman',
        'inisial' => 'NN',
        'email' => 'norman.primary@gmail.com',
        'telepon' => '08123456789',
        'jabatan' => 'Kepala IT',
        'is_superadmin' => 1,
        'password'  => Hash::make('123456')
        ]);

        User::create([
        'nama'  => 'Fulan',
        'inisial' => 'FL',
        'email' => 'fulan@gmail.com',
        'telepon' => '08234567890',
        'jabatan' => 'Staff Keuangan',
        'is_superadmin' => 0,
        'password'  => Hash::make('123456')
        ]);
        
        Client::create([
            'nama' => 'PT. Mustika Batu Alam',
            'sapaan' => 'Pimpinan',
            'alamat' => 'Jl. Soedirman No. 15',
            'email' => 'it@mustikabatu.id'
        ]);

        Client::create([
            'nama' => 'PT. Soe Kok Wang',
            'sapaan' => 'Kepala IT',
            'alamat' => 'Jl. Hasanudin No. 30',
            'email' => 'mail@soekok.id'
        ]);

        ServiceCategory::create([
            'nama' => 'VPN'
        ]);

        ServiceCategory::create([
            'nama' => 'Hosting'
        ]);

        ServiceCategory::create([
            'nama' => 'Internet'
        ]);

        Service::create([
            'nama' => 'VPN SG 2TB',
            'harga' => 20000,
            'kategori' => 1
        ]);

        Service::create([
            'nama' => 'VPN ID 2TB',
            'harga' => 40000,
            'kategori' => 1
        ]);

        Service::create([
            'nama' => 'Hosting SG 2GB',
            'harga' => 40000,
            'kategori' => 2
        ]);

        Service::create([
            'nama' => 'Hosting IIX 2GB',
            'harga' => 60000,
            'kategori' => 2
        ]);

        Transaction::create([
            'date' => '2022/2/23',
            'user_id' => 1,
            'client_id' => 1,
            'service_id' => 1
        ]);

        Transaction::create([
            'date' => '2022/3/17',
            'user_id' => 1,
            'client_id' => 1,
            'service_id' => 2
        ]);

        Tagihan::create([
            'reff' => '001',
            'invoice_date' => '2022/2/24',
            'due_date' => '2022/3/6',
            'start_date' => '2022/2/27',
            'end_date' => '2022/3/26',
            'total_harga' => '200000',
            'transaction_id' => 1,
            'user_id' => 1
        ]);

    }
}
