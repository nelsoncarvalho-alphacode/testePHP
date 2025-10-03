<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\PasswordEmailRequest;

class PasswordResetController extends Controller
{
    /**
     * Mostra o formulário para requisitar mensagem de recuperação de senha
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function request()
    {
        return view('auth.password.email');
    }

    /**
     * Envia a mensagem de email para o endereço do usuário
     *
     * @param PasswordEmailRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function email(PasswordEmailRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Mostra o formulário de alteração da senha
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function reset(Request $request)
    {
        return view('auth.password.reset', [
            'token' => $request->token, // pega token da query string
            'email' => $request->email  // pega email da query string
        ]);
    }

    /**
     * Realiza a alteração da senha no banco de dados
     *
     * @param PasswordResetRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(PasswordResetRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
