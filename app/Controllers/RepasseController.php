<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\DoacaoRepository;
use App\Repository\RepasseRepository;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\Repository\UsersRepository;
use Carbon\Carbon;
use App\Repository\DoadorRepository;
use App\Repository\SaneparRepository;

class RepasseController extends Controller
{
    
    protected $doacao, $repasse, $usersRepository, $doador, $sanepar;

    public function __construct(DoacaoRepository $doacao, RepasseRepository $repasse, UsersRepository $usersRepository,
        DoadorRepository $doador, SaneparRepository $sanepar)
    {
        $this->middleware('auth');
        $this->doacao = $doacao;
        $this->repasse = $repasse;
        $this->usersRepository = $usersRepository;
        $this->doador = $doador;
        $this->sanepar = $sanepar;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //receber select repasse
        $selectComp = $this->repasse->findCompetenciaSelect();
        //recebe lista dos operadores
        $opera = $this->usersRepository->operadores()->pluck('name', 'id');
        //recebe doacoes
        return view('repasse.dashboard')->with(compact('opera', 'selectComp'));
    }

    /**
     * Display listing all doacao
     */
    public function findAllDoacao()
    {
        //recebe doacoes
        $doa = $this->repasse->findDoacao(); 
        foreach($doa as $d){
            $d->doador;
        }

        return $doa;
    }

    // Salva arquivo da lista de filtros daodores
    public function downloadExcelFiltro(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."'";
            if($pesq['operador'] != null){
                $where .= " AND created_user_id = " . $pesq['operador'];
            }
            // 1 = Cancelado, 2 = Vencido
            if($pesq['statusDoa'] == 1){ 
                $where .= " AND deleted_at is not null";
            } else if($pesq['statusDoa'] == 2){
                //cria novamente o where
                $where = " doa_data_final between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."'";
                $where .= " AND doa_data_final < '" . $pesq['dataFim'] . "'";
                $where .= " AND cad_doacao.deleted_at is null";
            } else {
                $where .= " AND cad_doacao.deleted_at is null";
            }

            //realiza a pesquisa
            $data = $this->repasse->findFilterDoaRepasse($where);
            
            $data = collect($data);
            $data = $data->map(function ($dt){
                return get_object_vars($dt);
            });
            
            foreach($data as $dt){
                $dt['MOTIVO - STATUS'] = '';
            }

            $nomeArq = 'Filtros_FPR_Sanepar_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];

            return Excel::create($nomeArq, function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->store('xls', 'filesExport/', true);;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

    }

    // Salva arquivo com a Producao selecionada
    public function downloadExcelProducao(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."' and cad_doacao.deleted_at is null";

            //realiza a pesquisa
            $data = $this->repasse->findFilterDoaRepasse($where);

            if(count($data) > 0){
                foreach($data as $d){
                    $d->doa_data = date('d/m/Y', strtotime($d->doa_data));
                    $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                }
            }          
            
            $data = collect($data);
            $data = $data->map(function ($dt){
                return get_object_vars($dt);
            });

            $nomeArq = 'Producao_FPR_Sanepar_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];

            return Excel::create($nomeArq, function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->store('xls', 'filesExport/', true);;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }
    }

    // Salva arquivo com os Cancelados
    public function downloadExcelCancelados(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataFim']){
            // cria where's
            $where .= " deleted_at is not null and cad_doacao.deleted_at > '" . $pesq['dataFim'] . "'";
            $on = " on ddr_id = doa_ddr_id ";

            //realiza a pesquisa
            $data = $this->repasse->findSelectForTablJoin('cad_doacao', $where, 'cad_doador', $on);

            if(count($data) > 0){
                foreach($data as $d){
                    $d->deleted_at = date('d/m/Y', strtotime($d->deleted_at));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                    $d->info = 'ok';
                }
            }       
            
            $data = collect($data);
            $data = $data->map(function ($dt){
                return get_object_vars($dt);
            });

            $nomeArq = 'Cancelados_FPR_Sanepar_' . $pesq['dataFim'];

            return Excel::create($nomeArq, function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->store('xls', 'filesExport/', true);;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }
    }

    // Salva arquivo com os a vencer
    public function downloadExcelVencer(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= "doa_data_final between '".$pesq['dataIni']."' and '".$pesq['dataFim']."' and cad_doacao.deleted_at is null";
            $on = " on ddr_id = doa_ddr_id ";

            //realiza a pesquisa
            $data = $this->repasse->findSelectForTablJoin('cad_doacao', $where, 'cad_doador', $on);
            
            if(count($data) > 0){
                foreach($data as $d){
                    $d->deleted_at = date('d/m/Y', strtotime($d->deleted_at));
                    $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                    $d->info = 'ok';
                }
            }   
            
            $data = collect($data);
            $data = $data->map(function ($dt){
                return get_object_vars($dt);
            });

            $nomeArq = 'Vencimentos_FPR_Sanepar_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];

            return Excel::create($nomeArq, function($excel) use ($data) {
                $excel->sheet('mySheet', function($sheet) use ($data)
                {
                    $sheet->fromArray($data);
                });
            })->store('xls', 'filesExport/', true);;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }
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

    //Realiza pesquisa conforme selecionado nos filtros
    public function findFiltersRepasse(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();
        
        // cria variaveis
        $data = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."'";
            if($pesq['operador'] != null){
                $where .= " AND created_user_id = " . $pesq['operador'];
            }
            // 1 = Cancelado, 2 = Vencido
            if($pesq['statusDoa'] == 1){ 
                $where .= " AND deleted_at is not null";
            } else if($pesq['statusDoa'] == 2){
                //cria novamente o where
                $where = " doa_data_final between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."'";
                $where .= " AND doa_data_final < '" . $pesq['dataFim'] . "'";
                $where .= " AND cad_doacao.deleted_at is null";
            } else {
                $where .= " AND cad_doacao.deleted_at is null";
            }

            //realiza a pesquisa
            $doa = $this->repasse->findFilterDoaRepasse($where);

            if(count($doa) > 0){
                foreach($doa as $d){
                    $d->doa_data = date('d/m/Y', strtotime($d->doa_data));
                    $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta . " (" . $d->ddr_nome . ")";
                    }
                }
            }

            return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }

