<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $regions = [
            'Avtonomna Respublika Krym',
            'Cherkaska Oblast',
            'Chernihivska Oblast',
            'Chernivetska Oblast',
            'Dnipropetrovska Oblast',
            'Donetska Oblast',
            'Ivano - Frankivska Oblast',
            'Kharkivska Oblast',
            'Khersonska Oblast',
            'Khmelnytska Oblast',
            'Kirovohradska Oblast',
            'Kyivska Oblast',
            'Luhanska Oblast',
            'Lvivska Oblast',
            'Misto Kyiv',
            'Misto Sevastopol',
            'Mykolaivska Oblast',
            'Odeska Oblast',
            'Poltavska Oblast',
            'Rivnenska Oblast',
            'Sumska Oblast',
            'Ternopilska Oblast',
            'Vinnytska Oblast',
            'Volynska Oblast',
            'Zakarpatska Oblast',
            'Zaporizka Oblast',
            'Zhytomyrska Oblast',
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'name' => $region,
            ]);
        }
    }
}
