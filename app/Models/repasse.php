<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class repasse extends Model
{
    protected $table = 'cad_repasse';

    protected $primaryKey = 'cre_id';

    protected $fillable = [
        'cre_doa_id',
        'cre_cpa_id',
        'cre_parcela'
    ];
}
