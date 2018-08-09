@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pull-right"><a href="../../doador/cadastro">{!! Form::button('<span class="glyphicon glyphicon-plus"></span>', ['class'=>'btn btn-lg btn-success', 'style' => 'margin-top: -15px;padding: 7px 11px;']) !!}</a></h1>
                <h1 class="page-head-line">Doadores cadastrados no Sistema</h1>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="tablePessoas" class="table table-striped" style="width:98%;margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Nome Doador</th>
                            <th>Matrícula</th>
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

    {{-- {{ $doadores->links() }} --}}
    @include('doador.modal_contato')

    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/pessoas.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $("#menu-top #pessoasMenu").addClass('menu-top-active');
            tdListPessoas();
        });
    </script>
@stop