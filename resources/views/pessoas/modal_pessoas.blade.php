<div class="modal fade" id="modalContatoPessoas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cadastrar Contato com Sr(a) <span class="doadorName text-primary"></span>!</h4>
            </div>
            {{ Form::open(['id' => 'formStoreContatoPessoas']) }}
                {{ Form::hidden('ccs_pes_id','',['id'=> 'ccs_pes_id']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {{ Form::label('stcContato', 'Status Contato:') }}
                            {{ Form::select('ccs_stc_id', $stc, null, ['class' => 'form-control', 'id' => 'ccs_stc_id', 'placeholder' => 'Selecione um status...']) }}
                        </div>  
                        <div class="col-sm-12">
                            {{ Form::label('ccsObservation', 'Observação:') }}
                            {{ Form::textarea('ccs_obs', '', ['class' => 'form-control', 'id' => 'ccs_obs', 'rows' => '4']) }}
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