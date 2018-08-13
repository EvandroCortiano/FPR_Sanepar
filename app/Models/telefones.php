<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class telefones extends Model
{
    protected $table = 'cad_telefone';

    protected $primaryKey = 'tel_id';

    protected $fillable = [
        'tel_numero',
        'tel_obs',
        'tel_ddr_id'
    ];

    public function doador(){
        return $this->belongsTo(doador::class, 'tel_id', 'ddr_tel_id');
    }
}
