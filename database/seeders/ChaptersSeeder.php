<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChaptersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapters = [
            'Транспорт',
            'Недвижимость',
            'Личные вещи',
            'Для дома и дачи',
            'Запчасти и аксессуары',
            'Электроника',
            'Хобби и отдых',
            'Животные'
        ];

        foreach ($chapters as $chapter) {
            DB::table('chapters')->insert([
                'name' => $chapter,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
