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

    //pesquisa e retorna doador
    public function find($ddr_id){
        try{
            return doador::find($ddr_id);
        } catch(\Exception $e){
            return $e;
        }
    }
}