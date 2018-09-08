<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\DoacaoRepository;
use App\Repository\RepasseRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Repository\UsersRepository;

class RepasseController extends Controller
{

    protected $doacao, $repasse, $usersRepository;

    public function __construct(DoacaoRepository $doacao, RepasseRepository $repasse, UsersRepository $usersRepository)
    {
        $this->middleware('auth');
        $this->doacao = $doacao;
        $this->repasse = $repasse;
        $this->usersRepository = $usersRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recebe lista dos operadores
        $opera = $this->usersRepository->operadores()->pluck('name', 'id');
        //recebe doacoes
        return view('repasse.dashboard')->with(compact('opera'));
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

    /**
     * Gera arquivo com os doadores
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel($type){
        //recupera lista com os campos formatados
        $data = $this->repasse->findDoacaoRepasse();
        foreach($data as $dt){
            $dt['MOTIVO - STATUS'] = '';
        }

		return Excel::create('Repasse_FPR_Sanepar', function($excel) use ($data) {
			$excel->sheet('mySheet', function($sheet) use ($data)
	        {
				$sheet->fromArray($data);
	        });
		})->download($type);
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
            $where .= " deleted_at is not null and cad_doacao.deleted_at > '" . $pesq['dataFim'] . "'";
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
                    $d->info = 'ok';
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
      
            // if(count($doa) > 0){
            //     foreach($doa as $d){
            //         $d->doa_data_final = date('d/m/Y', strtotime($d->doa_data_final));
            //         //Cria lista nome
            //         if(!$d->ddr_titular_conta){
            //             $d->ddr_nometitular = $d->ddr_nome;
            //         } else {
            //             $d->ddr_nometitular = $d->ddr_titular_conta;
            //         }
            //         $d->info = 'ok';
            //     }
            // }

            return $doa;

        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }
}
