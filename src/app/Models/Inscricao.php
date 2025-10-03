<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $table = 'inscricoes';

    protected $fillable = [
        'candidato_id',
        'vaga_id',
        'data_inscricao',
    ];

    // 🚨 Pivot não precisa de created_at / updated_at
    public $timestamps = false;


    protected $dates = ['data_inscricao']; // Laravel vai tratar como Carbon

    const CREATED_AT = 'data_inscricao';
    const UPDATED_AT = null;

    /**
     * Relacionamento: inscrição pertence a um candidato.
     */
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    /**
     * Relacionamento: inscrição pertence a uma vaga.
     */
    public function vaga()
    {
        return $this->belongsTo(Vaga::class);
    }

    /**
     * Cria uma inscrição se não for duplicada.
     *
     * @param  array  $dados
     * @return bool
     */
    public static function createInscricao(array $dados): bool
    {
        try {
            // Verifica duplicidade
            $existe = self::where('candidato_id', $dados['candidato_id'])
                ->where('vaga_id', $dados['vaga_id'])
                ->exists();

            if ($existe) {
                return false;
            }

            // Cria inscrição
            self::create([
                'candidato_id'   => $dados['candidato_id'],
                'vaga_id'        => $dados['vaga_id'],
                'data_inscricao' => now(),
            ]);

            return true;

        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Atualiza uma inscrição, evitando duplicidade.
     *
     * @param  array  $dados
     * @return bool
     */
    public function atualizarInscricao(array $dados): bool
    {
        try {
            // Verifica duplicidade (ignora a própria inscrição atual)
            $existe = self::where('candidato_id', $dados['candidato_id'])
                ->where('vaga_id', $dados['vaga_id'])
                ->where('id', '!=', $this->id)
                ->exists();

            if ($existe) {
                return false;
            }

            return $this->update($dados);

        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }



    // Filtro por candidato
    public function scopeCandidato($query, $candidatoId)
    {
        if (!empty($candidatoId)) {
            return $query->where('candidato_id', $candidatoId);
        }
        return $query;
    }

    // Filtro por vaga
    public function scopeVaga($query, $vagaId)
    {
        if (!empty($vagaId)) {
            return $query->where('vaga_id', $vagaId);
        }
        return $query;
    }

    // Filtro por data de inscrição
    public function scopeDataInscricao($query, $data)
    {
        if (!empty($data)) {
            return $query->whereDate('data_inscricao', $data);
        }
        return $query;
    }

    // Ordenação dinâmica
    public function scopeOrdenar($query, $campo, $direcao = 'asc')
    {
        if (!empty($campo)) {
            return $query->orderBy($campo, $direcao);
        }
        return $query;
    }
}
