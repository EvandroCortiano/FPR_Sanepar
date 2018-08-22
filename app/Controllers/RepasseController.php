<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\DoacaoRepository;

class RepasseController extends Controller
{

    protected $doacao;

    public function __construct(DoacaoRepository $doacao)
    {
        $this->middleware('auth');
        $this->doacao = $doacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recebe doacoes
        $doa = $this->doacao->findRepasse();
        
        foreach($doa as $d){
            $d->doador;
        }

        return $doa;

        return view('repasse.dashboard');
    }
}
