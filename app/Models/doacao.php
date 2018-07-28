<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doacao extends Model
{
    protected $table = 'cad_doacao';

    protected $primaryKey = 'doa_id';

    protected $fillable = [
        'doa_ddr_id',
        'doa_data',
        'doa_data_final',
        'doa_valor',
        'doa_qtde_parcela',
        'doa_motivo',
        'doa_valor_mensal'
    ];
}
