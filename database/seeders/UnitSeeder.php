<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                // 'slug' => 'NEA',
                'no_unit' => 'NEA1',
                'kondisi' => 'Normal',
                'id_alat' => '1'
            ],
            [
                // 'slug' => 'NEA',
                'no_unit' => 'NEA2',
                'kondisi' => 'Normal',
                'id_alat' => '1'
            ],
            [
                // 'slug' => 'NEA',
                'no_unit' => 'NEA3',
                'kondisi' => 'Normal',
                'id_alat' => '1'
            ],
            [
                // 'slug' => 'NEA',
                'no_unit' => 'NEA4',
                'kondisi' => 'Rusak',
                'id_alat' => '1'
            ],
            [
                // 'slug' => 'KIT',
                'no_unit' => 'KIT1',
                'kondisi' => 'Normal',
                'id_alat' => '2'
            ],
            [
                // 'slug' => 'KIT',
                'no_unit' => 'KIT2',
                'kondisi' => 'Rusak',
                'id_alat' => '2'
            ],
            [
                // 'slug' => 'KIT',
                'no_unit' => 'KIT3',
                'kondisi' => 'Normal',
                'id_alat' => '2'
            ],
            [
                // 'slug' => 'MUR',
                'no_unit' => 'MUR1',
                'kondisi' => 'Normal',
                'id_alat' => '3'
            ],
            [
                // 'slug' => 'MUR',
                'no_unit' => 'MUR2',
                'kondisi' => 'Normal',
                'id_alat' => '3'
            ],
            [
                // 'slug' => 'CAU',
                'no_unit' => 'CAU1',
                'kondisi' => 'Normal',
                'id_alat' => '4'
            ],
            [
                // 'slug' => 'AUO',
                'no_unit' => 'AUO1',
                'kondisi' => 'Normal',
                'id_alat' => '5'
            ],
        ];
        DB::table('unit')->insert($units);
    }
}
