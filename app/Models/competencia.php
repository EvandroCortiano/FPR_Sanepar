<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class competencia extends Model
{
    protected $table = 'cad_competencia';

    protected $primaryKey = 'cpa_id';

    protected $fillable = [
        'cpa_mes_ref',
        'cpa_data_inicio',
        'cpa_data_fim',
        'cpa_semana_mes',
    ];
}
