<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anexos extends Model implements AuditableContract
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['origem_id','arquivo','tipo', 'nome_original', 'eleicoes_id'];  

    protected $casts = [
        'origem_id' => 'integer',
    ];

    public function Eleicoes()
    {
        return $this->belongsTo(Eleicoes::class, 'origem_id', 'id');
    }
}
 
