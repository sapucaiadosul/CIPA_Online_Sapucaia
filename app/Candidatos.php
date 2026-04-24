<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidatos extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'matricula',
        'nome',
        'apelido',
        'email',
        'telefone',
        'data_de_nascimento',
        'cpf',
        'lotacao',
        'cargo_funcao',
        'indicado',
        'vinculo',
        'estabilidade',
        'foto',
        'historico',
        'status',
    ];

    public function Eleicoes()
    {
        return $this->belongsTo(Eleicoes::class);
    }
}
