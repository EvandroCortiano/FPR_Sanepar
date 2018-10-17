@extends('templete')

@section(`title`)
Cadastro de Doador e suas Doações
@stop

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="page-head-line titlePrimary">Cadastro do Doador e suas doações</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading"> CADASTRO DOADOR </div>
				<div class="panel-body" style="padding: 15px;">
					{{ Form::open(['id' => 'formupdateDoador']) }}
					{{ Form::hidden('ddr_id', $ddr['ddr_id'],['id'=>'ddr_id']) }}
					<div class="form-group">
						<div class="row">
							<div class="col-sm-12 formLabelInput">
								<label for="ddrNome">Nome do Doador <span style="color: #c70707;font-size: 11px;">(Cartão + Pró Renal)</span></label>
								{{ Form::text('ddr_nome', $ddr['ddr_nome'], ['class' => 'form-control', 'id' => 'ddr_nome']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrMatricula', 'Matricula') }}
								{{ Form::text('ddr_matricula', $ddr['ddr_matricula'], ['class' => 'form-control', 'id' => 'ddr_matricula']) }}
								<a href="http://site.sanepar.com.br/servicos/quer-pagar-sua-conta" target="_blank" style="margin:-27px -22px 0px 0px;float:right;">
									<img src="{{ asset('img/saneparApp.jpg') }}" width="20px">
								</a>
							</div>
							<div class="col-sm-8 formLabelInput2">
								<label for="ddrTitularConta">Titular da Conta <span style="color: #c70707;font-size: 11px;">(Nome Doador)</span></label>
								{{ Form::text('ddr_titular_conta', $ddr['ddr_titular_conta'], ['class' => 'form-control', 'id' => 'ddr_titular_conta']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-7 formLabelInput2">
								{{ Form::label('ddrEndereco', 'Endereço') }}
								{{ Form::text('ddr_endereco', $ddr['ddr_endereco'], ['class' => 'form-control', 'id' => 'ddr_endereco']) }}
							</div>
							<div class="col-sm-2 formLabelInput2">
								{{ Form::label('ddrNumero', 'Numero') }}
								{{ Form::text('ddr_numero', $ddr['ddr_numero'], ['class' => 'form-control', 'id' => 'ddr_numero']) }}
							</div>
							<div class="col-sm-3 formLabelInput2">
								{{ Form::label('ddrComplemento', 'Complemento') }}
								{{ Form::text('ddr_complemento', $ddr['ddr_complemento'], ['class' => 'form-control', 'id' => 'ddr_complemento']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCep', 'Cep') }}
								{{ Form::text('ddr_cep', $ddr['ddr_cep'], ['class' => 'form-control', 'id' => 'ddr_cep']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrBairro', 'Bairro') }}
								{{ Form::text('ddr_bairro', $ddr['ddr_bairro'], ['class' => 'form-control', 'id' => 'ddr_bairro']) }}
							</div>
							<div class="col-sm-4 formLabelInput2">
								{{ Form::label('ddrCidade', 'Cidade - Estado') }}
								{{ Form::text('ddr_cidade', $ddr['ddr_cidade'], ['class' => 'form-control', 'id' => 'ddr_cidade']) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 formLabelInput2">
								{{ Form::label('ddrNascimento', 'Data Nascimento') }}
								{{ Form::date('ddr_nascimento', $ddr['ddr_nascimento'], ['class' => 'form-control', 'id' => 'ddr_nascimento']) }}
							</div>
							<div class="col-sm-6">
								{{ Form::label('ddrCpf', 'CPF') }}
								{{ Form::text('ddr_cpf', $ddr['ddr_cpf'], ['class' => 'form-control', 'id' => 'ddr_cpf']) }}
							</div>
						</div>
					</div>
					<div class="table-responsive-sm">
						<table class="table table-bordered">
							<thead style="background-color: #f5f5f5;">
								<tr>
									<th>Telefone</th>
									<th>Obs.:</th>
									<th>Ações
										{{ Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-xs btn-success pull-right', 'id' => 'addFone', 'name' => 'addFone']) }}	
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($telefones as $tel)
									<tr>
										<td>{{ $tel->tel_numero }}</td>
										<td>{{ $tel->tel_obs }}</td>
										<td></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<hr />
					@include('layouts.botoes',['buttons' => ['btnEdit']])
					{{ Form::close() }}
				</div>
			</div>
		</div>
		
		<div class="col-md-6">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"> DOAÇÃO 
						<div class="pull-right">
							{!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-sm btn-success', 'id' => 'addDoacao', 'name' => 'addDoacao', 'data-toggle'=>'modal', 'data-target'=>'#modalCadDoacao']) !!}
						</div>
					</div>
					<div class="panel-body">
						@if(isset($doa))
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Data Ini.</th>
											<th>Valor Mês</th>
											<th>Qtde Parc.</th>
											<th>Valor</th>
											<th>Motivo</th>
											<th>Data Fim</th>
											<th style="text-align: center;">Ação</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($doa as $d)
											<tr>
												<td>{{ $d->doa_data }}</td>
												<td>{{ $d->doa_valor_mensal }}</td>
												<td>{{ $d->doa_qtde_parcela }}</td>
												<td>{{ $d->doa_valor }}</td>
												<td>{{ $d->smt_nome }}</td>
												<td>{{ $d->doa_data_final }}</td>
												<td style="text-align: center;">{{ Form::button('<span class="glyphicon glyphicon-remove"></span>', ['class'=>'btn btn-ss btn-danger', 'id' => 'deletedDoa', 'name' => 'deletedDoa', 'onclick' => 'deletedDoacao('.$d->doa_id.', '.$d->doa_ddr_id.')']) }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@else
							<div id="formDoadorDoador">
								{!! Form::open(['id' => 'formStoreDoadorDoacao']) !!}
									{{ Form::hidden('doa_ddr_id', $ddr['ddr_id'],['id'=>'doa_ddr_id']) }}
									<div class="row">
										<div class="col-sm-6 formLabelInput">
											{{ Form::label('doaData', 'Data doação:') }}
											{{ Form::date('doa_data', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'doa_data']) }}
										</div>
										<div class="col-sm-6 formLabelInput">
											{{ Form::label('doaValorMensal', 'Valor mensal:') }}
											{{ Form::text('doa_valor_mensal', '', ['class' => 'form-control', 'id' => 'doa_valor_mensal', 'data-mask-type' => 'money']) }}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 formLabelInput2">
											{{ Form::label('doaQtdeParcela', 'Quantidade de Parcelas:') }}
											{{ Form::number('doa_qtde_parcela', '', ['class' => 'form-control', 'id' => 'doa_qtde_parcela']) }}
										</div>
										<div class="col-sm-6 formLabelInput2">
											{{ Form::label('doaValor', 'Valor doação:') }}
											{{ Form::text('doa_valor', '', ['class' => 'form-control', 'id' => 'doa_valor', 'data-mask-type' => 'money']) }}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6 formLabelInput2">
											{{ Form::label('doaDataFinal', 'Data última parcela:') }}
											{{ Form::date('doa_data_final', '', ['class' => 'form-control', 'id' => 'doa_data_final']) }}
										</div>
										<div class="col-sm-6 formLabelInput2">
											{{ Form::label('doaMotivo', 'Motivo:') }}
											{{ Form::select('doa_smt_id', $mtdoa, '1', ['class' => 'form-control', 'id' => 'doa_smt_id', 'placeholder' => 'Selecione motivo...']) }}
										</div>
									</div>
									<div class="modal-footer">
										{!! Form::button('<span class="glyphicon glyphicon-ok"></span> Cadastrar', ['class'=>'btn btn-sm btn-success', 'id' => 'submitStoreDoacao', 'name' => 'submitStoreDoacao']) !!}
									</div>
								{{ Form::close() }}
							</div>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading"> CARTÃO + PRÓ-RENAL 
						<div class="pull-right">
							{!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-sm btn-success', 'id' => 'addDoacao', 'name' => 'addDoacao', 'data-toggle'=>'modal', 'data-target'=>'#modalCadDoacao']) !!}
						</div>
					</div>
					<div class="panel-body">

					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>
<!-- SCRIPT DOADOR  -->
@include('doador.modal_doacao')
@include('doador.modal_fone')
@include('doador.modal_deleted_doacao')

<script src="{{ asset('js/doador.js') }}"></script>
<script type='text/javascript'>
	$(document).ready(function() {
		$("#menu-top #doadorMenu").addClass('menu-top-active');
	});
</script>
@stop