<!-- Modal -->
<div class="modal fade" id="doadorExisteEncaminhar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">
                <br/> O(A) Doador(a) <span class="nomeDoador text-primary"></span> já esta cadastrado na lista de doadores!<br/>
                <br/> Deseja visualizar seu cadastro?<br/>
                </h4>
            </div>
            <div class="modal-footer">
                {{ Form::open(['id' => 'formDoadorEncaminhar']) }}
                    {{ Form::hidden('doador_pes_id', '', ['id'=>'doador_pes_id']) }}
                    {{ Form::hidden('doador_id', '', ['id'=>'doador_id']) }}
                    {{ Form::button('<span class="glyphicon glyphicon-remove"></span> Cancelar', ['class'=>'btn btn-sm btn-default', 'data-dismiss' => 'modal','id' => 'cancelDoacao', 'name' => 'cancelDoacao']) }}
                    {{ Form::button('<span class="glyphicon glyphicon-ok"></span> Sim, visualizar cadastro!', ['class'=>'btn btn-sm btn-success', 'id' => 'irCadastro', 'name' => 'irCadastro']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>