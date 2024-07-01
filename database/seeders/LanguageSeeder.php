<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       //Todo Seeding
       DB::insert('INSERT INTO `languages` (`id`, `name`, `code`, `locale`, `image`, `status`, `created_at`, `updated_at`)
       VALUES (NULL, \'English\', \'en\', \'en_us\', NULL, \'1\', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
    }
}
