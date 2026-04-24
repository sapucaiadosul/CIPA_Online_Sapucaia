<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Eleicoes extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'descricao_eleicao','dt_vigencia_de','dt_vigencia_ate','numero_indicados',
        'numero_nao_indicados','numero_eleitos','dt_vigencia_de','dt_vigencia_ate',
        'dt_inscricao_de','dt_inscricao_ate','dt_votacao_de','dt_votacao_ate',
        'dt_resultados','dt_edital_nominal','obs_anexos',
    ];

    public function Candidatos(): HasMany
    {
        return $this->hasMany(Candidatos::class);
    }
}
