<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pessoas extends Model
{
    protected $table = "cad_pessoas";

    protected $primaryKey = "pes_id";

    protected $fillable = [
        'pes_nome',
        'pes_cpf',
        'pes_sexo',
        'pes_nascimento',
        'pes_mae',
        'pes_endereco',
        'pes_numero',
        'pes_complemento',
        'pes_bairro',
        'pes_cidade',
        'pes_estado',
        'pes_cep',
        'pes_tel1',
        'pes_tel2',
        'pes_tel3',
        'pes_tel4',
        'pes_tel5',
        'pes_email'
    ];
}
