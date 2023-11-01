<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    protected $table = 'status';
    protected $fillable = ['name'];
    public function purchaseRequest(): HasMany
    {
        return $this->hasMany(purchaseRequest::class, 'id_status');
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
