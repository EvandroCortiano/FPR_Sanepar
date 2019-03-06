<div class="modal fade" id="modalAlterarDoacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Alterar doação!</h4>
            </div>
            {{ Form::open(['id' => 'formAlterarDoa']) }}
                {{ Form::hidden('doa_ddr_id','',['id'=> 'doa_ddr_id']) }}
                {{ Form::hidden('doa_id','',['id'=> 'doa_id']) }}
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-sm-12">
                            <div id="dtDoacao" style="margin-bottom: 10px;"></div>
                        </div>
                        <div class="col-sm-4">
                            {{ Form::label('Novo Valor:') }}
                            {{ Form::text('doa_valor_mensal', '', ['class' => 'form-control text-right', 'id' => 'doa_valor_mensal', 'data-mask-type' => 'money']) }}
                        </div>
                        <div class="col-sm-8">
                            {{ Form::label('delObs', '* Justificativa:') }}
                            {{ Form::textarea('doa_justifica_cancelamento', '', ['class' => 'form-control', 'id' => 'doa_justifica_cancelamento', 'rows' => '3']) }}
                        </div>
                    </div>
                    <div class="alert alert-danger">
                        ATENÇÃO: ao alterar a doação, a mesma não pode ser reativada.<br/>
                        A data de inicio da doação permanece, porém o valor deve ser alterado!
                    </div>
                </div>
                <div class="modal-footer">
                    @include('layouts.botoes',['buttons' => ['btnCancel', 'btnEdit']])
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>