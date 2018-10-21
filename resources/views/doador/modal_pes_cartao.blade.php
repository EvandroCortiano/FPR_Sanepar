<div class="modal fade" id="modalPesCartao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cadastro pessoas gerar Cartão!</h4>
            </div>
            {{ Form::open(['id' => 'formStorePesCartao']) }}
                {{ Form::hidden('ccp_ddr_id', $ddr['ddr_id'],['id'=>'ccp_ddr_id']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('ccpNome', 'Nome:') }}
                            {{ Form::text('ccp_nome', '', ['class' => 'form-control', 'id' => 'ccp_nome']) }}
                        </div>  
                        <div class="col-sm-6">
                            {{ Form::label('ccpObs', 'Observação:') }}
                            {{ Form::textarea('ccp_obs', '', ['class' => 'form-control', 'id' => 'ccp_obs', 'rows' => '3']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @include('layouts.botoes',['buttons' => ['btnStore', 'btnCancel']])
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>