<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $values = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if (!Auth::attempt($values)) {
            return response()->json(['message' => 'Credenciais incorrectos'], 403);
        } else {
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('secret')->plainTextToken
            ]);
        }
    }

    public function register(Request $request)
    {
        $values = $this->validate($request, [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $values['name'],
            'email' => $values['email'],
            'password' => bcrypt($values['password']),
        ]);

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logout feito com sucesso!']);
    }

    public function user()
    {
        return response([
            'user' => auth()->user()
        ]);
    }

    public function update(Request $request)
    {
        $values = $this->validate($request, [
            'name' => 'required|string'
        ]);

        $image = $this->saveImage($request->image, 'profiles');


        \auth()->user()->update([
            'name' => $values['name'],
            'image' => $image
        ]);

        return response([
            'message' => 'Profile updated',
            'user' => \auth()->user()
        ]);
    }
}
