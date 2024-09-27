<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register()
    {
        $data = [
            'title' => 'Register'
        ];

        return view('pages.auth.register')->with($data);
    }

    public function registerPost(Request $request)
    {
        $data = [
            'title' => 'Register',
        ];

        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            $data['success'] = 'Registrado com sucesso!';
            return redirect()->route('login')->with($data);
        } catch (\Exception $e) {
            Log::error('Error registering user: ' . $e->getMessage());

            $data['error'] = 'Erro ao registrar usuário.';
            return redirect()->route('register')->with($data);
        }
    }

    public function login()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('pages.auth.login', $data);
    }

    public function loginPost(Request $request)
    {
        $data = [
            'title' => 'Login'
        ];

        $credetials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credetials)) {
            return redirect('/home')->with('success', 'Login realizado com sucesso!');
        }

        return back()->with($data)->with('error', 'Usuário e/ou senha incorreto.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
