<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\Candidato;
use App\Models\Empresa;

class Operations
{
    public static function decryptValue($value)
    {
        // confere se $value está encriptado
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }

        return $value;
    }

    public static function resolveUserType() {
        return session('user.type') === 'empresa' ? Empresa::class : Candidato::class;
    }
}
