<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentSeeder extends Seeder
{
    public $rawData;
    protected $address;
    protected $lat;
    protected $long;
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        for ($i = 0; $i < 10; $i++) {
            $this->lat = '45' . '.' . (string)(rand(2000, 5000));
            $this->long =  '9' . '.' . (string)(rand(2000, 5000));

            $this->rawData = file_get_contents('https://api.tomtom.com/search/2/reverseGeocode/' . $this->lat . '%2C' . $this->long . '.json?returnSpeedLimit=false&radius=10000&returnRoadUse=false&allowFreeformNewLine=false&returnMatchType=false&view=Unified&key=C1SeMZqi2HmD2jfTGWrbkAAknINrhUJ3');
            $this->rawData = json_decode($this->rawData);
            $this->address = $this->rawData->addresses[0]->address->freeformAddress;
            $apartment = Apartment::create(
                [
                    'title' => 'apartment ' . $faker->company(),
                    'n_rooms' => rand(1, 10),
                    'n_bathrooms' => rand(1, 3),
                    'n_beds' => rand(1, 20),
                    'square_meters' => rand(30, 200),
                    'address' => $this->address,
                    'visibility' => 1,
                    'img_cover' => 'https://picsum.photos/id/' . rand(1, 300) . '/300/300',
                    'description' => $faker->realText(50),
                    'latitude' => $this->lat,
                    'longitude' => $this->long,
                    'user_id' => rand(1, 10)

                ]
            );
        }
    }
}
