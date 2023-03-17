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
        $messages= [];
        foreach ($apartments as $apartment){
            if (count($apartment->messages)){
                foreach ($apartment->messages as $message){
                    $messages[]=$message;
                }
            }
        }
        return view("user.messages.index", compact('messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {

        if (Auth::user()->id === $message->apartment->user_id) {
            return view('user.messages.show', compact('message'));
        } else {
            return view('errorPage', ['message' => 'Non sei autorizzato a visionare questo messaggio']);
        }

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
