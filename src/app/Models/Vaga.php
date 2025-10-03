<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    use HasFactory;

    protected $table = 'vagas';

    // Campos que podem ser atualizados/criados
    protected $fillable = [
        'titulo',
        'descricao',
        'tipo',
        'status',
        'salario',
    ];

    // 🔹 Relacionamento muitos-para-muitos
    public function candidatos()
{
    return $this->belongsToMany(Candidato::class, 'inscricoes')
                ->withPivot('data_inscricao');
}

    public function scopeTipo($query, $tipo)
    {
        if ($tipo) {
            return $query->where('tipo', $tipo);
        }
        return $query;
    }

    public function scopeTitulo($query, $titulo)
    {
        if ($titulo) {
            return $query->where('titulo', 'like', "%{$titulo}%");
        }
        return $query;
    }

    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeOrdenar($query, $sortField, $direction = 'asc')
    {
        if ($sortField) {
            return $query->orderBy($sortField, $direction);
        }
        return $query;
    }

}
