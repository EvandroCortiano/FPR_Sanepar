<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sanepar_retorno extends Model
{
    protected $table = 'san_retorno';

    protected $primaryKey = 'rto_id';

    protected $fillable = [
        'rto_ddr_id',
        'rto_doa_id',
        'rto_data',
        'rto_ur',
        'rto_local',
        'rto_cidade',
        'rto_matricula',
        'rto_nome',
        'rto_cpf_cnpj',
        'rto_rg',
        'rto_uf',
        'rto_logr_cod',
        'rto_logradouro',
        'rto_num',
        'rto_complemento',
        'rto_bai_cod',
        'rto_bairro',
        'rto_cep',
        'rto_categoria',
        'rto_cod_servico',
        'rto_vlr_servico',
        'rto_referencia_arr'
    ];
}
