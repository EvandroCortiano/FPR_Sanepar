<div class="modal fade" id="modalDeletedDoacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cancelar / Suspender doação!</h4>
            </div>
            {{ Form::open(['id' => 'formDeletedDoa']) }}
                {{ Form::hidden('doa_ddr_id','',['id'=> 'doa_ddr_id']) }}
                {{ Form::hidden('doa_id','',['id'=> 'doa_id']) }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {{ Form::label('delObs', 'Justificativa:') }}
                            {{ Form::textarea('doa_justifica_cancelamento', '', ['class' => 'form-control', 'id' => 'doa_justifica_cancelamento', 'rows' => '3']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @include('layouts.botoes',['buttons' => ['btnDeleted', 'btnCancel']])
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>