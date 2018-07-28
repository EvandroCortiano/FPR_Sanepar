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
							<form>
								<div class="form-group">
									{{ Form::label('ddrNome', 'Nome do Doador') }}
									{{ Form::text('ddr_nome', '', ['class' => 'form-control', 'id' => 'ddr_nome']) }}
								</div>
								<div class="form-group">
									<label for="exampleInputPassword1">Password</label>
									<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" />
								</div>
		<div class="form-group">
		<label for="exampleInputFile">File input</label>
		<input type="file" id="exampleInputFile" />
		<p class="help-block">Example block-level help text here.</p>
		</div>
		<div class="checkbox">
		<label>
		<input type="checkbox" /> Check me out
		</label>
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
		<hr />
		<input type="text" class="form-control" placeholder="Text input" />
		<hr />
		<textarea class="form-control" rows="3" placeholder="Text Area"></textarea>
		<hr />
		<div class="checkbox">
		<label>
		<input type="checkbox" value="" />
		Option one is this and that&mdash;be sure to include why it's great
		</label>
		</div>
		<div class="checkbox disabled">
		<label>
		<input type="checkbox" value="" disabled />
		Option two is disabled
		</label>
		</div>

		<div class="radio">
		<label>
		<input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked />
		Option one is this and that&mdash;be sure to include why it's great
		</label>
		</div>
		<div class="radio">
		<label>
		<input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" />
		Option two can be something else and selecting it will deselect option one
		</label>
		</div>
		<div class="radio disabled">
		<label>
		<input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled />
		Option three is disabled
		</label>
		</div>
		</form>
		</div>
		</div>
		</div>
		<div class="col-md-6">
		<div class="panel panel-default">
		<div class="panel-heading">
		DOAÇÃO
		</div>
		<div class="panel-body">


		</div>
		</div>
		</div>
		</div>
		</div>
	</div>

@stop