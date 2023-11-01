<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    protected $fillable = ['name', 'email', 'cpf'];


    public function purchaseRequest(): HasMany
    {
        return $this->hasMany(purchaseRequest::class, 'id_client');
    }
    public static function getClientByName($name)
    {
        return Client::where('name', 'like', '%' . $name . '%')->get();
    }

    public static function getClientByCpf($cpf)
    {
        return Client::where('cpf', 'like', '%' . $cpf . '%')->get();
    }

    public static function getClientByEmail($email)
    {
        return Client::where('email', 'like', '%' . $email . '%')->get();
    }



    public function label()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->id;
    }

    use HasFactory;
    use SoftDeletes;
}
