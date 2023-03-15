<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $data=$request->all();

        $newMessage= Message::create($data);
        
        return response()->json($newMessage);
    }
}
