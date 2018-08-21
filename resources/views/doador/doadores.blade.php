@extends('templete')

@section(`title`)
	Doadores cadastrados no Sistema
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pull-right"><a href="../../doador/cadastro">{!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-lg btn-success', 'style' => 'margin-top: -15px;padding: 7px 11px;']) !!}</a></h1>
                <h1 class="page-head-line titlePrimary">Doadores cadastrados no Sistema</h1>
            </div>
        </div> 
        <div class="row">
            <div class="table-responsive" style="padding-left:15px;">
                <table id="tableDoadores" class="table table-striped" style="margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th>Nome Doador</th>
                            <th>Cep</th>
                            <th>Cidade</th>
                            <th>Telefone</th>
                            <th>Informações Doação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('doador.modal_contato')

    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/doador.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $("#menu-top #doadorMenu").addClass('menu-top-active');
            tdListDoadores();
        });
    </script>
@stop