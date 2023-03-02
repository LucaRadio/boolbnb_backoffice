<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Apartment_serviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = Apartment::all();
        $services = Service::all();
        $total_services = Service::all()->count();

        foreach ($apartments as $apartment) {
            $rand = rand(1, $total_services);
            $assoc = [];
            for ($i = 0; $i < $rand; $i++) {
                $new_service = $services->random()->id;
                if (!in_array($new_service, $assoc)) {
                    array_push($assoc, $new_service);
                };
            }
            $apartment->services()->attach($assoc);
            $assoc = [];
        }
    }
}
