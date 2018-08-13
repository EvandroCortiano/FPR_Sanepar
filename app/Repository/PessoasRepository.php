<?php

namespace App\Repository;

use App\Models\pessoas;
use App\Models\contato_status;

class PessoasRepository{

    public function show(){
        try{
            return pessoas::all();
        } catch(\Exception $e){
            return $e;
        }
    }

    public function find($pes_id){
        try{
            return pessoas::find($pes_id);
        } catch(\Exception $e){
            return $e;
        }
    }

    //Cadastra contato com o possivel doador
    public function contatoStorePessoas($data){
        try{
            return contato_status::create($data);
        } catch(\Exception $e){
            return $e;
        }
    }

}