<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status_motivo extends Model
{
    protected $table = 'tab_status_motivo';

    protected $primaryKey = 'smt_id';

    protected $fillable = [
        'smt_nome'
    ];

    public function doacao(){
        return $this->hasMany(Doacao::class);
    }
}
