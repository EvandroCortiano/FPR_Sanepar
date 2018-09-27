<?php

namespace App\Repository;

use App\Models\doacao;
use Illuminate\Support\Facades\DB;
use App\Models\cartao;


class CartaoRepository{

    // retornar todos os id's de doacao ja enviados para confeccao dos cartoes
    public function idsRemessaDoaCar(){
        try{
            $sqlCar = "select group_concat(car_doa_id) as car_doa_ids from cad_cartao";
            $cartoes = DB::select($sqlCar);
            return $cartoes;
        } catch(\Exception $e){
            return $e;
        }
    }
    
    // Relaiza a pesquisa com os filtros
    public function findCartaoRepasse($where){
        try{
            $sql = "select ddr_id, ddr_matricula, ddr_nome, doa_valor_mensal, doa_qtde_parcela, smt_nome, 
                        doa_valor, ddr_titular_conta, ddr_cidade, doa_data, doa_data_final, ddr_nascimento,
                        ddr_endereco, ddr_numero, ddr_complemento, ddr_cep, ddr_bairro, doa_id
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

    // Realiza o cadastro do repasse (cartao + Pro Renal)
    public function store($data){
        try{
            return cartao::create($data);
        }catch(\Exception $e){
            return $e;
        }
    }

    // pesquisa as datas de envio
    public function findDataEnvio(){
        try{
            // $sql = "select car_data from cad_cartao GROUP BY car_data;";
            // $date = DB::select($sql);

            $date = cartao::select('car_data', DB::raw('count(*) as total'))->groupBy('car_data')->pluck('car_data','car_data');
            return $date;
        }catch(\Exception $e){
            return $e;
        }
    }

    // Relaiza a pesquisa com os filtros
    public function findCartaoList($where){
        try{
        $sql = "select car_data, ddr_nome, ddr_titular_conta, ddr_nascimento, ddr_endereco, ddr_numero, ddr_complemento, ddr_cep, ddr_cidade, doa_data
                    from cad_cartao
                    left join cad_doador
                        on ddr_id = car_ddr_id
                    left join cad_doacao
                        on doa_id = car_doa_id" 
                . $where;

        $listCard = DB::select($sql);
    
        return $listCard;
            
        } catch(\Exception $e){
            return $e;
        }   
    }
}