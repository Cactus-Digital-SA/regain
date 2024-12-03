<?php

namespace App\Domains\MockFront\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Faker\Factory as Faker;

class MockFrontController extends  Controller
{

    /**
     * @return View
     */
    public function showDateOfBirth(): View
    {
        return view('frontend.content.mock.date-of-birth');
    }

    /**
     * @return View
     */
    public function showCurrentLocation(): View
    {
        $fakerLocales = ['ru_RU', 'uk_UA', 'ka_GE', 'lv_LV', 'lt_LT', 'et_EE', 'kz_KZ', 'by_BY'];
        $locations = [];

        for ($i = 0; $i < 27; $i++) {
            $locale = $fakerLocales[array_rand($fakerLocales)];
            $faker = Faker::create($locale);

            $locations[$i] = $faker->city();
        }


        return view('frontend.content.mock.current-location')->with('locations', $locations);
    }

    public function showDisabilityDisorder(): View
    {
        $faker = Faker::create('en_US');
        $likertScale = [
            'Strongly Disagree',
            'Disagree',
            'Neutral',
            'Agree',
            'Strongly Agree'
        ];
        $questions = [];
        for ($i = 0; $i <= 4; $i++) {
            $questions[$i] = $faker->sentence($nbWords = 8);
            $answers[$i] = $likertScale;
        }
        return view('frontend.content.mock.disability-disorder', compact('questions', 'answers'));
    }

}
