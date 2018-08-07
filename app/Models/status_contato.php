<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status_contato extends Model
{
    protected $table = "tab_status_contato";

    protected $primaryKey = "stc_id";

    protected $fillable = [
        'stc_nome'
    ];
}
