<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servidor extends Model
{
    use HasFactory;

    protected $table = 'servidores';

    protected $fillable = [
        'nome',
        'cpf',
        'matricula',
        'dt_nascimento',
        'vinculo',
    ];

    public function votacoes()
    {
        return $this->hasMany(Votacoes::class);
    }
}
