<?php

namespace App\Repository;

use App\Models\doacao;
use Illuminate\Support\Facades\DB;


class CartaoRepository{

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
    public function findDoacaoRepasse($where, $type){
        try{
            if($type == 'Excel'){
                $sql = "select ddr_id as 'CODIGO - FPR', ddr_matricula as 'MATRICULA', ddr_nome as 'NOME DOADOR', doa_valor_mensal as 'VALOR MENSAL', 
                            doa_qtde_parcela as 'QNT. PARCELA', smt_nome as 'MOTIVO', doa_valor as 'VALOR TOTAL'
                        from cad_doacao
                        left join cad_doador
                            on ddr_id = doa_ddr_id
                        left join tab_status_motivo
                        on smt_id = doa_smt_id
                            where " . $where;
            } else {
                $sql = "select ddr_id as 'CODIGO - FPR', ddr_id, ddr_matricula as 'MATRICULA', ddr_matricula, ddr_nome as 'NOME DOADOR', ddr_nome, 
                            doa_valor_mensal as 'VALOR MENSAL', doa_valor_mensal, doa_qtde_parcela as 'QNT. PARCELA', doa_qtde_parcela, smt_nome as 'MOTIVO', smt_nome, 
                            doa_valor as 'VALOR TOTAL', doa_valor
                        from cad_doacao
                        left join cad_doador
                            on ddr_id = doa_ddr_id
                        left join tab_status_motivo
                        on smt_id = doa_smt_id
                            where " . $where;
            }

            $doacoes = DB::select($sql);

            return $doacoes;

        } catch(\Exception $e){
            return $e;
        }   
    }

    // Relaiza a pesquisa com os filtros
    public function findCartaoRepasse($where){
        try{
            $sql = "select ddr_id, ddr_matricula, ddr_nome, doa_valor_mensal, doa_qtde_parcela, smt_nome, 
                        doa_valor, ddr_titular_conta, ddr_cidade, doa_data, doa_data_final, ddr_nascimento,
                        ddr_endereco, ddr_numero, ddr_complemento, ddr_cep, ddr_bairro, name
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

}