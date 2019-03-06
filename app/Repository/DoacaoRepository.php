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

    //pesquisa doacoes
    public function find($doa_id){
        try{
            return doacao::find($doa_id);
        } catch(\Exception $e){
            return $e;
        }
    }
    //pesquisa doacoes do paciaente
    public function findDdr($ddr_id){
        try{
            return doacao::where('doa_ddr_id',$ddr_id)->get();
        } catch(\Exception $e){
            return $e;
        }
    }

    //atualiza/suspende doacao
    public function updDoa($data, $doa_id){
        try{
            $doa = doacao::find($doa_id);
            if($doa){
                try{
                    $upd = $doa->update($data);
                    if($upd){
                        return doacao::withTrashed()->find($doa_id);
                    } else {
                        return "Error";
                    }
                } catch(\Exception $e){
                    return $e;
                }
            } else {
                return "Error";
            }
        } catch(\Exception $e){
            return $e;
        }
    }
}