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
            'Cherkasy', 'Chernihiv', 'Chernivtsi', 'Dnipropetrovsk', 'Donetsk',
            'Ivano-Frankivsk', 'Kharkiv', 'Kherson', 'Khmelnitskyi', 'Kirovohrad',
            'Kyiv', 'Luhansk', 'Lviv', 'Mykolaiv', 'Odessa',
            'Poltava', 'Rivne', 'Sumy', 'Ternopil', 'Vinnytsia',
            'Volyn', 'Zakarpattia', 'Zaporizhzhia', 'Zhytomyr'
        ];

        foreach ($regions as $region) {
            DB::table('regions')->insert([
                'name' => $region,
            ]);
        }
    }
}
