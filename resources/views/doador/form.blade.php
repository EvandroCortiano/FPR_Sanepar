@extends('templete')

@section(`title`)
Cadastrar novo doador!
@stop

@section('content')

<div class="container">
	
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-head-line">Cadastro do Doador</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"> CADASTRO DOADOR </div>
				<div class="panel-body">
					{!! Form::open(['id' => 'formStoreDoador']) !!}
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12 formLabelInput">
								{{ Form::label('ddrNome', 'Nome do Doador') }}
								{{ Form::text('ddr_nome', '', ['class' => 'form-control', 'id' => 'ddr_nome']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrMatricula', 'Matricula') }}
								{{ Form::text('ddr_matricula', '', ['class' => 'form-control', 'id' => 'ddr_matricula']) }}
							</div>
							<div class="col-sm-8 formLabelInput2">
								{{ Form::label('ddrTitularConta', 'Titular da Conta') }}
								{{ Form::text('ddr_titular_conta', '', ['class' => 'form-control', 'id' => 'ddr_titular_conta']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-7 formLabelInput2">
								{{ Form::label('ddrEndereco', 'Endereço') }}
								{{ Form::text('ddr_endereco', '', ['class' => 'form-control', 'id' => 'ddr_endereco']) }}
							</div>
							<div class="col-sm-2 formLabelInput2">
								{{ Form::label('ddrNumero', 'Numero') }}
								{{ Form::text('ddr_numero', '', ['class' => 'form-control', 'id' => 'ddr_numero']) }}
							</div>
							<div class="col-sm-3 formLabelInput2">
								{{ Form::label('ddrComplemento', 'Complemento') }}
								{{ Form::text('ddr_complemento', '', ['class' => 'form-control', 'id' => 'ddr_complemento']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCep', 'Cep') }}
								{{ Form::text('ddr_cep', '', ['class' => 'form-control', 'id' => 'ddr_cep']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrBairro', 'Bairro') }}
								{{ Form::text('ddr_bairro', '', ['class' => 'form-control', 'id' => 'ddr_bairro']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCidade', 'Cidade - Estado') }}
								{{ Form::text('ddr_cidade', '', ['class' => 'form-control', 'id' => 'ddr_cidade']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 formLabelInput2">
								{{ Form::label('ddrNascimento', 'Data Nascimento') }}
								{{ Form::date('ddr_nascimento', '', ['class' => 'form-control', 'id' => 'ddr_nascimento']) }}
							</div>
							<div class="col-sm-6 formLabelInput2">
								{{ Form::label('ddrCpf', 'CPF') }}
								{{ Form::text('ddr_cpf', '', ['class' => 'form-control', 'id' => 'ddr_cpf']) }}
							</div>
						</div>
					</div>
					<hr />
					@include('layouts.botoes',['buttons' => ['btnStore']])
					{{ Form::close() }}
				</div>
			</div>
		</div>
		
	</div>
</div>
<!-- SCRIPT DOADOR  -->
<script src="{{ asset('js/doador.js') }}"></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$("#menu-top #doadorMenu").addClass('menu-top-active');
	});
</script>
@stop