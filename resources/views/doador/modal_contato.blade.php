<div class="modal fade" id="modalContato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cadastrar Contato com Sr(a) <span class="doadorName text-primary"></span>!</h4>
            </div>
            {{ Form::open(['id' => 'formStoreDoacao']) }}
                {{ Form::hidden('ccs_ddr_id','',['id'=> 'ccs_ddr_id']) }}
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
                    {!! Form::button('<span class="glyphicon glyphicon-remove"></span> Cancelar', ['class'=>'btn btn-sm btn-default', 'data-dismiss' => 'modal','id' => 'cancelDoacao', 'name' => 'cancelDoacao']) !!}
                    {!! Form::button('<span class="glyphicon glyphicon-ok"></span> Cadastrar', ['class'=>'btn btn-sm btn-success',
                     'id' => 'submitStoreDoacao', 'name' => 'submitStoreDoacao', 'data-btn-ok-label' => 'Salvar',
                     'data-btn-ok-class' => 'btn-success', 'data-btn-ok-icon-class' => 'material-icons',
                     'data-btn-ok-icon-content' => 'check', 'data-btn-cancel-label' => 'Stoooop!', 'data-btn-cancel-class' => 'btn-danger',
                     'data-btn-cancel-icon-class' => 'material-icons', 'data-btn-cancel-icon-content' => 'close',
                     'data-title' => 'Is it ok?', 'data-content' => 'This might be dangerous']) !!}
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>