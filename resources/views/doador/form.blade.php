@extends('templete')

@section(`title`)
	Bem vindo ao Blog Code-Laravel
@stop

@section('content')

	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-head-line">Cadastro do Doador e suas doações</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"> CADASTRO DOADOR </div>
						<div class="panel-body">
							{!! Form::open(['id' => 'formStoreDoador']) !!}
								<div class="form-group">
									{{ Form::label('ddrNome', 'Nome do Doador') }}
									{{ Form::text('ddr_nome', '', ['class' => 'form-control', 'id' => 'ddr_nome']) }}
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											{{ Form::label('ddrMatricula', 'Matricula') }}
											{{ Form::text('ddr_matricula', '', ['class' => 'form-control', 'id' => 'ddr_matricula']) }}
										</div>
										<div class="col-sm-6">
											{{ Form::label('ddrTelefone', 'Telefone') }}
											{{ Form::text('ddr_telefone_principal', '', ['class' => 'form-control', 'id' => 'ddr_telefone_principal']) }}
										</div>
									</div>
								</div>
								<hr />
								{!! Form::button('<span class="glyphicon glyphicon-ok"></span> Cadastrar', ['class'=>'btn btn-sm btn-success', 'id' => 'submitStoreDoador', 'name' => 'submitStoreDoador']) !!}
							{{ Form::close() }}
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"> DOAÇÃO </div>
						<div class="panel-body">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/doador.js') }}"></script>
@stop