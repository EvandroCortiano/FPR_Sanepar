<?php

namespace App\Controllers;

use Illuminate\Http\Request;
use App\Repository\PessoasRepository;
use App\Models\status_contato;
use App\Models\status_motivo;
use App\Repository\DoadorRepository;
use App\Repository\DoacaoRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\pessoas;

class PessoasController extends Controller
{
    protected $pessoas, $doador, $doacao;
    public function __construct(PessoasRepository $pessoas, DoadorRepository $doador, DoacaoRepository $doacao)
    {
        $this->middleware('auth');
        $this->pessoas = $pessoas;
        $this->doador = $doador;
        $this->doacao = $doacao;
    }

    // Retorna pagina das pessoas
    public function index()
    {
        //Buscar Status do Contato com o Doador
        $stc = status_contato::pluck('stc_nome','stc_id');
        //Motivo
        $mtdoa = status_motivo::pluck('smt_nome','smt_id');
        //Mailing
        $pes_campanha = pessoas::groupBy('pes_campanha')->orderBy('created_at','desc')->pluck('pes_campanha', 'pes_campanha');

        return view('pessoas.pessoas')->with(compact('stc','mtdoa','pes_campanha'));
    }

    // Pesquisa os dados da pessoa
    public function find($pes_id)
    {
        $pes = $this->pessoas->find($pes_id);
        return $pes;
    }

    // Retorna a lista de pessoas para o contato telefonico
    public function show(Request $request)
    {
        $data = $request->all();  

        $pessoas = $this->pessoas->show($data['inicial'], $data['final']);

        foreach($pessoas as $pes){
            $pes['pes_nascimento'] = date('d/m/Y', strtotime($pes['pes_nascimento']));

            $pes['link'] = "<a onclick='registrarContatoPessoas($pes->pes_id)' class='btn btn-sm btn-primary' data-toggle='tooltip' title='Registra Contato!' style='margin: 3px;'>
                                <span class='glyphicon glyphicon-earphone'></span></a>
                            <a onclick='cadastrarDoadorDoacao($pes->pes_id)' class='btn btn-sm btn-success' data-toggle='tooltip' title='Cadastrar como doador!' style='margin: 3px;'>
                                <span class='glyphicon glyphicon-user'></span></a>";

            // Telefones
            $pes['telefones'] = '';
            if($pes['pes_tel1']){
                $pes['telefones'] .= "<a onclick='retirarTelefonePessoas($pes->pes_id, \"$pes->pes_tel1\", \"pes_tel1\")' data-toggle='tooltip' title='Apagar telefone da lista!' style='margin:3px;color:red;font-size:11px;'><span class='glyphicon glyphicon-remove'></span></a>" . $pes['pes_tel1'];
            } 
            if ($pes['pes_tel2']) {
                $pes['telefones'] .= "</br><a onclick='retirarTelefonePessoas($pes->pes_id, \"$pes->pes_tel2\", \"pes_tel2\")' data-toggle='tooltip' title='Apagar telefone da lista!' style='margin:3px;color:red;font-size:11px;'><span class='glyphicon glyphicon-remove'></span></a>" . $pes['pes_tel2'];
            } 
            if ($pes['pes_tel3']) {
                $pes['telefones'] .= "</br><a onclick='retirarTelefonePessoas($pes->pes_id, \"$pes->pes_tel3\", \"pes_tel3\")' data-toggle='tooltip' title='Apagar telefone da lista!' style='margin:3px;color:red;font-size:11px;'><span class='glyphicon glyphicon-remove'></span></a>" . $pes['pes_tel3'];
            } 
            if ($pes['pes_tel4']) {
                $pes['telefones'] .= "</br><a onclick='retirarTelefonePessoas($pes->pes_id, \"$pes->pes_tel4\", \"pes_tel4\")' data-toggle='tooltip' title='Apagar telefone da lista!' style='margin:3px;color:red;font-size:11px;'><span class='glyphicon glyphicon-remove'></span></a>" . $pes['pes_tel4'];
            } 
            if ($pes['pes_tel5']){
                $pes['telefones'] .= "</br><a onclick='retirarTelefonePessoas($pes->pes_id, \"$pes->pes_tel5\", \"pes_tel5\")' data-toggle='tooltip' title='Apagar telefone da lista!' style='margin:3px;color:red;font-size:11px;'><span class='glyphicon glyphicon-remove'></span></a>" . $pes['pes_tel5'];
            }

            $pes['info'] = '';
            $pes['flag'] = '';

            $ccsDt = $pes->contato;
            if($ccsDt){
                // formata data
                if($ccsDt['ccs_data']){
                    $ccsDt['ccs_data'] = date('d/m/Y', strtotime($ccsDt['ccs_data']));
                }

                $pes['info'] .= "<div>Obs.: " . $ccsDt['ccs_obs'] . "</div>";
                $pes['info'] .= "<div>Data: " . $ccsDt['ccs_data'] . "</div>";
                $pes['info'] .= "<div>Status: " . $ccsDt->statusContato->stc_nome . "</div>";
                if($ccsDt['ccs_stc_id'] == 3){
                    $pes['flag'] = '<a class="btn btn-xs btn-danger" style="width:50px;height:25px;" data-toggle="tooltip" title="Não deseja ser Doador!"></a>';
                } else if ($ccsDt['ccs_stc_id'] == 1){
                    $pes['flag'] = '<a class="btn btn-xs btn-warning" style="width:50px;height:25px;" data-toggle="tooltip" title="Não Atendeu a ligação!"></a>';
                } else if ($ccsDt['ccs_stc_id'] == 2){
                    $pes['flag'] = '<a class="btn btn-xs btn-info" style="width:50px;height:25px;" data-toggle="tooltip" title="Pediu para ligar mais tarde!"></a>';
                } else if ($ccsDt['ccs_stc_id'] == 4){
                    $pes['flag'] = '<a class="btn btn-xs btn-success" style="width:50px;height:25px;" data-toggle="tooltip" title="Já é doador!"></a>';
                } else if ($ccsDt['ccs_stc_id'] == 5){
                    $pes['flag'] = '<a class="btn btn-xs btn-danger2" style="width:50px;height:25px;" data-toggle="tooltip" title="Já é doador!"></a>';
                }
            } else {
                $pes['flag'] = '<a class="btn btn-xs btn-default" style="width:50px;height:25px;  data-toggle="tooltip" title="Não houve contato!""></a>';
                $pes['info'] .= '';
            }
            
        }

        return $pessoas;
    }

