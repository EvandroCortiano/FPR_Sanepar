@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line" style="margin-bottom:20px;">Lista para contato!</h1>
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

    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/pessoas.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $("#menu-top #pessoasMenu").addClass('menu-top-active');
            tdListPessoas();
        });
    </script>
@stop