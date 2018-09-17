<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cartao extends Model
{  
    protected $table = 'cad_cartao';

    protected $primaryKey = 'car_id';

    protected $fillable = [
        'car_ddr_id',
        'car_doa_id',
        'car_data',
        'car_arquivo'
    ];

    public function doador(){
        return $this->belongsTo(doador::class, 'car_ddr_id', 'ddr_id');
    }

    public function doacao(){
        return $this->belongsTo(doacao::class, 'car_doa_id', 'doa_id');
    }

}
