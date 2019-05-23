@extends('templete')

@section(`title`)
	Cadastro de Usuários
@stop

@section('content')
<style>
    .title-register-user{
        padding-bottom: 0px !important;
        margin-bottom: 0px !important;
        color: #337ab7 !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" style="padding:15px;">
            <div class="panel panel-default">
                <div class="panel-heading page-head-line title-register-user">Cadastrar Usuário
                    <a class="btn btn-sm btn-default pull-right" href="../../user/users/" data-toggle="tooltip" data-placement="top" data-title="Deletar">
                        <i class="fa fa-undo"></i> Voltar
                    </a>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/user/users/store">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Perfil</label>
                            <div class="col-md-6">
                                {{ Form::select('user_per_id', ["0"=>"Selecione","1"=>"Administrador","2"=>"Supervisor","3"=>"Operador"], ["class"=>"form-control","id"=>"user_per_id"]) }}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Senha</label>
                            
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
