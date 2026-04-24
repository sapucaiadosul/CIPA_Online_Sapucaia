<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Votacoes extends Model implements AuditableContract
{
  use \OwenIt\Auditing\Auditable;

  protected $fillable = [
    'voto_candidato_id', 'tipo_voto', 'votacao_realizada','eleitor_matricula',
    'eleitor_nome', 'eleitor_cpf', 'eleitor_lotacao', 'eleitor_cargo_funcao', 'eleitor_IP_acesso',
  ];

  public function busca_candidato()
  {
    return $this->belongsTo(Candidatos::class,'voto_candidato_id','id');
  }    
}
