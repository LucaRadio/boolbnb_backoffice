<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $apartments = Apartment::where('user_id', $user->id)->get();

        return view("user.messages.index", compact('apartments'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        return view('user.messages.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {

       $message->apartment()->dissociate();

       $message->delete();

       return redirect()->route("user.messages.index");

    }
}
