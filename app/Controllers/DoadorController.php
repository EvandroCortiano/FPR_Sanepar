<?php

namespace App\Controllers;

use App\doador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoadorRequest;
use App\Repository\DoadorRepository;
use App\Repository\DoacaoRepository;

class DoadorController extends Controller
{
    protected $doador, $doacao;

    public function __construct(DoadorRepository $doador, DoacaoRepository $doacao)
    {
        $this->doador = $doador;
        $this->doacao = $doacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doadores = $this->doador->findAll();
        
        return view('doador.doadores', ['doadores' => $doadores]);
    }

    /**
     * Show the form for creating a new doador.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doador.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoadorRequest $request)
    {
        $data = $request->all();
        //realiza o cadastro
        $cadDdr = $this->doador->store($data);

        return $cadDdr;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function show(doador $doador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function edit($ddr_id)
    {
        //dados do doador
        $ddr = $this->doador->find($ddr_id);
        //dados de doacao do doador
        $doa = $this->doacao->findDdr($ddr->ddr_id);
        
        if(count($doa) > 0){
            foreach($doa as $d){
                $d->motivo;
            }
            return view('doador.edit')->with(compact('ddr','doa'));
        } else {
            return view('doador.edit')->with(compact('ddr'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, doador $doador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function destroy(doador $doador)
    {
        //
    }
}
