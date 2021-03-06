<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class doador extends Model
{
    protected $table = 'cad_doador';

    protected $primaryKey = 'ddr_id';

    protected $fillable = [
        'ddr_nome',
        'ddr_matricula',
        'ddr_telefone_principal',
        'ddr_titular_conta',
        'ddr_endereco',
        'ddr_numero',
        'ddr_complemento',
        'ddr_bairro',
        'ddr_cid_id',
        'ddr_cep',
        'ddr_nascimento',
        'ddr_cpf',
        'ddr_cidade',
        'ddr_email',
        'ddr_pes_id'
    ];

    public function contato(){
        // return $this->hasMany(contato_status::class, 'ccs_ddr_id', 'ddr_id');
        return $this->hasOne(contato_status::class, 'ccs_ddr_id', 'ddr_id')->latest();
    }

    public function telefone(){
        return $this->hasMany(telefones::class, 'tel_ddr_id', 'ddr_id');
    }

    public function doacao(){
        return $this->hasOne(doacao::class, 'doa_ddr_id', 'ddr_id')->latest();
    }
}