<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AuthSeeder::class);
        $this->call(ApiPermissionRoleTableSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(RegionsSeeder::class);
        $this->call(PractitionersSeeder::class);
        $this->call(PatientDataSeeder::class);
    }
}
