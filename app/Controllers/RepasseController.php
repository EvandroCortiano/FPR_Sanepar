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
    public function findFiltersReapsse(Request $request){
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
                $where .= " AND doa_data_final < '" . $pesq['dataFim'] . "'";
            }

            //realiza a pesquisa
            $doa = $this->repasse->findFilterDoaRepasse($where);
            return $doa;
        } else{
            return $data[] = ['status'=>'Error','msg'=>'Favor selecionar uma data Inicio e/ou Final valida!'];
        }

        return $pesq;
    }
}
