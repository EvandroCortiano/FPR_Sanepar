<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sanepar_retorno extends Model
{
    protected $table = 'san_retorno';

    protected $primaryKey = 'rto_id';

    protected $fillable = [
        'rto_cre_id',
        'rto_ddr_id',
        'rto_status',
        'rto_data_credito',
        'rto_valor_credito'
    ];
}
