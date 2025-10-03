<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Candidato extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'telefone', 'curriculo'];

    /**
     * Relacionamento muitos-para-muitos: candidatos podem estar em várias vagas.
     */
    public function vagas()
    {
        return $this->belongsToMany(Vaga::class, 'inscricoes')
                    ->withPivot('data_inscricao');
    }

    /**
     * Cria um novo candidato e, se informado, relaciona com vagas.
     *
     * @param  array  $dadosCandidato
     * @param  array  $vagas
     * @return bool
     */
    public static function createCandidato(array $dadosCandidato, array $vagas = []): bool
    {
        DB::beginTransaction();

        try {
            // Cria candidato
            $candidato = self::create($dadosCandidato);

            // Relaciona com as vagas selecionadas (pivot inscricoes)
            if (!empty($vagas)) {
                $candidato->vagas()->attach($vagas, [
                    'data_inscricao' => now(),
                ]);
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            return false;
        }
    }

    /**
     * Atualiza os dados de um candidato.
     *
     * @param  array  $dados
     * @return bool
     */
    public function atualizarCandidato(array $dados): bool
    {
        try {
            return $this->update($dados);
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

public function scopeNome($query, $nome)
    {
        if (!empty($nome)) {
            return $query->where('nome', 'like', "%$nome%");
        }
        return $query;
    }

    //  Filtro por email
    public function scopeEmail($query, $email)
    {
        if (!empty($email)) {
            return $query->where('email', 'like', "%$email%");
        }
        return $query;
    }

    //  Filtro por telefone
    public function scopeTelefone($query, $telefone)
    {
        if (!empty($telefone)) {
            return $query->where('telefone', 'like', "%$telefone%");
        }
        return $query;
    }

    //  Filtro por currículo
    public function scopeCurriculo($query, $curriculo)
    {
        if (!empty($curriculo)) {
            return $query->where('curriculo', 'like', "%$curriculo%");
        }
        return $query;
    }

    //  Filtro por data de criação
    public function scopeCriadoEm($query, $data)
    {
        if (!empty($data)) {
            return $query->whereDate('created_at', $data);
        }
        return $query;
    }

    //  Ordenação dinâmica
    public function scopeOrdenar($query, $campo, $direcao = 'asc')
    {
        if (!empty($campo)) {
            return $query->orderBy($campo, $direcao);
        }
        return $query;
    }


}
