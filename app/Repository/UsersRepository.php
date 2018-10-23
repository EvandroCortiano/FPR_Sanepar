<?php

namespace App\Repository;

use App\User;


class UsersRepository{

    //Retorna operadores
    public function operadores(){
        try{
            $oper = User::whereIn('user_per_id',[3,2]);
            return $oper;
        } catch(\Exception $e){
            return $e;
        }
    }

    //Retorna operadores
    public function findUser($usu_id){
        try{
            $oper = User::where('id',$usu_id)->get();
            return $oper;
        } catch(\Exception $e){
            return $e;
        }
    }

}