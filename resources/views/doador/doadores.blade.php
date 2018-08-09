@extends('templete')

@section(`title`)
	Doadores cadastrados no Sistema
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
                <table id="tableDoadores" class="table table-striped" style="width:98%;margin-bottom:0px;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Nome Doador</th>
                            <th>Matrícula</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                {{-- <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cód. FPR</th>
                            <th>Nome</th>
                            <th>Matrícula</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doadores as $ddrs)
                            <tr>
                                <td>{{ $ddrs->ddr_id }}</td>
                                <td>{{ $ddrs->ddr_nome }}</td>
                                <td>{{ $ddrs->ddr_matricula }}</td>
                                <td>{{ $ddrs->ddr_telefone_principal }}</td>
                                <td><a href="/doador/edit/{{ $ddrs->ddr_id }}"><span class="glyphicon glyphicon-edit"></span>Editar/Doação</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> --}}

            </div>
        </div>
    </div>

    {{-- {{ $doadores->links() }} --}}
    @include('doador.modal_contato')

    <!-- SCRIPT DOADOR  -->
    <script src="{{ asset('js/doador.js') }}"></script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $("#menu-top #doadorMenu").addClass('menu-top-active');
            tdListDadosVitais();
        });
    </script>
@stop