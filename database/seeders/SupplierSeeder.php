<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplierData = [
            ['supplier_kode' => 'SUP1', 'supplier_nama' => 'Supplier 1', 'supplier_alamat' => 'Alamat Supplier 1', 'no_telp' => '0812345671'],
            ['supplier_kode' => 'SUP2', 'supplier_nama' => 'Supplier 2', 'supplier_alamat' => 'Alamat Supplier 2', 'no_telp' => '0812345672'],
            ['supplier_kode' => 'SUP3', 'supplier_nama' => 'Supplier 3', 'supplier_alamat' => 'Alamat Supplier 3', 'no_telp' => '0812345673'],
        ];

        DB::table('m_supplier')->insert($supplierData);
    }
}
