<?php

namespace App\Repository;

use App\pessoas;

class PessoasRepository{

    public function show(){
        try{
            return pessoas::all();
        } catch(\Exception $e){
            return $e;
        }
    }

}