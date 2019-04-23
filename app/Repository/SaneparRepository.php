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

    // Retorna datas de referencia
    public function findSaneparDate(){
        try{
            $date = sanepar_retorno::select('rto_referencia_arr')->groupBy('rto_referencia_arr')->pluck('rto_referencia_arr', 'rto_referencia_arr');
            return $date;
        } catch(\Exception $e){
            return $e;
        } 
    }

    // Retorna arquivo retorno da sanepar
    public function findArquivoSanepar($data){
        try{
            $arq = sanepar_retorno::where('rto_referencia_arr','=',$data['rto_referencia_arr'])->get();
            return $arq;
        } catch(\Exception $e){
            return $e;
        }
    }

    // Retorna doadores inadiplentes ou sem retorno da sanepar
    public function inadiSanepar($data){
        try{
            $arq = sanepar_retorno::where('rto_referencia_arr','>',$data['dara_ref'])
                                  ->whereNull('rto_referencia_arr')
                                  ->get();
            return $arq;
        } catch(\Exception $e){
            return $e;
        }
    }
}