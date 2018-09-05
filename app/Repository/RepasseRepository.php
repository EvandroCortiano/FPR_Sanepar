<?php

namespace App\Repository;

use App\Models\doacao;
use Illuminate\Support\Facades\DB;


class RepasseRepository{

    //pesquisar doacoes
    public function findDoacao(){
        try{
            $doacoes = doacao::all();

            return $doacoes;

        } catch(\Exception $e){
            return $e;
        }   
    }

    //pesquisar doacoes para o repasse
    public function findDoacaoRepasse(){
        try{
            $doacoes = doacao::select('ddr_id as CÓDIGO - FPR','ddr_matricula as MATRICULA','ddr_nome as NOME DOADOR','doa_valor_mensal as VALOR MENSAL',
                                    'doa_qtde_parcela as QNT. PARCELA','smt_nome as MOTIVO','doa_valor as VALOR TOTAL')
                                ->leftJoin('cad_doador','ddr_id','doa_ddr_id')
                                ->leftJoin('tab_status_motivo','smt_id','doa_smt_id')
                                ->get();

            return $doacoes;

        } catch(\Exception $e){
            return $e;
        }   
    }

    // Relaiza a pesquisa com os filtros
    public function findFilterDoaRepasse($where){
        try{
            $sql = "select ddr_id, ddr_matricula, ddr_nome, doa_valor_mensal, doa_qtde_parcela, smt_nome, doa_valor
                    from cad_doacao
                    left join cad_doador
                        on ddr_id = doa_ddr_id
                    left join tab_status_motivo
                        on smt_id = doa_smt_id  
                    where " . $where;

            $doacoes = DB::select($sql);
            return $doacoes;
            
        } catch(\Exception $e){
            return $e;
        }   
    }

}