    //Salvar contato
    public function contatoStorePessoas(Request $request){
        $data = $request->all();
        $contPes = $this->pessoas->contatoStorePessoas($data);
        return $contPes;
    }

    //Cadastra o doador e a doacao
    public function doacaoDoador(Request $request){
        $data = $request->all();
        $dtDdr = array();
        $telDdr = array();
        $doaDdr = array();
        $ccsDdr = array();
        $ccsNew = array();
        $auxCount = 0;
        $error = '';

        // Verifica se nao existe o cadastro para o doador
        $countDoador = $this->doador->findWhere('ddr_pes_id', $data['pes_id'])->get();
        
        if(count($countDoador) > 0){
            $countDoador[0]['Error'] = 'Existe';
            return $countDoador[0];
        } else {

            //Pesquisa e retorna os dados da pessoa
            $pes = $this->pessoas->find($data['pes_id']);

            //Cadastra o Doador
            if($pes){
                $dtDdr['ddr_nome'] = $pes['pes_nome'];
                $dtDdr['ddr_matricula'] = '';
                $dtDdr['ddr_telefone_principal'] = '';
                $dtDdr['ddr_titular_conta'] = $pes['pes_nome'];
                $dtDdr['ddr_endereco'] = $pes['pes_endereco'];
                $dtDdr['ddr_numero'] = $pes['pes_numero'];
                $dtDdr['ddr_complemento'] = $pes['pes_complemento'];
                $dtDdr['ddr_bairro'] = $pes['pes_bairro'];
                $dtDdr['ddr_cep'] = $pes['pes_cep'];
                $dtDdr['ddr_nascimento'] = $pes['pes_nascimento'];
                $dtDdr['ddr_cpf'] = $pes['pes_cpf'];
                $dtDdr['ddr_cidade'] = $pes['pes_cidade'] . " - " . $pes['pes_estado'];
                $dtDdr['ddr_cid_id'] = 0;
                $dtDdr['ddr_pes_id'] = $pes['pes_id'];
                $dtDdr['ddr_email'] = $pes['pes_email'];
                
                // realiza o cadastro do doador
                $ddr = $this->doador->store($dtDdr);

            } else {
                $error .= 'Pessoa contato não encontrado no sistema!!<br/>';
            }

            if($ddr){
                //cadastrar telefone
                $telDdr['tel_ddr_id'] = $ddr->ddr_id;
                for($i=1;$i<=5;$i++){
                    if($pes['pes_tel'.$i]){
                        $telDdr['tel_numero'] = $pes['pes_tel'.$i];
                        $this->doador->storeTelefone($telDdr);
                        $auxCount++;
                    }
                }
            
                //Cadastra a doacao
                $data['doa_ddr_id'] = $ddr->ddr_id;
                $data['created_user_id'] = Auth::user()->id;
                $doa = $this->doacao->store($data);
            } else {
                $error .= 'Ocorreu um erro ao salvar o Doador!!<br/>';
            }

            if(!$doa){
                $error .= 'Ocorreu um erro ao salvar a doação do Sr(a) ' . $ddr->ddr_nome . '!!<br/>';
            }
            if($auxCount == 0){
                $error .= 'Ocorreu um erro ao salvar os telefone(s) do Sr(a) ' . $ddr->ddr_nome . '!!<br/>';
            }

            //vincular os contato com o novo cadastro do doador
            $ccsDdr['ccs_ddr_id'] = $ddr->ddr_id;
            $contatoDdr = $this->doador->updateContatoPesDdr($ccsDdr, $data['pes_id']);
            if($contatoDdr == 'Error'){
                $error .= 'Ocorreu um erro ao salvar contatos realizados do Sr(a) ' . $ddr->ddr_nome . '!!<br/>';         
            } else {
                // Cadastra contato de doacao
                $ccsNew['ccs_ddr_id'] = $ddr->ddr_id;
                $ccsNew['ccs_data'] = Carbon::now()->toDateTimeString();
                $ccsNew['ccs_obs'] = 'Cadastro de doacao';
                $ccsNew['ccs_pes_id'] = $data['pes_id'];
                $ccsNew['ccs_stc_id'] = 4;
                
                $cadCcs = $this->doador->contatoStore($ccsNew);
            }
            if(!$cadCcs){
                $error .= 'Ocorreu um erro ao salvar status do doador no contato ao doadores';
            }

            if($error == ''){
                $ddr['Error'] = "Novo";
                return $ddr;
            } else {
                $error['Error'] = "Error";
                return $error;
            }
        }
    }

    //exclui telefone
    function deleteTelefonePessoas(Request $request){
        $data = $request->all();
        //altera valor
        $data[$data['pes_idNumero']] = null;
        //realiza a atualizacao removendo o telefone do contato
        $updData = $this->pessoas->update($data['pes_id'], $data);

        return $updData;
    }
}
