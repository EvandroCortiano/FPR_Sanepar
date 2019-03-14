<?php

namespace App\Repository;

use App\Models\doacao;
use Illuminate\Support\Facades\DB;
use App\Models\competencia;
use App\Models\repasse;
use App\Models\sanepar_retorno;


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
    public function findDoacaoRepasse($where){
        try{

                // $sql = "select ddr_id as 'CODIGO - FPR', ddr_matricula as 'MATRICULA', ddr_nome as 'NOME DOADOR', doa_valor_mensal as 'VALOR MENSAL', 
                //             doa_qtde_parcela as 'QNT. PARCELA', smt_nome as 'MOTIVO', doa_valor as 'VALOR TOTAL'


            $sql = "select ddr_id, ddr_matricula, ddr_nome, doa_valor_mensal, doa_qtde_parcela, smt_nome, doa_valor, doa_id
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

    // Relaiza a pesquisa com os filtros
    public function findFilterDoaRepasse($where){
        try{
            $sql = "select ddr_id, ddr_matricula, ddr_nome, doa_valor_mensal, doa_qtde_parcela, smt_nome, doa_valor, ddr_titular_conta, ddr_cidade, doa_data, doa_data_final,
                        name
                    from cad_doacao
                    left join cad_doador
                        on ddr_id = doa_ddr_id
                    left join tab_status_motivo
                        on smt_id = doa_smt_id
                    left join users 
                        on id = cad_doacao.created_user_id  
                    where " . $where;

            $doacoes = DB::select($sql);
   
            return $doacoes;
            
        } catch(\Exception $e){
            return $e;
        }   
    }

    // Relaiza a pesquisa com os filtros
    public function findSelectForTablJoin($table, $where, $join, $on){
        try{
            $sql = "select *
                    from cad_doacao
                    left join " . $join .
                    " " . $on .
                    " where " . $where;

            $doacoes = DB::select($sql);
            return $doacoes;
            
        } catch(\Exception $e){
            return $e;
        }   
    }

    //Criar competencia
    public function storeCompetencia($data){
        try{
            $comp = competencia::create($data);
            return $comp;
        } catch(\Exception $e){
            return $e;
        }   
    }

    //grava repasse
    public function storeRepasse($data){
        try{
            $repa = repasse::create($data);
            return $repa;
        } catch(\Exception $e){
            return $e;
        }     
    }

    // pesquisa as datas de envio
    public function findCompetenciaSelect(){
        try{
            $date = competencia::select('cpa_id', DB::raw("CONCAT(DATE_FORMAT(cpa_data_inicio,'%d/%c/%Y'),' à ',DATE_FORMAT(cpa_data_fim,'%d/%c/%Y')) as competencia"))->pluck('competencia','cpa_id');
            return $date;
        }catch(\Exception $e){
            return $e;
        }
    }

    // retorna os dados da competencia
    public function findDataCompetencia($cpa_id){
        try{
            $sql = "select * from cad_competencia
                        left join cad_repasse
                            on cre_cpa_id = cpa_id
                        left join cad_doacao
                            on doa_id = cre_doa_id
                        left join cad_doador
                            on ddr_id = doa_ddr_id
                        left join tab_status_motivo
                            on smt_id = doa_smt_id
                        where cpa_id = " . $cpa_id . ";";

            $date = DB::select($sql);
            return $date;
        }catch(\Exception $e){
            return $e;
        }       
    }

    //retorna as doacoes alteradas
    public function findAlteracao($dtIni, $dtFim){
        try{
            $sql = "select dr.ddr_nome, dr.ddr_matricula, dr.ddr_cpf, dr.ddr_cep, dr.ddr_titular_conta,
                        nv.doa_valor_mensal, nv.doa_motivo, nv.created_at, an.doa_justifica_cancelamento, an.doa_valor_mensal as an_valor_anterior
                    from cad_doacao as nv
                        left join cad_doacao as an
                            on an.doa_novadoa_id = nv.doa_id
                        left join cad_doador as dr
                            on dr.ddr_id = nv.doa_ddr_id
                    where nv.doa_smt_id = 3
                      and nv.created_at between '" . $dtIni . "' and '" . $dtFim . "';";
            $date = DB::select($sql);
            return $date;
        } catch(\Exception $e){
            return $e;
        }
    }

}