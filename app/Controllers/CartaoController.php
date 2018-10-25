<?php

namespace App\Controllers;
use Illuminate\Http\Request;
use App\Repository\CartaoRepository;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;    

class CartaoController extends Controller
{

    protected $cartao;

    public function __construct(CartaoRepository $cartao)
    {
        $this->middleware('auth');
        $this->cartao = $cartao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recebe datas
        $dateCar = $this->cartao->findDataEnvio();
        foreach($dateCar as $dt){
            $dateCar[$dt] = date('d/m/Y', strtotime($dt));
        }

        //recebe doacoes
        return view('cartaoPro.dashboard')->with(compact('dateCar'));
    }

    /**
     * Cria tabela para repasse cartao +
     */
    public function findProducaoCartao(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';
        
        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            // cria where's
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."' and cad_doacao.deleted_at is null";
            

            //recupera os ids das doacoes ja enviadas para a confeccao
            // $carDoa = $this->cartao->idsRemessaDoaCar();
            // if($carDoa){
            //     $where .= " and doa_id not in (".$carDoa[0]->car_doa_ids.")";
            // }
            $where .= " and car_doa_id is null";

            //realiza a pesquisa
            $doa = $this->cartao->findCartaoRepasse($where);

            if(count($doa) > 0){
                foreach($doa as $d){
                    // $d->doa_data = date('d/m/Y', strtotime($d->doa_data));
                    //Cria endereco
                    // $d->endereco = $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : '');

                    //verifica se doacao gera cartao
                    if($d->ccp_nome){
                        $data[] = [
                            // 'ddr_titular_conta' => $d->ddr_titular_conta,
                            // 'ddr_nome' => $d->ddr_nome,
                            'ccp_nome' => $d->ccp_nome,
                            'ddr_cidade' => $d->ddr_cidade,
                            'doa_data' => date('d/m/Y', strtotime($d->doa_data)),
                            // 'ddr_nascimento' => $d->ddr_nascimento,
                            'endereco' => $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : ''),
                            'ddr_cep' => $d->ddr_cep,
                        ];
                    }

                }
            }

            return $data;
            // return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }

