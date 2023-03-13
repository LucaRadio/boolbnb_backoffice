<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Promotion;
use App\Http\Controllers\Controller;

class BraintreeController extends Controller
{
    public function payment($apartmentId, $promotionId,){

        $promotion = Promotion::findOrFail($promotionId);
        $apartment = Apartment::findOrFail($apartmentId);

        return view("user.apartments.braintree", compact('apartment', 'promotion'));
    }
}
