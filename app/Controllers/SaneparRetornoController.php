<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repository\SaneparRepository;
use App\Repository\RepasseRepository;
use App\Repository\DoadorRepository;
use App\Repository\DoacaoRepository;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class SaneparRetornoController extends Controller
{
    protected $doacao, $doador, $sanepar, $repasse;

    public function __construct(SaneparRepository $sanepar, RepasseRepository $repasse, 
                        DoadorRepository $doador, DoacaoRepository $doacao){
        $this->middleware('auth');
        $this->repasse = $repasse;
        $this->sanepar = $sanepar;
        $this->doador = $doador;
        $this->doacao = $doacao;
    }

    // DASHBOARD SANEPAR
    public function index(){
        //receber select repasse
        $selectComp = $this->repasse->findCompetenciaSelect();

        //recebe referencia retorno sanepar
        $selectRef = $this->sanepar->findSaneparDate();
        foreach($selectRef as $dt){
            $selectRef[$dt] = substr($dt,0,4) . '/' . substr($dt,4,5);
        }
        
        return view('sanepar.dashboard')->with(compact('selectComp','selectRef'));
    }

    // CRIA E SALVA ARQUIVO PARA ENVIAR A SANEPAR, CRIA REMESSA
    public function downloadExcelRepasse(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $dataComp = array();
        $dataRepDB = array();
        $dataRep = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            //realiza a pesquisa
            $where .= "doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] . "' and cad_doacao.deleted_at is null";

            $data = $this->repasse->findDoacaoRepasse($where);
            
            // $data = collect($data);
            // $data = $data->map(function ($dt){
            //     return get_object_vars($dt);
            // });
           
            $nomeArq = 'Repasse_FPR_Sanepar_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];
            $date = Carbon::now()->toDateString();
            $dateMes = date('m/Y', strtotime($date));

            // cria competencia
            $dataComp = [
                'cpa_mes_ref' => $dateMes,
                'cpa_data_inicio' => $pesq['dataIni'],
                'cpa_data_fim' => $pesq['dataFim'],
                'cpa_arquivo' => $nomeArq
            ];
            $comp = $this->repasse->storeCompetencia($dataComp);

            // Cria tabela para o repasse e para salvar na base de dados
            foreach($data as $dt){
                $dataRepDB[] = [
                    'cre_doa_id' => $dt->doa_id,
                    'cre_cpa_id' => $comp->cpa_id,
                    'cre_parcela' => 0,
                    'cre_data' => $date
                ];
                $dataRep[] = [
                    'CODIGO - FPR' => $dt->ddr_id,
                    'MATRICULA' => $dt->ddr_matricula,
                    'NOME DOADOR' => $dt->ddr_nome,
                    'VALOR MENSAL' => $dt->doa_valor_mensal,
                    'QNT. PARCELA' => $dt->doa_qtde_parcela,
                    'MOTIVO' => $dt->smt_nome,
                    'VALOR TOTAL' => $dt->doa_valor,
                    'MOTIVO - STATUS' => 'Indeterminado'
                ];
            }

            //Salva valores na base de repasse
            foreach($dataRepDB as $db){
                $repas = $this->repasse->storeRepasse($db);
                if(!$repas){
                    return $data[] = ['status'=>'Error','msg'=>'Error ao salvar doações ao repasse!'];
                }
            }

            return Excel::create($nomeArq, function($excel) use ($dataRep) {
                $excel->sheet('mySheet', function($sheet) use ($dataRep)
                {
                    $sheet->fromArray($dataRep);
                });
            })->store('xls', 'filesExport/', true);;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }
    }

    //Realiza pesquisa do Repasse para Sanepar
    public function findRepasseSanepar(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();
        
        // cria variaveis
        $data = array();
        $where = '';
        
        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            //realiza a pesquisa
            $where .= "doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] . "' and cad_doacao.deleted_at is null";

            $doa = $this->repasse->findDoacaoRepasse($where);
      
            return $doa;

        } else {
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }

    // Pesquisa as doacoes repassadas para a Sanepar
    public function findRepasseSaneparList(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();

        if($pesq['cpa_id']){
            $dataRep = $this->repasse->findDataCompetencia($pesq['cpa_id']);

            return $dataRep;

        } else {
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma competência!'];
        }
    }

    //IMPORTA O ARQUIVO DA SANEPAR
    public function importSanepar(){
        if(Input::hasFile('import_file')){
            $path = Input::file('import_file')->getRealPath();
            //array para valores a ser gravado no banco de dados
            $dataCad = array();
            //cadastro com sucesso
            $dataStore = array();
            //registra linhas sem doador (nao foi encontrado)
            $dataError = array();
            $dataReturn = array();
            
            //ver a competencia
            $dataCom = Excel::selectSheetsByIndex(0)->load($path, function($reader){
                $reader->takeColumns(19); //limita a quantidade de colunas 
                // $reader->skipRows(3); //pula a linha
                // $reader->ignoreEmpty(); //ignora os campos null
                // $reader->takeRows(6); //limita a quantidade de linha
                // $reader->noHeading(); //ignora os cabecalhos 
            })->get();

            //cria dados para salvar na base de retorno sanepar
            if(!empty($dataCom) && $dataCom->count()){
                foreach($dataCom as $data){
                    //pesquisa doadores
                    $data['matricula'] = intval($data['matricula']);

                    $ddr = $this->doador->findWhere('ddr_matricula',$data['matricula'])->get();
                    //pesquisa doacao
                    if(count($ddr) > 0){

                        //verifica se tem doacao
                        if(!$ddr[0]->doacao){
                            $doa_id = '';
                        } else {
                            $doa_id = $ddr[0]->doacao->doa_id;
                        }

                        $ddr[0]->doacao;
                        $dataCad[] = [
                            'rto_ddr_id' => $ddr[0]->ddr_id,
                            'rto_doa_id' => $doa_id,
                            'rto_data' => Carbon::now()->toDateString(),
                            'rto_ur' => $data->ur,
                            'rto_local' => $data->local,
                            'rto_cidade' => $data->cidade,
                            'rto_matricula' => $data->matricula,
                            'rto_nome' => $data->nome,
                            'rto_cpf_cnpj' => $data->cpf_cnpj,
                            'rto_rg' => $data->rg,
                            'rto_uf' => $data->uf,
                            'rto_logr_cod' => $data->logr_cod,
                            'rto_logradouro' => $data->logradouro,
                            'rto_num' => $data->num,
                            'rto_complemento' => $data->complemento,
                            'rto_bai_cod' => $data->bai_cod,
                            'rto_bairro' => $data->bairro,
                            'rto_cep' => $data->cep,
                            'rto_categoria' => $data->categoria,
                            'rto_cod_servico' => $data->cod_servico,
                            'rto_vlr_servico' => $data->vlr_servico,
                            'rto_referencia_arr' => $data->referencia_arr
                        ];
                    } else {
                        $dataError[] = [
                            'error' => 'Matricula/Doador não encontrado!',
                            'rto_ddr_id' => 0,
                            'rto_doa_id' => 0,
                            'rto_data' => Carbon::now()->toDateString(),
                            'rto_ur' => $data->ur,
                            'rto_local' => $data->local,
                            'rto_cidade' => $data->cidade,
                            'rto_matricula' => $data->matricula,
                            'rto_nome' => $data->nome,
                            'rto_cpf_cnpj' => $data->cpf_cnpj,
                            'rto_rg' => $data->rg,
                            'rto_uf' => $data->uf,
                            'rto_logr_cod' => $data->logr_cod,
                            'rto_logradouro' => $data->logradouro,
                            'rto_num' => $data->num,
                            'rto_complemento' => $data->complemento,
                            'rto_bai_cod' => $data->bai_cod,
                            'rto_bairro' => $data->bairro,
                            'rto_cep' => $data->cep,
                            'rto_categoria' => $data->categoria,
                            'rto_cod_servico' => $data->cod_servico,
                            'rto_vlr_servico' => $data->vlr_servico,
                            'rto_referencia_arr' => $data->referencia_arr,
                            'msg_erro' => 'Não foi encontrado o doador no sistema, verifique a matricula!'
                        ];
                    }
                }
            }

            if($dataCad || $dataError){
                $dataReturn = [
                    'sucesso' => $dataCad,
                    'error' => $dataError
                ];
                return $dataReturn;
            } else {
                return 'Error';
            }
        }
        // return back();
    }

    //Salva arquivo sanepar na base de dados
    public function storeReturnSanepar(Request $request){
        $data = $request->all();

        if(isset($data['sucesso'])){      
            foreach ($data['sucesso'] as $dt){
                try{
                    $cadSanepar = $this->sanepar->store($dt);
                    if(!$cadSanepar){
                        dd("Não Gravou-Errror!".$dt['cre_ddr_nome']);
                    } else {
                        $dataStore[] = $cadSanepar;
                    }
                } catch(\Exception $e){
                    return $e;
                }
            }
            return $dataStore;

        } else {
            return false;
        }
    }
    // possivel Errors
    // 0: {errorInfo: ["HY000", 1364, "Field 'rto_cre_id' doesn't have a default value"]}

    //Imprime arquivo pesquisado
    public function downloadExcelRecebidosList(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();

        if($pesq['rto_referencia_arr']){
            $arq = $this->sanepar->findArquivoSanepar($pesq);

            $nomeArq = 'Arquivo_Sanepar_' . $pesq['rto_referencia_arr'];

            return Excel::create($nomeArq, function($excel) use ($arq) {
                $excel->sheet('mySheet', function($sheet) use ($arq)
                {
                    $sheet->fromArray($arq);
                });
            })->store('xls', 'filesExport/', true);

        } else {
            return false;
        }
    }

    // Retorna arquivo recebido pela sanepar
    public function findRecebidosSaneparList(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();

        if($pesq['rto_referencia_arr']){
            $arq = $this->sanepar->findArquivoSanepar($pesq);

            return $arq;
        } else {
            return false;
        }
    }

    // Retornar as datas de referencia para selecionar os arquivos
    public function findSaneparDate(){
        $data = $this->sanepar->findSaneparDate();
        foreach($data as $dt){
            $data[$dt] = substr($dt,0,4) . '/' . substr($dt,4,5);
        }
        return $data;
    }

    // cria arquivo excel com o erro de importação sanepar
    public function storeReturnSaneparError(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();

        return $pesq;

        $nomeArq = 'Arquivo_SaneparError_' . Carbon::now()->toDateString();

        return Excel::create($nomeArq, function($excel) use ($arq) {
            $excel->sheet('mySheet', function($sheet) use ($arq)
            {
                $sheet->fromArray($arq);
            });
        })->store('xls', 'filesExport/', true);
    }
}
