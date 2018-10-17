<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cartaoPessoa extends Model
{  
    use SoftDeletes;

    protected $table = 'cad_cartao_pessoa';

    protected $primaryKey = 'ccp_id';

    protected $fillable = [
        'ccp_nome',
        'ccp_obs',
        'ccp_ddr_id',
        'ccp_doa_id',
        'created_at',
        'updated_at'
    ];

    //softDelete
    protected $dates = ['deleted_at'];

    public function doador(){
        return $this->belongsTo(doador::class, 'ccp_ddr_id', 'ddr_id');
    }

    public function doacao(){
        return $this->belongsTo(doacao::class, 'ccp_doa_id', 'doa_id');
    }

}
