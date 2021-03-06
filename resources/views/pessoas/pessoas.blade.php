@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line" style="margin-bottom:20px;">Lista para contato!</h1>
                <div class="pull-right" style="margin-top: -70px;">
                    {{ Form::open(['id' => 'formNumberPessoasWhere']) }}
                        Lista de contato {{ Form::select('pes_campanha', $pes_campanha,'', ['class' => 'inputSelect']) }}
                        &nbsp;&nbsp;
                        Selecionar do {{ Form::number('numberInicial', 1, ["min" => "1", "id" => "numberInicial", "class" => "inputNumber"]) }} ao {{ Form::number('numberFinal', 50, ["max" => "99999", "id" => "numberFinal", "class" => "inputNumber"]) }}
                        {!! Form::button('<span class="glyphicon glyphicon-refresh"></span>', ['class'=>'btn btn-sm btn-primary', 'id' => 'wherePessoasDT', 'name' => 'wherePessoasDT']) !!}
                    {{ Form::close() }}
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="tablePessoas" class="table table-striped" style="width:98%;margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Nome Doador</th>
                            <th>Nome da Mãe</th>
                            <th>Data Nascimento</th>
                            <th>Endereço</th>
                            <th>Cidade</th>
                            <th>Telefone</th>
                            <th>Observações</th>
                            <th>Ações</th>
                            <th>Informações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('pessoas.modal_pessoas')
    @include('pessoas.modal_pessoas_doacao')
    @include('pessoas.modal_del_telefone')
    @include('pessoas.modal_doador_existente')

    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/pessoas.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $("#menu-top #pessoasMenu").addClass('menu-top-active');
            tdListPessoas();
        });
    </script>
@stop