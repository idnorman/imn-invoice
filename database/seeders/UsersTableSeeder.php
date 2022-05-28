<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
    
    }
}
