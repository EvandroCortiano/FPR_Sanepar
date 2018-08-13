<?php

namespace App\Repository;

use App\Models\doador;
use App\Models\contato_status;
use App\Models\telefones;

class DoadorRepository{

    //busca todos os doadores
    public function findAll(){
        try{
            return doador::all();
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

    // atualiza os dados do doador
    public function update($data, $ddr_id){
        try{ 
            $ddr = doador::find($ddr_id);

            if($ddr){
                $updDdr = $ddr->update($data);
                if($updDdr){
                    return doador::find($ddr_id);
                } else {
                    return 'Error';
                }
            } else {
                return 'Error';
            }
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

    // Cadastra telefone ao doador
    public function storeTelefone($data){
        try{
            return telefones::create($data);
        } catch(\Exception $e){
            return $e;
        }
    }

    // Atualiza todos os contatos de pessoa para doador
    public function updateContatoPesDdr($data, $pes_id){
        try{
            $contatoPes = contato_status::where('ccs_pes_id', $pes_id);
            if($contatoPes){
                $upd = $contatoPes->update($data);
                return contato_status::where('ccs_pes_id', $pes_id)->get();
            } else {
                return 'Error';
            }
            return $contatoPes;
        } catch(\Exception $e){
            return $e;
        }
    }
}