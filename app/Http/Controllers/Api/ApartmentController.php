<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $allApartments = Apartment::all();
        $allCoordinates = Apartment::select('latitude', 'longitude')->get()->toArray();

        $sponsored = $request->input('sponsored');
        $nearest = $request->input('input');

        if ($sponsored) {
            foreach ($allApartments as $item) {
                $apartments = $item
                    ->whereHas('promotions', function ($q) {
                        $q->where('expired_at', '>', Carbon::now());
                    })
                    ->get();
            };
        } else if ($nearest) {
            //trasforma input in coordinate
            $via = urlencode($nearest);
            $rawData = file_get_contents("https://api.tomtom.com/search/2/geocode/" . $via . ".json?storeResult=false&view=Unified&limit=1&key=sGNJHBIkBGVklWlAnKDehryPD39qsJxn");
            $rawData = json_decode($rawData);
            $lat = $rawData->results[0]->position->lat;
            $lon = $rawData->results[0]->position->lon;

            //filtro raggio 20km
            $nearestApartments = [];
            foreach ($allCoordinates as $coordinate) {
                $radiusSearch =  file_get_contents("https://api.tomtom.com/search/2/geometryFilter.json?geometryList=%5B%7B%22type%22%3A%22CIRCLE%22%2C%20%22position%22%3A%22" . $lat . "%2C%20" . $lon . "%22%2C%20%22radius%22%3A20000%7D%5D&poiList=%5B%7B%22position%22%3A%7B%22lat%22%3A" . $coordinate['latitude'] . "%2C%22lon%22%3A" . $coordinate['longitude'] . "%7D%7D%5D&key=1p9OyCRm8S7icw73fBmkTYDlXYJGPO9O");
                $radiusSearch = json_decode($radiusSearch);

                if (!empty($radiusSearch->results)) {
                    array_push($nearestApartments, $radiusSearch->results[0]->position);
                }
            }
            foreach ($nearestApartments as $apartment) {
                $apartments[] = Apartment::where([['latitude', $apartment->lat], ['longitude', $apartment->lon]])->get();
            }
        } else {
            $apartments = Apartment::with('services')->paginate(5);
        }
        return response()->json($apartments);
    }

    public function show(Apartment $apartment)
    {
        $apartment->load('services')->get();
        return response()->json($apartment);
    }
}
