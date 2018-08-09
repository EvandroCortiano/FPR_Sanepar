<?php

namespace App\Repository;

use App\Models\doador;
use App\Models\contato_status;

class DoadorRepository{

    //busca todos os doadores
    public function findAll(){
        try{
            return doador::paginate(15);
        } catch(\Exception $e){
            return $e;
        }
    }

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

    //Cadastra contato com o possivel doador
    public function contatoStore($data){
        try{
            return contato_status::create($data);
        } catch(\Exception $e){
            return $e;
        }
    }
}