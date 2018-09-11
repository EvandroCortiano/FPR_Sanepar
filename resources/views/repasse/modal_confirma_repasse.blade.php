<div class="modal fade" id="modalConfirmaRepasse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Repasse Sanepar!</h4>
            </div>
            {{ Form::open(['id' => 'formConfirmaRepasse']) }}
                <div class="modal-body">
                    <div class="alert alert-danger">
                        ATENÇÃO: Confirma a criação do arquivo para Repasse a Sanepar ?<br/>
                        Ao confirmar o arquivo será salvo no sistema como uma nova competência que foi repassada para a Sanepar!<br/>
                        Obs.: Arquivo terá o mesmo conteúdo da tabela da caixa "Criar Produção Sanepar".
                    </div>
                    {{-- <div class="alert alert-info">
                        NOME DO ARQUIVO/COMPETÊNCIA: Repasse_FPR_Sanepar_<span class="htmlRepasse"></span>.xls
                    </div> --}}
                </div>
                <div class="modal-footer">
                    @include('layouts.botoes',['buttons' => ['btnStore', 'btnCancel']])
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>