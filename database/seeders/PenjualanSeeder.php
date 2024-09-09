<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualanData = [
            ['user_id' => 1, 'pembeli' => 'Pembeli 1', 'penjualan_kode' => 'PJ12345', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 2', 'penjualan_kode' => 'PJ12346', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 3', 'penjualan_kode' => 'PJ12347', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 4', 'penjualan_kode' => 'PJ12348', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 5', 'penjualan_kode' => 'PJ12349', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 6', 'penjualan_kode' => 'PJ12350', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 7', 'penjualan_kode' => 'PJ12351', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 8', 'penjualan_kode' => 'PJ12352', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 9', 'penjualan_kode' => 'PJ12353', 'penjualan_tanggal' => now()],
            ['user_id' => 1, 'pembeli' => 'Pembeli 10', 'penjualan_kode' => 'PJ12354', 'penjualan_tanggal' => now()],
        ];

        DB::table('t_penjualan')->insert($penjualanData);
    }
}
