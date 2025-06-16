<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // validação do formulário
        $request->validate(
            // regras
            [
                'text_username' => 'required | email',
                'text_password' => 'required | min:6 | max:16'
            ],
            // mensagens de erro
            [
                'text_username.required' => 'O campo username não pode estar vazio.',
                'text_username.email' => 'Informe um e-mail válido.',
                'text_password.required' => 'O campo de senha não pode estar vazio.',
                'text_password.min' => 'A senha deve ter no mínimo :min caracteres.',
                'text_password.max' => 'A senha deve ter no máximo :max caracteres.',
            ]
        );

        // seleciona os inputs do usuário
        $username = $request->text_username;
        $password = $request->text_password;
        $isEmpresa = $request->input('candidato_empresa') == 'empresa';

        // verifica se usuário existe e é uma empresa ou candidato
        $user = $isEmpresa
            ? Empresa::where('username', $username)->whereNull('deleted_at')->first()
            : Candidato::where('username', $username)->whereNull('deleted_at')->first();

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorretos.');
        }

        // verifica se senha está correta
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password incorretos.');
        }

        $user->save();

        // sessão de login do candidato
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'type' => $request->input('candidato_empresa')
            ],
        ]);

        // redireciona para home
        return redirect()->to('/');
    }

    public function logout()
    {
        // logout da aplicação
        session()->forget('user');
        return redirect()->to('/login');
    }
}
