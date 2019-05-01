<?php

namespace App\Repository;

use App\Models\pessoas;
use App\Models\contato_status;

class PessoasRepository{

    public function show($numberInicial, $numberFinal){
        try{
            return pessoas::whereBetween('pes_id',[$numberInicial, $numberFinal])->get();
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

    public function findPesContato($ccs_pes_id){
        try{
            return contato_status::where("ccs_pes_id","=",$ccs_pes_id)->orderBy('ccs_id','desc')->first();
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

    //Atualiza contato com o possivek doador
    public function contatoUpdatePessoas($data){
        try{
            $updCcs = contato_status::find($data['ccs_id']);
            if($updCcs){
                try{
                    $upd = $updCcs->update($data);
                    if ($upd) {
                        return pessoas::find($data['ccs_pes_id']);
                    } else {
                        return 'Error';
                    }
                    
                } catch(\Exception $e){
                    return $e;
                }
            }
        } catch(\Exception $e){
            return $e;
        }
    }

    // atualizar dados
    public function update($pes_id, $data){
        try{
            $updPes = pessoas::find($pes_id);
            if($updPes){
                try{
                    $upd = $updPes->update($data);
                    if($upd){
                        return pessoas::find($pes_id);
                    } else {
                        return 'Error';
                    }
                } catch(\Exception $e){
                    return $e;
                }
            } else {
                return 'Error';
            }
        } catch(\Exception $e){
            return $e;
        }
    }
}