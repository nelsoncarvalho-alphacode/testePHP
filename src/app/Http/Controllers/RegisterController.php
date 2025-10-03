<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
class RegisterController extends Controller
{
     public function create(){


        return view('auth.register');
     }



     public function store(RegisterRequest $request){


         $dados = $request->only(['name','email','password']);
         $dados['password'] = Hash::make($dados['password']);

        $user = User::create($dados);

        // Se quiser logar automaticamente depois de registrar
        auth()->login($user);

        // Redireciona para a tela inicial ou vagas
        return redirect()->route('home')->with('success', 'Conta criada com sucesso!');
     }
}



