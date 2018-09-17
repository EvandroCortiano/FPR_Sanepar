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

            //realiza a pesquisa
            $doa = $this->cartao->findCartaoRepasse($where, 'Pesquisa');

            if(count($doa) > 0){
                foreach($doa as $d){
                    $d->doa_data = date('d/m/Y', strtotime($d->doa_data));
                    
                    //Cria endereco
                    $d->endereco = $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : '');
                }
            }

            return $doa;

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

            $data = $this->cartao->findCartaoRepasse($where, 'Excel');

            $nomeArq = 'Cartao_mais_Pro_' . $pesq['dataIni'] . "_" . $pesq['dataFim'];
            
            if(count($data) > 0){
                foreach($data as $d){
                    // criar array para arquivo excel
                    $dataExcel[] = [
                        'DOADOR' => $d->ddr_nome,
                        'ENDEREÇO'=> $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : ''),
                        'DATA DOÇÃO' => date('d/m/Y', strtotime($d->doa_data)),
                        'TITULAR CONTA' => $d->ddr_titular_conta
                    ];
                    
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
                })->store('xls', 'filesExportCartao/', true);;
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
            
        }

        //realiza a pesquisa
        $card = $this->cartao->findCartaoList($where);

        if(count($card) > 0){
            foreach($card as $d){
                //Cria endereco
                $d->endereco = $d->ddr_endereco . ", " . $d->ddr_numero . ($d->ddr_complemento != '' ? "( " . $d->ddr_complemento . " )" : '');
            }
            return $card;
        }
        return $pesq;
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