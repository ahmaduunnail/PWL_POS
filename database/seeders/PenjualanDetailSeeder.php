<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penjualanDetailData = [
            ['penjualan_id' => 1, 'barang_id' => 1, 'harga' => 15000, 'jumlah' => 2],
            ['penjualan_id' => 1, 'barang_id' => 2, 'harga' => 25000, 'jumlah' => 1],
            ['penjualan_id' => 1, 'barang_id' => 3, 'harga' => 35000, 'jumlah' => 3],
            ['penjualan_id' => 2, 'barang_id' => 4, 'harga' => 45000, 'jumlah' => 1],
            ['penjualan_id' => 2, 'barang_id' => 5, 'harga' => 55000, 'jumlah' => 2],
            ['penjualan_id' => 3, 'barang_id' => 6, 'harga' => 65000, 'jumlah' => 1],
            ['penjualan_id' => 3, 'barang_id' => 7, 'harga' => 75000, 'jumlah' => 1],
            ['penjualan_id' => 3, 'barang_id' => 8, 'harga' => 85000, 'jumlah' => 2],
            ['penjualan_id' => 4, 'barang_id' => 9, 'harga' => 95000, 'jumlah' => 3],
            ['penjualan_id' => 4, 'barang_id' => 10, 'harga' => 105000, 'jumlah' => 1],
            ['penjualan_id' => 5, 'barang_id' => 11, 'harga' => 115000, 'jumlah' => 2],
            ['penjualan_id' => 5, 'barang_id' => 12, 'harga' => 125000, 'jumlah' => 1],
            ['penjualan_id' => 5, 'barang_id' => 13, 'harga' => 135000, 'jumlah' => 2],
            ['penjualan_id' => 6, 'barang_id' => 14, 'harga' => 145000, 'jumlah' => 1],
            ['penjualan_id' => 6, 'barang_id' => 15, 'harga' => 155000, 'jumlah' => 3],
            ['penjualan_id' => 7, 'barang_id' => 1, 'harga' => 15000, 'jumlah' => 1],
            ['penjualan_id' => 7, 'barang_id' => 2, 'harga' => 25000, 'jumlah' => 2],
            ['penjualan_id' => 7, 'barang_id' => 3, 'harga' => 35000, 'jumlah' => 1],
            ['penjualan_id' => 8, 'barang_id' => 4, 'harga' => 45000, 'jumlah' => 3],
            ['penjualan_id' => 8, 'barang_id' => 5, 'harga' => 55000, 'jumlah' => 2],
            ['penjualan_id' => 8, 'barang_id' => 6, 'harga' => 65000, 'jumlah' => 1],
            ['penjualan_id' => 9, 'barang_id' => 7, 'harga' => 75000, 'jumlah' => 1],
            ['penjualan_id' => 9, 'barang_id' => 8, 'harga' => 85000, 'jumlah' => 2],
            ['penjualan_id' => 9, 'barang_id' => 9, 'harga' => 95000, 'jumlah' => 3],
            ['penjualan_id' => 10, 'barang_id' => 10, 'harga' => 105000, 'jumlah' => 1],
            ['penjualan_id' => 10, 'barang_id' => 11, 'harga' => 115000, 'jumlah' => 2],
            ['penjualan_id' => 10, 'barang_id' => 12, 'harga' => 125000, 'jumlah' => 1],
            ['penjualan_id' => 10, 'barang_id' => 13, 'harga' => 135000, 'jumlah' => 1],
            ['penjualan_id' => 10, 'barang_id' => 14, 'harga' => 145000, 'jumlah' => 2],
            ['penjualan_id' => 10, 'barang_id' => 15, 'harga' => 155000, 'jumlah' => 3],
        ];

        DB::table('t_penjualan_detail')->insert($penjualanDetailData);
    }
}
