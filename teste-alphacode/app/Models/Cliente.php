<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        "nome",
        "cpf",
        "email",
    ];

    public function pedidos(){
        return $this->hasMany(Pedidos::class);
    }
}
