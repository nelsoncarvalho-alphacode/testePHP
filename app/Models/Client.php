<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'celphone',
        'date_of_birth',
        'password',
        'cep',
        'address',
        'addressNumber',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function orders()
    {
        return $this->hasMany(PurchaseOrder::class, 'client_id', 'id');
    }
}
