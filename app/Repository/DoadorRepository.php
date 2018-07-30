<?php

namespace App\Repository;

use App\Models\doador;


class DoadorRepository{

    //cadastra doador no banco de dados
    public function store($data){
        try{ 
            return doador::create($data);
        } catch(\Exception $e){
            return $e;
        }
    }
}