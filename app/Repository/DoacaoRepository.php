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
}