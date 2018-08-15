<nav>
@if(isset($buttons))
    @if(in_array('btnStore',$buttons))
		{{ Form::button('<span class="glyphicon glyphicon-ok"></span> Cadastrar', ['class' => 'btn btn-sm btn-success', 
    		'id' => 'btnModalStore', 'name' => 'btnModalStore', 'style' => 'float:right; margin: 0px 0px 0px 10px;', 'data-toggle' => 'modalStore',
    		'data-btn-ok-label' => ' Sim', 'data-btn-ok-icon' => 'glyphicon glyphicon-ok-circle', 'data-btn-ok-class' => 'btn-sm btn-success', 
            'data-btn-cancel-label' => ' Não', 'data-btn-cancel-icon' => 'glyphicon glyphicon-ban-circle', 'data-btn-cancel-class' => 'btn-sm btn-danger',
            'data-title' => 'Confirma cadastro da informação?']) }}
		
    @endif
    @if(in_array('btnDestroy',$buttons))
    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span> Excluir', ['class' => 'btn btn-sm btn-danger', 
    		'id' => 'btnModalDestroy', 'name' => 'btnModalDestroy', 'style' => '', 'data-toggle' => 'modalDestroy',
    		'data-btn-ok-label' => ' Sim', 'data-btn-ok-icon' => 'glyphicon glyphicon-ok-circle', 'data-btn-ok-class' => 'btn-sm btn-success', 
            'data-btn-cancel-label' => ' Não', 'data-btn-cancel-icon' => 'glyphicon glyphicon-ban-circle', 'data-btn-cancel-class' => 'btn-sm btn-danger',
            'data-title' => 'Confirma a exclusão do registro?']) }}
    @endif
    @if(in_array('btnDeleted',$buttons))
    	{{ Form::button('<span class="glyphicon glyphicon-trash"></span> Excluir', ['class' => 'btn btn-sm btn-danger', 
    		'id' => 'btnModalDeleted', 'name' => 'btnModalDeleted', 'style' => 'float:right; margin: 0px 0px 0px 10px;']) }}
    @endif
    @if(in_array('btnClear',$buttons))
    	{{ Form::button('<span class="glyphicon glyphicon-erase"></span> Limpar', ['class' => 'btn btn-sm btn-warning',
    		'id' => 'btnModalClear', 'name' => 'btnModalClear', 'style' => '', 'data-toggle' => 'modalClear',
    		'data-btn-ok-label' => 'Sim', 'data-btn-ok-icon' => 'glyphicon glyphicon-ok-circle', 'data-btn-ok-class' => 'btn-sm btn-success',
    		'data-btn-cancel-label' => 'Não', 'data-btn-cancel-icon' => 'glyphicon glyphicon-ban-circle', 'data-btn-cancel-class' => 'btn-sm btn-danger',
    		'data-title' => 'Deseja limpar o formulário?']) }}
    @endif
    @if(in_array('btnEdit',$buttons))
        {{ Form::button('<span class="glyphicon glyphicon-edit"></span> Atualizar', ['class' => 'btn btn-sm btn-success', 
            'id' => 'btnModalEdit', 'name' => 'btnModalEdit', 'style' => 'float:right; margin: 0px 0px 0px 10px;', 'data-toggle' => 'modalStore',
            'data-btn-ok-label' => ' Sim', 'data-btn-ok-icon' => 'glyphicon glyphicon-ok-circle', 'data-btn-ok-class' => 'btn-sm btn-success', 
            'data-btn-cancel-label' => ' Não', 'data-btn-cancel-icon' => 'glyphicon glyphicon-ban-circle', 'data-btn-cancel-class' => 'btn-sm btn-danger',
            'data-title' => 'Confirma atualização da(s) informação(ões)?']) }}
    @endif
    @if(in_array('btnBack',$buttons))
    	{{ Form::button('<span class="fa fa-mail-reply"></span> Voltar', ['class' => 'btn btn-sm btn-default', 'id' => 'btnModalBack', 'name' => 'btnModalBack', 'style' => '']) }}
    @endif
    @if(in_array('btnCancel',$buttons))
    	<button type="button" class="btn btn-sm btn-default pull-right" data-dismiss="modal" style=""><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
    @endif
    @if(in_array('btnPassScreen',$buttons))
    	{!! Form::button('<span class="glyphicon glyphicon-arrow-right"></span> Confirmar e avançar', ['class'=>'btn btn-sm btn-success', 'id' => 'btnPassScreen', 'name' => 'btnPassScreen', 'style' => '']) !!}
    @endif
    @if(in_array('btnPrintOut',$buttons))
    	{!! Form::button('<span class="fa fa-print"></span> Imprimir', ['class'=>'btn btn-sm btn-success', 'id' => 'btnPrintOut', 'name' => 'btnPrintOut', 'style' => '']) !!}
    @endif
    
@endif
</nav>