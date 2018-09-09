@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container" style="min-height: 450px">
        <div class="row">
            
            <div class="col-md-12" style="margin-top:10px;padding:0px;">
                <div class="col-md-8">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-3">
                                        <b>Produção Semanal</b>
                                    </div>
                                {{ Form::open(['id' => 'formFiltroProducao']) }}
                                    <div class="col-sm-1">
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <span style="font-size: 14px;">Data Inicio:</span> --}}
                                        {{ Form::date('dataIni', '', ['class' => 'form-control', 'id' => 'dataIni']) }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <span style="font-size: 14px;">Data Fim:</span> --}}
                                        {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnFiltroProducao', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelProducao', 'name' => 'btnModalBack']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableProducao" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Nome Operador</th>
                                        <th>Doador</th>
                                        <th>Matricula</th>
                                        <th>Data</th>
                                        <th>Valor Mês</th>
                                        <th>Qtda Parc.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                   
            </div>
            
        </div>
        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/cartaoPro.js') }}"></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#menu-top #cartaoMenu").addClass('menu-top-active');
                tdListDoadores();
            });
        </script>
    </div>
@stop