<?php

namespace App\Repository;

use App\Models\doacao;


class DoacaoRepository{

    //cadastrar doacao
    public function store($data){
        try{
            return doacao::create($data);
        }catch(\Exception $e){
            return $e;
        }
    }

    //pesquisa doacoes do paciaente
    public function findDdr($ddr_id){
        try{
            return doacao::where('doa_ddr_id',$ddr_id)->get();
        } catch(\Exception $e){
            return $e;
        }
    }
}