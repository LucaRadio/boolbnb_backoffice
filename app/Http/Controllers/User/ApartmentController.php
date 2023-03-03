<?php

namespace App\Http\Controllers\User;

use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();

        return view("user.apartments.index", compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("user.apartments.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $apartment = new Apartment();

        $user = Auth::user();

        $apartment->fill($data);
        $apartment->user_id = $user->id;

        if ($request->has('services')) {
            $apartment->services()->attach($data['services']);
        }
        if ($request->has('promotions')) {
            $apartment->promotions()->attach($data['promotions']);
        }

        $apartment->save();

        return redirect()->route("apartments.show", $apartment->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        return view("user.apartments.show", compact("apartment"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        return view("user.apartments.edit", compact("apartment"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        $data = $request->all();
        $apartment->fill($data);

        if ($request->has('services')) {
            $apartment->services()->sync($data['services']);
        }
        if ($request->has('promotions')) {
            $apartment->promotions()->sync($data['promotions']);
        }

        $apartment->save();

        return redirect()->route("apartment.show", compact("apartment"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->services()->detach();
        $apartment->promotions()->detach();
        $apartment->user()->dissociate();
        $apartment->delete();

        return redirect()->route("dashboard");
    }
}
