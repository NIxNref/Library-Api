<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                // 'name' => 'Ann',
                // 'role_status' => 'user',
                // 'email' => 'ann@gmail.com',
                // 'password' => Hash::make('ann12345'),
                // 'is_deleted' => 0,
                // 'created_at' => now(),
                // 'updated_at' => now()
                'name' => 'petugas',
                'role_status' => 'petugas',
                'email' => 'panji1@gmail.com',
                'password' => Hash::make('panji123'),
                'is_deleted' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        foreach ($data as $val) {
            User::insert([
                'name' => $val['name'],
                'role_status' => $val['role_status'],
                'email' => $val['email'],
                'password' => $val['password'],
                'is_deleted' => $val['is_deleted'],
                'created_at' => $val['created_at'],
                'updated_at' => $val['updated_at']
            ]);
        }
    }
}
