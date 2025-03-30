<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // SEEDER USER
        DB::table('users')->insert([
            'name' => 'Yusar Brian Sadella',
            'username' => 'yusrb',
            'email' => 'byrn.uiy@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        // SEEDER SETTINGS
        DB::table('settings')->insert([
            'name_website' => 'SkandaKra Inv.',
            'tagline' => 'Sistem Inventaris Lab',
            'logo' => 'smkn02kra.jpg'
        ]);

        // SEEDER KATEGORI
        DB::table('kategoris')->insert([
            [
                'name_kategori' => 'Cpu'
            ],
            [
                'name_kategori' => 'Monitor'
            ],
            [
                'name_kategori' => 'Mouse'
            ],
            [
                'name_kategori' => 'Keyboard'
            ],
            [
                'name_kategori' => 'Meja'
            ],
            [   
                'name_kategori' => 'Kursi'
            ],
        ]
    );

    // SEEDER SUPPLIER
    DB::table('suppliers')->insert([
        'name_supplier' => 'Orang inc.',
        'kontak' => '0895323955552',
        'alamat' => 'Bolong',
    ]);
    }
}
