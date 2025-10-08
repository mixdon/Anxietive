<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tb_package')->insert([
            [
                'judul_package' => 'BASIC STUDIO',
                'id_office' => 1,
                'times' => 30,
                'amount' => 80000,
                'image' => 'images/booking/BasicStudio001.jpeg',
                'detail_duration' => json_encode(["5 minutes get ready","15 minutes Self Photo","10 minutes Photo Selection"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'BASIC STUDIO',
                'id_office' => 2,
                'times' => 30,
                'amount' => 80000,
                'image' => 'images/booking/BasicStudio002.jpeg',
                'detail_duration' => json_encode(["5 minutes get ready","15 minutes Self Photo","10 minutes Photo Selection"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'BASIC STUDIO',
                'id_office' => 3,
                'times' => 30,
                'amount' => 80000,
                'image' => 'images/booking/BasicStudio003.jpeg',
                'detail_duration' => json_encode(["5 minutes get ready","15 minutes Self Photo","10 minutes Photo Selection"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'LARGE STUDIO',
                'id_office' => 1,
                'times' => 60,
                'amount' => 100000,
                'image' => 'images/booking/LargeStudio001.jpg',
                'detail_duration' => json_encode(["Self Photo Studio Pekanbaru"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'RED THEATER STUDIO',
                'id_office' => 2,
                'times' => 30,
                'amount' => 90000,
                'image' => 'images/booking/RedTheaterStudio001.jpeg',
                'detail_duration' => json_encode(["5 minutes get ready","15 minutes Self Photo","10 minutes Photo Selection"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'RED STUDIO',
                'id_office' => 1,
                'times' => 15,
                'amount' => 60000,
                'image' => 'images/booking/RedStudio001.jpeg',
                'detail_duration' => json_encode(["Self Photo Studio Pekanbaru"]),
                'insert_at' => now(),
            ],
            [
                'judul_package' => 'RED STUDIO',
                'id_office' => 2,
                'times' => 15,
                'amount' => 60000,
                'image' => 'images/booking/RedStudio002.jpeg',
                'detail_duration' => json_encode(["Self Photo Studio Lampung"]),
                'insert_at' => now(),
            ],
        ]);
    }
}