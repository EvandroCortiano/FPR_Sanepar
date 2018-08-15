<!-- Modal -->
<div class="modal fade" id="deleteTelefone" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Excluir o telefone <span class="numberTel text-primary"></span> !</h4>
            </div>
            <div class="modal-footer">
                {{ Form::open(['id' => 'formDeleteTelefone']) }}
                    {{ Form::hidden('pes_id', '', ['id'=>'pes_id']) }}
                    {{ Form::hidden('pes_idNumero', '', ['id'=>'pes_idNumero']) }}
                    @include('layouts.botoes',['buttons' => ['btnDeleted', 'btnCancel']])
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>