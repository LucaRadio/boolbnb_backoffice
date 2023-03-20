<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $json = File::get('database/data/apartments.json');
        $apartments = json_decode($json);
        $users = User::all()->count();

        foreach ($apartments as $apartment) {
            $tomtom = file_get_contents('https://api.tomtom.com/search/2/geocode/' . urlencode($apartment->address) . '.json?storeResult=false&countrySet=IT&view=Unified&limit=1&key=sGNJHBIkBGVklWlAnKDehryPD39qsJxn');
            $coordinates = json_decode($tomtom, true)['results'][0]['position'];
            Apartment::create([
                'title' => $apartment->title,
                'n_rooms' => $apartment->num_rooms,
                'n_bathrooms' => $apartment->num_bathrooms,
                'n_beds' => $apartment->num_beds,
                'square_meters' => $apartment->sq_meters,
                'address' => $apartment->address,
                'visibility' => 1,
                'img_cover' => $apartment->image,
                'description' => $apartment->description,
                'latitude' => $coordinates['lat'],
                'longitude' => $coordinates['lon'],
                'user_id' => rand(1, $users),
            ]);
        }
    }
}
