<?php

namespace App\Repository;

use App\Models\sanepar_retorno;
use Illuminate\Support\Facades\DB;

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
            $sql = "SELECT ddr_nome, ddr_titular_conta, ddr_matricula, ddr_cep, ddr_datainclusao,
                        doa_data, doa_data_final, doa_valor_mensal, doa_qtde_parcela, doa_valor
                    FROM (SELECT * FROM cad_doacao WHERE doa_data < '".$data["dtRef1"]."' and deleted_at is null) as doa
                    LEFT JOIN (SELECT * FROM san_retorno WHERE rto_referencia_arr > '".$data["dtRef2"]."') as rto
                        on rto.rto_doa_id = doa.doa_id
                    LEFT JOIN cad_doador
                        on ddr_id = doa_ddr_id
                    WHERE rto.rto_id is null";
            $date = DB::select($sql);
            return $date;
        } catch(\Exception $e){
            return $e;
        }
    }
}