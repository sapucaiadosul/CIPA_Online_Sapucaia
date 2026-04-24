<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleitor extends Model
{
    use HasFactory;

    private $matricula;
    private $cpf;
    private $nome;
    private $dt_nascimento;
    private $cd_vinculo;
    private $vinculo;
    private $ds_cargo;
    private $departamento;
    private $secretaria;
}
