<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class users_perfil extends Model
{
    protected $table = 'users_perfil';

    protected $primaryKey = 'per_id';

    protected $fillable = [
        'per_nome'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
