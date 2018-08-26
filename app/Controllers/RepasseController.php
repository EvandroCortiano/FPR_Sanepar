<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\DoacaoRepository;
use App\Repository\RepasseRepository;
use Maatwebsite\Excel\Facades\Excel;

class RepasseController extends Controller
{

    protected $doacao, $repasse;

    public function __construct(DoacaoRepository $doacao, RepasseRepository $repasse)
    {
        $this->middleware('auth');
        $this->doacao = $doacao;
        $this->repasse = $repasse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recebe doacoes
        return view('repasse.dashboard');
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
}
