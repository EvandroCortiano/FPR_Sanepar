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
        'doa_smt_id',
        'doa_valor_mensal'
    ];

    public function motivo(){
        return $this->belongsTo(status_motivo::class, 'doa_smt_id', 'smt_id');
    }

    public function doador(){
        return $this->belongsTo(doador::class, 'ddr_id', 'doa_ddr_id');
    }

}
