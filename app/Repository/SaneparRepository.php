<?php

namespace App\Repository;

use App\Models\sanepar_retorno;


class SaneparRepository{

    public function store($data){
        try{
            return sanepar_retorno::create($data);
        } catch(\Exception $e){
            return $e;
        }
    }
}