    //Realiza pesquisa da Producao dos operadores
    public function findFilterProducao(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();
        
        // cria variaveis
        $data = array();
        $where = '';
        
        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."' and cad_doacao.deleted_at is null";

            //realiza a pesquisa
            $doa = $this->repasse->findFilterDoaRepasse($where);

            if(count($doa) > 0){
                foreach($doa as $d){
                    $d->doa_data = date('d/m/Y', strtotime($d->doa_data));
                    $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                }
            }

            return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }
    
    //Realiza pesquisa dos cancelados
    public function findFilterCancelados(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();
        
        // cria variaveis
        $data = array();
        $where = '';
        
        // Cria/utiliza filtros
        if($pesq['dataFim']){
            // cria where's
            $where .= " cad_doacao.deleted_at is not null and cad_doacao.deleted_at > '" . $pesq['dataFim'] . "'";
            $on = " on ddr_id = doa_ddr_id ";

            //realiza a pesquisa
            $doa = $this->repasse->findSelectForTablJoin('cad_doacao', $where, 'cad_doador', $on);

            if(count($doa) > 0){
                foreach($doa as $d){
                    $d->deleted_at = date('d/m/Y', strtotime($d->deleted_at));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                    // $d->info = $d->doa_justifica_cancelamento;
                    $d->info = "<a class='text-danger' data-toggle='tooltip' title='".$d->doa_justifica_cancelamento."'>
                        <i class='fas fa-info-circle' style='font-size:1.5em;'></i></a>";
                }
            }

            return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }
    
    //Realiza pesquisa dos vencidos
    public function findFilterVencer(Request $request){
        // Retorna valores para pesquisa
        $pesq = $request->all();
        
        // cria variaveis
        $data = array();
        $where = '';
        
        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= "doa_data_final between '".$pesq['dataIni']."' and '".$pesq['dataFim']."' and cad_doacao.deleted_at is null";
            $on = " on ddr_id = doa_ddr_id ";

            //realiza a pesquisa
            $doa = $this->repasse->findSelectForTablJoin('cad_doacao', $where, 'cad_doador', $on);
            
            if(count($doa) > 0){
                foreach($doa as $d){
                    $d->deleted_at = date('d/m/Y', strtotime($d->deleted_at));
                    $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
                    //Cria lista nome
                    if(!$d->ddr_titular_conta){
                        $d->ddr_nometitular = $d->ddr_nome;
                    } else {
                        $d->ddr_nometitular = $d->ddr_titular_conta;
                    }
                    $d->info = 'ok';
                }
            }

            return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
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

        } else{
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
                    $ddr = $this->doador->findWhere('ddr_matricula',$data['matricula'])->get();
                    //pesquisa doacao
                    if(count($ddr) > 0){
                        $ddr[0]->doacao;
                        $dataCad[] = [
                            'rto_ddr_id' => $ddr[0]->ddr_id,
                            'rto_doa_id' => $ddr[0]->doacao->doa_id,
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
                            'rto_referencia_arr' => $data->referencia_arr
                        ];
                    }
                }
            }

            // Salvar dados no banco
            if(!empty($dataCad) && count($dataCad)){
                foreach ($dataCad as $dt){
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
            }

            if($dataStore || $dataError){
                $dataReturn = [
                    'sucesso' => $dataStore,
                    'error' => $dataError
                ];
                return $dataReturn;
            } else {
                return 'Error';
            }
        }
        // return back();
    }

}
