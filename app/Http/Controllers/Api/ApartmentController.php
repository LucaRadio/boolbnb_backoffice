<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $sponsored = $request->input('sponsored');

        if ($sponsored) {
            $apartments = Apartment::with('promotions');
        } else {
            //aggiungere raggio default 20km?
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
