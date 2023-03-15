<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->all();
        if ($request->has('date_of_birth')) {
            $data['date_of_birth'] = date("Y-m-d", strtotime($request->date_of_birth));
        }

        $request->validate([
            'name' => ['max:255'],
            'surname' => ['max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['exclude_unless:has_date_of_birth,true', 'date']

        ]);

        $user = User::create([
            'name' => $request->name ?? '',
            'surname' => $request->surname ?? '',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth ?? null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
