<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $allApartments = Apartment::all()->where('visibility', 1);
        $allCoordinates = Apartment::select('latitude', 'longitude')
            ->get()
            ->toArray();
        //mappa array per mandarlo a tomtom
        $poisJson = json_encode(array_map(function ($poi) {
            return [
                'position' => [
                    'lat' => $poi['latitude'],
                    'lon' => $poi['longitude']
                ]
            ];
        }, $allCoordinates));
        $sponsored = $request->input('sponsored');
        $simpleSearch = $request->input('city');
        $advancedSearch = $request->all('place', 'radius', 'rooms', 'beds', 'sqrMeters', 'services');

        if ($sponsored) {
            foreach ($allApartments as $item) {
                $apartments = $item
                    ->whereHas('promotions', function ($q) {
                        $q->where('expired_at', '>', Carbon::now());
                    })
                    ->get()
                    ->sortByDesc('promotions.id');
            };
        } else if ($simpleSearch) {
            $response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . urlencode($simpleSearch) . '.json?storeResult=false&countrySet=IT&view=Unified&limit=1&key=sGNJHBIkBGVklWlAnKDehryPD39qsJxn');
            $coordinates = json_decode($response, true)['results'][0]['position'];

            $distanceFormula = "(6371 * acos(cos(radians({$coordinates['lat']})) * cos(radians(latitude)) * cos(radians(longitude) - radians({$coordinates['lon']})) + sin(radians({$coordinates['lat']})) * sin(radians(latitude))))";

            $url = file_get_contents('https://api.tomtom.com/search/2/geometryFilter.json?geometryList=[{"type":"CIRCLE","position":"' . $coordinates['lat'] . ',' . $coordinates['lon'] . '","radius":20000}]&poiList=' . $poisJson . '&key=1p9OyCRm8S7icw73fBmkTYDlXYJGPO9O');
            $radiusSearch = json_decode($url, true);

            if (!empty($radiusSearch['results'])) {
                //rimappa array restituito da tomtom
                $poiCoordinates = array_map(function ($poi) {
                    return [
                        'latitude' => $poi['position']['lat'],
                        'longitude' => $poi['position']['lon']
                    ];
                }, $radiusSearch['results']);
                //carica dati degli appartamenti
                $query = Apartment::with('services');
                foreach ($poiCoordinates as $coordinates) {
                    $query->orWhere(function ($q) use ($coordinates) {
                        $q->where('latitude', $coordinates['latitude'])
                            ->where('longitude', $coordinates['longitude'])
                            ->where('visibility', 1);
                    });
                }
                $query
                    ->select('*', DB::raw("$distanceFormula as distance"))
                    ->orderByRaw("distance ASC");
                $apartments = $query->get();
            }
        } else if ($advancedSearch) {
            $requestedServices = json_decode($advancedSearch['services']);

            //trasforma input in coordinate
            $response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . urlencode($advancedSearch['place']) . '.json?storeResult=false&countrySet=IT&view=Unified&limit=1&key=sGNJHBIkBGVklWlAnKDehryPD39qsJxn');
            $coordinates = json_decode($response, true)['results'][0]['position'];
            $distanceFormula = "(6371 * acos(cos(radians({$coordinates['lat']})) * cos(radians(latitude)) * cos(radians(longitude) - radians({$coordinates['lon']})) + sin(radians({$coordinates['lat']})) * sin(radians(latitude))))";

            $url = file_get_contents('https://api.tomtom.com/search/2/geometryFilter.json?geometryList=[{"type":"CIRCLE","position":"' . $coordinates['lat'] . ',' . $coordinates['lon'] . '","radius":' . $advancedSearch['radius'] . '}]&poiList=' . $poisJson . '&key=1p9OyCRm8S7icw73fBmkTYDlXYJGPO9O');
            $radiusSearch = json_decode($url, true);

            if (!empty($radiusSearch['results'])) {
                //rimappa array restituito da tomtom
                $poiCoordinates = array_map(function ($poi) {
                    return [
                        'latitude' => $poi['position']['lat'],
                        'longitude' => $poi['position']['lon']
                    ];
                }, $radiusSearch['results']);
                //carica dati degli appartamenti
                $query = Apartment::with('services');
                foreach ($poiCoordinates as $coordinates) {
                    $query->orWhere(function ($q) use ($coordinates, $advancedSearch, $requestedServices) {
                        $q->where('latitude', $coordinates['latitude'])
                            ->where('longitude', $coordinates['longitude'])
                            ->where('visibility', 1)
                            ->where('n_rooms', '>=', $advancedSearch['rooms'])
                            ->where('n_beds', '>=', $advancedSearch['beds'])
                            ->where('square_meters', '>=', $advancedSearch['sqrMeters']);

                        foreach ($requestedServices as $service) {
                            $q->whereHas('services', function ($query) use ($service) {
                                $query->where('services.id', $service);
                            });
                        }
                    });
                }
                $query->select('*', DB::raw("$distanceFormula as distance"))
                    ->orderByRaw("distance ASC");
                $apartments = $query->get();
            }
        } else {
            $apartments = Apartment::with('services')->where('visibility', 1)->paginate(5);
        }
        return response()->json($apartments);
    }

    public function show(Apartment $apartment)
    {

        if ($apartment->visibility === 1) {
            return response()->json($apartment);
        } else {
            return response()->json(false);
        }
    }
}
