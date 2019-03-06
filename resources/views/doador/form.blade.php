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
								{{-- <label for="ddrNome">Nome do Doador <span style="color: #c70707;font-size: 11px;">(Cartão + Pró Renal)</span></label>
								{{ Form::text('ddr_nome', '', ['class' => 'form-control', 'id' => 'ddr_nome']) }} --}}
								<label for="ddrTitularConta">Titular da Conta <span style="color: #c70707;font-size: 11px;">(Nome Doador)</span></label>
								{{ Form::text('ddr_titular_conta', '', ['class' => 'form-control', 'id' => 'ddr_titular_conta']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrMatricula', 'Matricula') }}
								{{ Form::text('ddr_matricula', '', ['class' => 'form-control', 'id' => 'ddr_matricula', 'style' => 'width: 92%;']) }}
								<a href="http://site.sanepar.com.br/servicos/quer-pagar-sua-conta" target="_blank" style="margin:-29px 0px 0px 0px;float:right;">
									<img src="{{ asset('img/saneparApp.jpg') }}" width="28px">
								</a>
							</div>
							{{-- <div class="col-sm-8 formLabelInput2">
								<label for="ddrTitularConta">Titular da Conta <span style="color: #c70707;font-size: 11px;">(Nome Doador)</span></label>
								{{ Form::text('ddr_titular_conta', '', ['class' => 'form-control', 'id' => 'ddr_titular_conta']) }}
							</div> --}}
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrNascimento', 'Data Nascimento') }}
								{{ Form::date('ddr_nascimento', '', ['class' => 'form-control', 'id' => 'ddr_nascimento']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCpf', 'CPF') }}
								{{ Form::text('ddr_cpf', '', ['class' => 'form-control', 'id' => 'ddr_cpf', 'data-mask-type' => 'cpf']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-9 formLabelInput2">
								{{ Form::label('ddrEndereco', 'Endereço') }}
								{{ Form::text('ddr_endereco', '', ['class' => 'form-control', 'id' => 'ddr_endereco']) }}
							</div>
							<div class="col-sm-3 formLabelInput2">
								{{ Form::label('ddrNumero', 'Numero') }}
								{{ Form::text('ddr_numero', '', ['class' => 'form-control', 'id' => 'ddr_numero']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrComplemento', 'Complemento') }}
								{{ Form::text('ddr_complemento', '', ['class' => 'form-control', 'id' => 'ddr_complemento']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCep', 'Cep') }}
								{{ Form::text('ddr_cep', '', ['class' => 'form-control', 'id' => 'ddr_cep', 'data-mask-type' => 'cep']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrBairro', 'Bairro') }}
								{{ Form::text('ddr_bairro', '', ['class' => 'form-control', 'id' => 'ddr_bairro']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCidade', 'Cidade - Estado') }}
								{{ Form::text('ddr_cidade', '', ['class' => 'form-control', 'id' => 'ddr_cidade']) }}
							</div>
							<div class="col-sm-8 formLabelInput2">
								{{ Form::label('ddremail', 'E-mail') }}
								{{ Form::text('ddr_email', '', ['class' => 'form-control', 'id' => 'ddr_email']) }}
							</div>
						</div>
						{{-- <div class="row">
							<div class="col-sm-6 formLabelInput2">
								{{ Form::label('ddrNascimento', 'Data Nascimento') }}
								{{ Form::date('ddr_nascimento', '', ['class' => 'form-control', 'id' => 'ddr_nascimento']) }}
							</div>
							<div class="col-sm-6 formLabelInput2">
								{{ Form::label('ddrCpf', 'CPF') }}
								{{ Form::text('ddr_cpf', '', ['class' => 'form-control', 'id' => 'ddr_cpf']) }}
							</div>
						</div> --}}
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