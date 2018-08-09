<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\PessoasRepository;
use App\Models\status_contato;

class PessoasController extends Controller
{
    protected $pessoas;
    public function __construct(PessoasRepository $pessoas)
    {
        $this->pessoas = $pessoas;
    }

    public function index()
    {
        //Buscar Status do Contato com o Doador
        $stc = status_contato::pluck('stc_nome','stc_id');

        return view('pessoas.pessoas')->with(compact('stc'));
    }

    public function show()
    {
        $pessoas = $this->pessoas->show();

        return $pessoas;

        foreach($doador as $ddr){
            $ddr['link'] = "<a href='/doador/edit/".$ddr->ddr_id."' class='btn btn-sm btn-info' data-toggle='tooltip' title='Editar Doador, Cadastrar Doação'>
                <span class='glyphicon glyphicon-usd'></span></a> &nbsp;&nbsp;
                <a onclick='registrarContato($ddr->ddr_id)' class='btn btn-sm btn-primary' data-toggle='tooltip' title='Registra Contato'>
                <span class='glyphicon glyphicon-earphone'></span></a>";

            $ddr['info'] = '';
            $ddr['flag'] = '';

            $ccsDt = $ddr->contato;
            if($ccsDt){
                $ddr['info'] .= "<div>Obs.: " . $ccsDt['ccs_obs'] . "</div>";
                $ddr['info'] .= "<div>Data: " . $ccsDt['ccs_data'] . "</div>";
                $ddr['info'] .= "<div>Status: " . $ccsDt->statusContato->stc_nome . "</div>";
                if($ccsDt['ccs_stc_id'] == 1){
                    $ddr['flag'] = '<a class="btn btn-xs btn-danger" style="width:50px;height:25px;" data-toggle="tooltip" title="Não deseja ser Doador!"></a>';
                } else if ($ccsDt['ccs_stc_id'] == 2){
                    $ddr['flag'] = '<a class="btn btn-xs btn-warning" style="width:50px;height:25px;" data-toggle="tooltip" title="Não Atendeu a ligação!"></a>';
                }
            } else {
                $ddr['flag'] = '<a class="btn btn-xs btn-default" style="width:50px;height:25px;  data-toggle="tooltip" title="Não houve contato!""></a>';
                $ddr['info'] .= '';
            }
            
        }

        return $pessoas;
    }
}
