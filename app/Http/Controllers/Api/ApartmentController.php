<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $allApartments = Apartment::all();

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

            //ordina tutti gli appartamenti a db a distanza crescente da input utente
            $allCoordinates = Apartment::select('latitude', 'longitude', 'address')
                ->selectRaw('(6371 * acos (
                    cos ( radians(?) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians(?) )
                    + sin ( radians(?) )
                    * sin( radians( latitude )))) AS distance', [
                    $coordinates['lat'],
                    $coordinates['lon'],
                    $coordinates['lat'],
                ])
                ->orderBy('distance', 'ASC')
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
                            ->where('longitude', $coordinates['longitude']);
                    });
                }
                $apartments = $query->get();
            } else {
                $apartments = 'Non ci sono risultati per questa ricerca';
            }
        } else if ($advancedSearch) {
            //$requestedServices = json_decode($advancedSearch['services']);
            // dd($apartmentServices);

            //trasforma input in coordinate
            $response = file_get_contents('https://api.tomtom.com/search/2/geocode/' . urlencode($advancedSearch['place']) . '.json?storeResult=false&countrySet=IT&view=Unified&limit=1&key=sGNJHBIkBGVklWlAnKDehryPD39qsJxn');
            $coordinates = json_decode($response, true)['results'][0]['position'];

            $allCoordinates = Apartment::select('latitude', 'longitude')
                ->selectRaw('(6371 * acos (
                    cos ( radians(?) )
                    * cos( radians( latitude ) )
                    * cos( radians( longitude ) - radians(?) )
                    + sin ( radians(?) )
                    * sin( radians( latitude )))) AS distance', [
                    $coordinates['lat'],
                    $coordinates['lon'],
                    $coordinates['lat'],
                ])
                ->where([
                    ['n_rooms', '>=', $advancedSearch['rooms']],
                    ['n_beds', '>=', $advancedSearch['beds']],
                    ['square_meters', '>=', $advancedSearch['sqrMeters']]
                ])
                ->orderBy('distance', 'ASC')
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
                    $query->orWhere(function ($q) use ($coordinates) {
                        $q->where('latitude', $coordinates['latitude'])
                            ->where('longitude', $coordinates['longitude']);
                    });
                }
                $apartments = $query->get();
            } else {
                $apartments = 'Non ci sono risultati per questa ricerca';
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
