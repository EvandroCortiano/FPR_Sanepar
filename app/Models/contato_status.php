<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contato_status extends Model
{
    protected $table = 'cad_contato_status';

    protected $primaryKey = 'ccs_id';

    protected $fillable = [
        'ccs_ddr_id',
        'ccs_obs',
        'ccs_stc_id',
        'ccs_data',
        'ccs_pes_id'
    ];

    public function doador(){
        return $this->belongsTo(doador::class, 'ccs_ddr_id', 'ddr_id');
    }

    public function statusContato(){
        return $this->belongsTo(status_contato::class, 'ccs_stc_id', 'stc_id');
    }

    public function pessoas(){
        return $this->belongsTo(pessoas::class, 'ccs_pes_id', 'pes_id');
    }
}
