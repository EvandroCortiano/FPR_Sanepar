@extends('templete')

@section(`title`)
	Administração doações!
@stop
{{-- repasse = Administração --}}
@section('content')
    <div class="container" style="min-height: 350px">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line2 titlePrimary">Controle doações</h1>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-12" style="margin-top:10px;padding:0px;">
                {{-- Tabela com a producao das operadoras --}}
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-2">
                                        <b style="font-size:13pt">Produção Semanal</b>
                                    </div>
                                    <div class="col-sm-1">
                                    </div>
                                {{ Form::open(['id' => 'formFiltroProducao']) }}
                                    <div class="col-sm-2">
                                        <div class="row">
                                            <div class="col-sm-1" style="padding:0px">
                                                de
                                            </div>
                                            <div class="col-sm-11">
                                                {{-- <span style="font-size: 14px;">Data Inicio:</span> --}}
                                                {{ Form::date('dataIni', '', ['class' => 'form-control', 'id' => 'dataIni']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="row">
                                            <div class="col-sm-1" style="padding:0px">
                                                até
                                            </div>
                                            <div class="col-sm-11">
                                                {{-- <span style="font-size: 14px;">Data Inicio:</span> --}}
                                                {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="row">
                                            <div class="col-sm-3" style="padding:0px;">
                                                <span style="margin-left:15px;">Operador:</span>
                                            </div>
                                            <div class="col-sm-9">
                                                {{ Form::select('operador',$opera,'',['class'=>'form-control','placeholder'=>'Selecione']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div style="float:right; margin-left:20px">
                                            {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelProducao', 'name' => 'btnModalBack']) }}
                                        </div>
                                        <div style="float:right">
                                            {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnFiltroProducao', 'name' => 'btnModalBack']) }}
                                        </div>
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
                                        <th>Data</th>
                                        <th>Valor Mês</th>
                                        <th>Qtda Parc.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tabela com os cancelados no sistema --}}
                <div class="col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Cancelados</b>
                                </div>
                            {{ Form::open(['id' => 'formFiltroCancelados']) }}
                                <div class="col-sm-6" style="padding: 0px 10px;">
                                    {{-- <span style="font-size: 14px;">Data Fim:</span> --}}
                                    {{ Form::date('dataFim', '', ['class' => 'form-control', 'id' => 'dataFim']) }}
                                </div>
                                <div class="col-sm-3"  style="padding: 0px;">
                                    <div class="col-xs-6">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnFiltroCancelados', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-xs-6">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelCancelados', 'name' => 'btnModalBack']) }}
                                    </div>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableCancelados" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Nome Titular</th>
                                        <th>Data Cancelamento</th>
                                        <th>Info</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tabela com as doacoes a vencer --}}
                <div class="col-md-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>À Vencer</b>
                                </div>
                            {{ Form::open(['id' => 'formFiltroVencer']) }}
                                <div class="col-sm-6" style="padding: 0px 10px;">
                                    {{-- <span style="font-size: 14px;">Data Fim:</span> --}}
                                    {{ Form::hidden('dataIni', '', ['class' => 'form-control', 'id' => 'dataIni']) }}
                                    {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                </div>
                                <div class="col-sm-3"  style="padding: 0px;">
                                    <div class="col-xs-6">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnFiltroVencer', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-xs-6">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelVencer', 'name' => 'btnModalBack']) }}
                                    </div>
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableAVencer" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Nome Titular</th>
                                        <th>Data Final</th>
                                        <th>Valor Mês</th>
                                        <th>Qtda.</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tabela para filtrar resusltados --}}
                {{-- <div class="col-md-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding:6px;">
                            <div class="row">
                                {{ Form::open(['id' => 'formFiltroDoaRepasse']) }}
                                    <div class="col-sm-3">
                                        <span style="font-size: 14px;">Data Inicio:</span>
                                        {{ Form::date('dataIni', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataIni']) }}
                                    </div>
                                    <div class="col-sm-3">
                                        <span style="font-size: 14px;">Data Fim:</span>
                                        {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                    </div>
                                    <div class="col-sm-2">
                                        <span style="font-size: 14px;">Operador:</span>
                                        {{ Form::select('operador',$opera,'',['class'=>'form-control','placeholder'=>'Selecione']) }}
                                    </div>
                                    <div class="col-sm-2">
                                        <span style="font-size: 14px;">Status Doação:</span>
                                        {{ Form::select('statusDoa',['0'=>'Selecione','1'=>'Cancelado','2'=>'Vencido'],'',['class'=>'form-control']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-center', 'id' => 'btnFiltroDoaRepasse', 'name' => 'btnModalBack', 'style' => 'margin-top: 9px;']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="{{ URL::to('../../repasse/downloadExcel/xlsx') }}">
                                            {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-center', 'id' => 'btnExcelDoaRepasse', 'name' => 'btnModalBack', 'style' => 'margin-top: 9px;']) }}
                                        </a>
                                    </div>
                                    { { Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="tableAllDoacao" class="table table-striped" style="margin-bottom:0px;">
                                    <thead>
                                        <tr>
                                            <th>Cód.</th>
                                            <th>Matricula</th>
                                            <th>Nome Doador</th>
                                            <th>Valor Mensal</th>
                                            <th>Qtde. Parcelas</th>
                                            <th>Motivo</th>
                                            <th>Valor Total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>

        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/repasse.js') }}"></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#menu-top #adminMenu").addClass('menu-top-active');
            });
        </script>
    </div>
@stop