    // CRIA E SALVA ARQUIVO PARA ENVIAR PARA FAZER O CARTAO
    public function downloadExcelProducao(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $dataExcel = array();
        $dataBD = array();
        $error = '';
        $where = '';

        // Cria/utiliza filtros
        if($pesq['dataIni'] && $pesq['dataFim']){
            //realiza a pesquisa
            $where .= " doa_data between '" . $pesq['dataIni'] . "' and '" . $pesq['dataFim'] ."' and cad_doacao.deleted_at is null";
            //Contador de linhas
            $cont = 0;

            //recupera os ids das doacoes ja enviadas para a confeccao
            $carDoa = $this->cartao->idsRemessaDoaCar();
            if($carDoa){
                $where .= " and doa_id not in (".$carDoa[0]->car_doa_ids.")";
            }

            $data = $this->cartao->findCartaoRepasse($where);

            $nomeArq = 'Cartao_mais_Pro_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];
            $aux = '';
            if(count($data) > 0){
                foreach($data as $d){
                    // criar array para arquivo excel
                    if($d->ddr_nome == $d->ddr_titular_conta){
                        $cont++;
                        $dataExcel[] = [
                            'Qnt' => $cont,
                            'Nome Completo' => $d->ddr_nome,
                            'Endereço'=> $d->ddr_endereco,
                            'Numero' => $d->ddr_numero,
                            'Complemento' => $d->ddr_complemento,
                            'Bairro' => $d->ddr_bairro,
                            'Cidade/Estado' => $d->ddr_cidade,
                            'CEP' => $d->ddr_cep,
                            'OBS' => ''
                        ];
                    } else {
                        if($d->ddr_nome != '' && $d->ddr_titular_conta != ''){
                            // com o nome do doador
                            $cont++;
                            $dataExcel[] = [
                                'Qnt' => $cont,
                                'Nome Completo' => $d->ddr_nome,
                                'Endereço'=> $d->ddr_endereco,
                                'Numero' => $d->ddr_numero,
                                'Complemento' => $d->ddr_complemento,
                                'Bairro' => $d->ddr_bairro,
                                'Cidade/Estado' => $d->ddr_cidade,
                                'CEP' => $d->ddr_cep,
                                'OBS' => ''
                            ];
                            // com o nome do titular
                            $cont++;
                            $dataExcel[] = [
                                'Qnt' => $cont,
                                'Nome Completo' => $d->ddr_titular_conta,
                                'Endereço'=> $d->ddr_endereco,
                                'Numero' => $d->ddr_numero,
                                'Complemento' => $d->ddr_complemento,
                                'Bairro' => $d->ddr_bairro,
                                'Cidade/Estado' => $d->ddr_cidade,
                                'CEP' => $d->ddr_cep,
                                'OBS' => ''
                            ];
                        }
                    }

                    // cria array para salvar na base de dados cad_cartao
                    $dataBD[] = [
                        'car_ddr_id' => $d->ddr_id,
                        'car_doa_id' => $d->doa_id,
                        'car_data' => Carbon::now()->toDateString(),
                        'car_arquivo' => $nomeArq
                    ];
                }
            }
            // Salva valores da doa na base de dados e vincula a competencia
            foreach($dataBD as $db){
                $cadCartao = $this->cartao->store($db);
                if(!$cadCartao->car_id){
                    $error .= $cadCartao;
                }
            }
            
            if($error == ''){
                return Excel::create($nomeArq, function($excel) use ($dataExcel) {
                    $excel->sheet('mySheet', function($sheet) use ($dataExcel)
                    {
                        $sheet->fromArray($dataExcel);
                    });
                })->store('xls', 'filesExportCartao/', true);
            } else {
                return false;
            }

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }
    }
    
    /**
     * Cria tabela ja repassado para criar o cartao
     */
    public function findListCartao(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $data = array();
        $where = '';
        // Cria/utiliza filtros
        if($pesq['car_data']){
            
            // cria where's
            $where .= " where car_data = '" . $pesq['car_data'] . "';";

            //realiza a pesquisa
            $card = $this->cartao->findCartaoList($where);

            if(count($card) > 0){
                foreach($card as $d){
                    //Cria endereco
                    $d->endereco = $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : '');
                }
                return $card;
            }
        } else {
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma competência!'];
        }
    }

    // CRIA ARQUIVO COM OS JA ENVIADOS PARA PRODUCAO
    public function downloadExcelList(Request $request){
        $pesq = $request->all();

        // cria variaveis
        $dataExcel = array();
        $where = '';

        // Cria/utiliza filtros
        if($pesq['car_data']){
            //realiza a pesquisa
            $where .= " where car_data = '" . $pesq['car_data'] . "';";
            $nomeArq = 'Listagem_ja_enviados_cartao_Pro_' . $pesq['car_data'];
        } else {
            $nomeArq = 'Listagem_ja_enviados_cartao_Pro_Todos';
        }

        $data = $this->cartao->findCartaoList($where);
        
        if(count($data) > 0){
            foreach($data as $d){
                // criar array para arquivo excel
                $dataExcel[] = [
                    'DOADOR' => $d->ddr_nome,
                    'ENDEREÇO'=> $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : ''),
                    'DATA DE ENVIO' => date('d/m/Y', strtotime($d->car_data)),
                    'DATA DOÇÃO' => date('d/m/Y', strtotime($d->doa_data)),
                    'TITULAR CONTA' => $d->ddr_titular_conta
                ];
            }
        }

        return Excel::create($nomeArq, function($excel) use ($dataExcel) {
            $excel->sheet('mySheet', function($sheet) use ($dataExcel)
            {
                $sheet->fromArray($dataExcel);
            });
        })->store('xls', 'filesExportCartao/', true);

    }
}