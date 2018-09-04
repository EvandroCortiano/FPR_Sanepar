<?php

namespace App\Repository;

use App\User;


class UsersRepository{

    //Retorna operadores
    public function operadores(){
        try{
            $oper = User::where('user_per_id','=',3);
            return $oper;
        } catch(\Exception $e){
            return $e;
        }
    }

}