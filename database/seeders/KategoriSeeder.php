<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriData = [
            ['kategori_kode' => 'KAT1', 'kategori_nama' => 'Kategori 1'],
            ['kategori_kode' => 'KAT2', 'kategori_nama' => 'Kategori 2'],
            ['kategori_kode' => 'KAT3', 'kategori_nama' => 'Kategori 3'],
            ['kategori_kode' => 'KAT4', 'kategori_nama' => 'Kategori 4'],
            ['kategori_kode' => 'KAT5', 'kategori_nama' => 'Kategori 5'],
        ];

        DB::table('m_kategori')->insert($kategoriData);
    }
}
