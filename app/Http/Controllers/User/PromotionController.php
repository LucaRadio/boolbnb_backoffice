<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(){
        $promotions =Promotion::All();

        return view('user.promotions.index', compact('promotions'));
    }
}
