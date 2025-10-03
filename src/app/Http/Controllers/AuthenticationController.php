<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
class AuthenticationController extends Controller
{
    /**
     * Mostra a tela de login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Processa o login
     */
    public function logar(LoginRequest $request)
    {

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('home'); // redireciona para /home
        }

        return back()->withErrors([
            'email' => 'O e-mail e/ou senha não são válidos.',
        ])->onlyInput('email');
    }

    /**
     * Faz logout do usuário e redireciona para tela de login
     */
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // redireciona corretamente para tela de login (rota GET)
    return redirect()->route('login.form');
}
}
