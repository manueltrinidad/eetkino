<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = config('countries.full');
        for ($i = 0; $i < count($countries); $i++) {
            DB::table('countries')->insert([
                'slug' => $countries[$i]->Slug,
                'name' => $countries[$i]->Country,
                'code' =>$countries[$i]->ISO2
            ]);
        }
    }
}
