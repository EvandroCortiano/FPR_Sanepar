<?php

namespace App\Controllers;

use App\doador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoadorRequest;
use App\Repository\DoadorRepository;
use App\Repository\DoacaoRepository;
use App\Models\status_motivo;
use App\Models\status_contato;

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
        //Buscar Status do Contato com o Doador
        $stc = status_contato::pluck('stc_nome','stc_id');
        
        return view('doador.doadores')->with(compact('doadores','stc'));
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
    public function show()
    {
        $doador = $this->doador->findAll();

        foreach($doador as $ddr){
            $ddr['link'] = "<a href='/doador/edit/".$ddr->ddr_id."' class='btn btn-sm btn-info' data-toggle='tooltip' title='Editar Doador, Cadastrar Doação'>
                <span class='glyphicon glyphicon-usd'></span></a> &nbsp;&nbsp;
                <a onclick='registrarContato($ddr->ddr_id)' class='btn btn-sm btn-primary' data-toggle='tooltip' title='Registra Contato'>
                <span class='glyphicon glyphicon-earphone'></span></a>";
            $ddr['status'] = '...';
        }

        return $doador;
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

        //Motivo
        $mtdoa = status_motivo::pluck('smt_nome','smt_id');
        
        if(count($doa) > 0){
            foreach($doa as $d){
                if(!$d->motivo){
                    $d['smt_nome'] = 'Não especificado!';
                } else {
                    $d['smt_nome'] = $d->motivo['smt_nome'];
                }
            }
            return view('doador.edit')->with(compact('ddr','mtdoa','doa'));
        } else {
            return view('doador.edit')->with(compact('ddr','mtdoa'));
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

    /**
     * Find the doador
     */
    public function find($ddr_id){
        $ddr = $this->doador->find($ddr_id);
        return $ddr;
    }
}
