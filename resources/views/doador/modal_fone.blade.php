<div class="modal fade" id="modalCadFone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cadastrar telefone!</h4>
            </div>
            {{ Form::open(['id' => 'formStoreFone']) }}
                {{ Form::hidden('tel_ddr_id','',['id'=> 'tel_ddr_id']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('telNumero', 'Telefone:') }}
                            {{ Form::text('tel_numero', '', ['class' => 'form-control', 'id' => 'tel_numero', 'placeholder' => '(XX) XXXX-XXXX', 'data-mask-type' => 'phone']) }}
                        </div>  
                        <div class="col-sm-6">
                            {{ Form::label('telObs', 'Observação:') }}
                            {{ Form::textarea('tel_obs', '', ['class' => 'form-control', 'id' => 'tel_obs', 'rows' => '3']) }}
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