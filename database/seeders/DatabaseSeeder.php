<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'username' => 'admin',
            'password' => bcrypt('12341234'),
            'role' => 'opr',
        ]);

        $lokasi = Lokasi::create([
            'nama_lokasi' => 'SMK YPC Tasikmalaya'
        ]);

        Pegawai::create([
            'nip' => '0987654321234567',
            'user_id' => $user->id,
            'lokasi_id' => $lokasi->id,
            'nama' => 'nabilah',
            'alamat' => 'Jl. Tasikmalaya',
        ]);
    }
}
