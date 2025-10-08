<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_offices')->insert([
            ['office_name' => 'Pekanbaru | Cempedak I', 'address' => 'Jl. Cempedak I No.3, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau, Indonesia'],
            ['office_name' => 'Pekanbaru | Delima', 'address' => 'Jl. Delima, Delima, Kec. Tampan, Kota Pekanbaru, Riau, Indonesia'],
            ['office_name' => 'Lampung | KS. Tubun', 'address' => 'Jl. KS. Tubun No.10, Rw. Laut, Kec. Tanjungkarang Timur, Kota Bandar Lampung, Lampung, Indonesia'],
        ]);
    }
}