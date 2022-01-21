<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('auth.edit');
    }

    public function update()
    {
        $user = auth()->user();

        $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'phone' => ['string', 'min:9', 'max:14'],
        ]);

        $user->name = request('name');
        if(strcmp($user->email, request('email')) !== 0) {
            $this->validate(request(), [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
            $user->email = request('email');
            $user->email_verified_at = null;
        }
        $user->address = request('address');
        $user->city = request('city');
        $user->phone = request('phone');
        
        $user->update();

        return redirect()->back()->with('msg', 'Usuario modificado');
    }
}
