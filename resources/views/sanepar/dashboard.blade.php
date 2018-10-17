@extends('templete')

@section(`title`)
	Controle Sanepar!
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line2 titlePrimary">Controle Sanepar</h1>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-12" style="margin-top:10px;padding:0px;">
                {{-- Tabela para doacao para a sanepar --}}
                <div class="col-md-8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-3">
                                    <b>Criar Produção Sanepar</b>
                                </div>
                            {{ Form::open(['id' => 'formFiltroProducaoSanepar']) }}
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="col-sm-1" style="padding:0px">
                                           <span class="pull-right">de</span>
                                        </div>                    
                                        <div class="col-sm-5">
                                            {{-- <span style="font-size: 14px;">Data Inicio:</span> --}}
                                            {{ Form::date('dataIni', '', ['class' => 'form-control', 'id' => 'dataIni']) }}
                                        </div>
                                        <div class="col-sm-1" style="padding:0px">
                                            <span class="pull-right">até</span>
                                        </div>                    
                                        <div class="col-sm-5">
                                            {{-- <span style="font-size: 14px;">Data Fim:</span> --}}
                                            {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default', 'id' => 'btnDoacaoRepasse', 'name' => 'btnModalBack']) }}
                                </div>
                                <div class="col-sm-1">
                                    {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success', 'id' => 'btnExcelRepasse', 'name' => 'btnModalBack']) }}
                                </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableProducaoSanepar" class="table table-striped" style="margin-bottom:0px;">
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
                
                {{-- importar retorno sanepar --}}
                <div class="col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-sm-12">
                                    <b>Receber arquivo de retorno Sanepar!</b>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                                {{ Form::open(['id' => 'formImportExcel', "enctype"=>"multipart/form-data"]) }}
                                    <meta name="_token" content="{{ csrf_token() }}" />
                                    <input type="file" name="import_file" id="import_file" /> <br/>
                                    <div style="text-align:center;">
                                        {{ Form::button('Importar Retorno Sanepar', ['class' => 'btn btn-md btn-success', 'id' => 'btnImportExcel', 'name' => 'btnImportExcel']) }}
                                    </div>
                                {{ Form::close() }}

                        </div>
                    </div>
                </div>

                {{-- Tabela com os ja enviados para sanepar --}}
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-4">
                                        <b>Já enviados para Sanepar</b>
                                    </div>
                                {{ Form::open(['id' => 'formListRepasse']) }}
                                    <div class="col-sm-3">
                                        <span class="pull-right" style="font-size: 14px;">Pesquisar pela Competência:</span>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::select('cpa_id', $selectComp, '', ['class' => 'form-control', 'id' => 'cpa_id', 'placeholder' => 'Selecione competência...']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnListRepasse', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelListRepasse', 'name' => 'btnModalBack']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableListRepasse" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Titular da Conta</th>
                                        <th>Doador</th>
                                        <th>Data Nascimento</th>
                                        <th>Endereço</th>
                                        <th>Cep</th>
                                        <th>Cidade</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                {{-- Tabela com os arquivos recebidos da sanepar --}}
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-4">
                                        <b>Recebidos da Sanepar</b>
                                    </div>
                                {{ Form::open(['id' => 'formListRecebidos']) }}
                                    <div class="col-sm-3">
                                        <span class="pull-right" style="font-size: 14px;">Pesquisar pela Referência:</span>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::select('rto_referencia_arr', $selectRef, '', ['class' => 'form-control', 'id' => 'rto_referencia_arr', 'placeholder' => 'Selecione referência...']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnListRecebidos', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelListRecebidos', 'name' => 'btnModalBack']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableListRecebidos" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Titular da Conta</th>
                                        <th>Matricula</th>
                                        <th>Cidade</th>
                                        <th>Estado</th>
                                        <th>CEP</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    
    
    @include('sanepar.modal_confirma_repasse')
    @include('sanepar.modal_confirma_sanepar')
        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/sanepar.js') }}"></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#menu-top #saneparMenu").addClass('menu-top-active');
            });
        </script>
    </div>
@stop