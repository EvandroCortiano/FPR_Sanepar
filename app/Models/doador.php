<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doador extends Model
{
    protected $table = 'cad_doador';

    protected $primaryKey = 'ddr_id';

    protected $fillable = [
        'ddr_nome',
        'ddr_matricula',
        'ddr_telefone_principal'
    ];
}
