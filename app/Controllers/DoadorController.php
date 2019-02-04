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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repository\CartaoRepository;
use Illuminate\Support\Facades\Mail;
use App\Mail\admMail;

class DoadorController extends Controller
{
    protected $doador, $doacao, $cartao;

    public function __construct(DoadorRepository $doador, DoacaoRepository $doacao, CartaoRepository $cartao)
    {
        $this->middleware('auth');
        $this->doador = $doador;
        $this->doacao = $doacao;
        $this->cartao = $cartao;
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

        //ajusta valores
        $data['ddr_titular_conta'] = strtoupper($data['ddr_titular_conta']);
        $data['ddr_nome'] = strtoupper($data['ddr_titular_conta']);
        $data['ddr_bairro'] = strtoupper($data['ddr_bairro']);
        $data['ddr_cidade'] = strtoupper($data['ddr_cidade']);
        $data['ddr_complemento'] = strtoupper($data['ddr_complemento']); 
        $data['ddr_endereco'] = strtoupper($data['ddr_endereco']); 

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
            $ddr['ddr_nome'] = '<b>'. strtoupper($ddr['ddr_nome']) . '</b>';
            $ddr['link'] = "<a href='/doador/edit/".$ddr->ddr_id."' class='btn btn-sm btn-info' data-toggle='tooltip' title='Editar Doador, Cadastrar Doação'>
                <span class='glyphicon glyphicon-usd'></span></a> &nbsp;&nbsp;
                <a onclick='registrarContato($ddr->ddr_id)' class='btn btn-sm btn-primary' data-toggle='tooltip' title='Registra Contato'>
                <span class='glyphicon glyphicon-earphone'></span></a>";

            $ddr['info'] = '';
            $ddr['flag'] = '';

            // telefones
            $tel = $ddr->telefone;
            $telefones = '';
            $aux = 0;
            if($tel){
                foreach($tel as $t){
                    if($aux >= 1){
                        $telefones .= '<br/>';
                    }
                    if($t['tel_numero']){
                        $telefones .= $t['tel_numero'];
                    }
                    $aux++;
                }
                $ddr['ddr_telefone_principal'] = $telefones; 
            }

            // Informacoes sobre a doacao
            $doacao = $ddr->doacao;
            if($doacao){
                $ddr['info'] .= 'Data inicio doação: <b>' . date('d/m/Y', strtotime($doacao['doa_data']));
                $ddr['info'] .= '</b><br/>Data final: <b>' . date('d/m/Y', strtotime($doacao['doa_data_final'])) . '</b>';
            }
            
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
        //telefone
        $telefones = $ddr->telefone;

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
                //formata datas
                $d['doa_data'] = date('d/m/Y', strtotime($d['doa_data']));
                $d['doa_data_final'] = date('d/m/Y', strtotime($d['doa_data_final']));
            }
            return view('doador.edit')->with(compact('ddr','telefones','mtdoa','doa'));
        } else {
            return view('doador.edit')->with(compact('ddr','telefones','mtdoa'));
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function update(DoadorRequest $request)
    {
        $data = $request->all();

        //ajusta valores
        $data['ddr_titular_conta'] = strtoupper($data['ddr_titular_conta']);
        $data['ddr_nome'] = strtoupper($data['ddr_titular_conta']);
        $data['ddr_bairro'] = strtoupper($data['ddr_bairro']);
        $data['ddr_cidade'] = strtoupper($data['ddr_cidade']);
        $data['ddr_complemento'] = strtoupper($data['ddr_complemento']); 
        $data['ddr_endereco'] = strtoupper($data['ddr_endereco']); 

        $ddrUpd = $this->doador->update($data, $data['ddr_id']);
        return $ddrUpd;
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
     * Remove the specified doacao.
     */
    public function destroyDoacao(Request $request)
    {
        // recebe dados
        $data = $request->all();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $data['deleted_user_id'] = Auth::user()->id;
        
        $updDoa = $this->doacao->updDoa($data, $data['doa_id']);
        try{
            $updDoa->doa_data = date('d/m/Y', strtotime($updDoa->doa_data));
            $updDoa->doa_data_final = date('d/m/Y', strtotime($updDoa->doa_data_final));
            Mail::to('evandrocortiano@gmail.com')->send(new admMail($updDoa));
        } catch(\Exception $e){
            // return $e;
            return $dat[] = [
                'doa_ddr_id' => $updDoa->doa_ddr_id,
                'error' => 'mail', 
                'msg' => '<h4>Atenção:</h4><h3>Doação cancelada, mas ocorreu um erro ao enviar e-mail.<br/> Favor contactar o responsável pelo sistema!</h3>'
            ];
        }

        return $updDoa;
    }

    /**
     * Find the doador
     */
    public function find($ddr_id){
        $ddr = $this->doador->find($ddr_id);
        return $ddr;
    }

    /**
     * Store contact from doador
     */
    public function contatoStore(Request $request){
        $data = $request->all();
        $data['ccs_data'] = Carbon::now()->toDateTimeString();
        //realiza o cadastro
        $dataContato = $this->doador->contatoStore($data);

        return $dataContato;
    }

    /**
     * Cadastra Telefone
     */
    public function foneStore(Request $request){
        $data = $request->all();
        $cadTel = $this->doador->storeTelefone($data);
        return $cadTel;
    }

    /**
     * Cadastro nomes para gerar cartao
     */
    public function pesCartaoStore(Request $request){
        $data = $request->all();
        //ajusta valores
        $data['ccp_nome'] = strtoupper($data['ccp_nome']);

        //dados de doacao do doador
        $doa = $this->doacao->findDdr($data['ccp_ddr_id']);
        if(count($doa) > 0){
            $data['ccp_doa_id'] = $doa[0]['doa_id'];
        }

        $ccp = $this->cartao->storePesCar($data);
        return $ccp;
    }
    //lista nomes para o cartao pela doacao e titular
    public function listNomesCar($ccp_ddr_id){
        $ccps = $this->cartao->findPesCartao($ccp_ddr_id)->get();
        // foreach($ccps as $cc){
        //     $cc['acao'] = "<button class='btn btn-ss btn-primary' name='editCcps' onclick='editCcps($cc->ccp_id)' type='button'>
        //                     <span class='glyphicon glyphicon-edit'></span>
        //                    </button>
        //                    <button style='margin-left:9px' class='btn btn-ss btn-danger' name='deletedCcps' onclick='deletedCcps($cc->ccp_id)' type='button'>
        //                     <span class='glyphicon glyphicon-remove'></span>
        //                    </button>";
        // }
        return $ccps;
    }

    // retorna dados cartao
    public function editCcps($ccp_id){
        
    }

    // atualiza dados cartao
    public function updateCcps(){

    }

    // exclui dados cartao
    public function deletedCcps(){

    }
}
