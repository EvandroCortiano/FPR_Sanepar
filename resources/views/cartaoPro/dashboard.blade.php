@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container" style="min-height: 500px">
        <div class="row">
            
            <div class="col-md-12" style="margin-top:10px;padding:0px;">
                <div class="col-md-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-4">
                                        <b>Produção Cartão + Pró Renal</b>
                                    </div>
                                {{ Form::open(['id' => 'formProducaoCartao']) }}
                                    <div class="col-sm-3">
                                        {{-- <span style="font-size: 14px;">Data Inicio:</span> --}}
                                        {{ Form::date('dataIni', '', ['class' => 'form-control', 'id' => 'dataIni']) }}
                                    </div>
                                    <div class="col-sm-3">
                                        {{-- <span style="font-size: 14px;">Data Fim:</span> --}}
                                        {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnProducaoCartao', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelProducaoCartao', 'name' => 'btnModalBack']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableProducaoCartao" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Titular da Conta</th>
                                        <th>Doador</th>
                                        <th>Cidade</th>
                                        <th>Data Doação</th>
                                        <th>Data Nascimento</th>
                                        <th>Endereço</th>
                                        <th>Cep</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                
                {{-- Tabela com os ja enviados para producao do cartao --}}
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <div class="row">
                                    <div class="col-sm-4">
                                        <b>Já enviados para confecção do cartão + Pró Renal</b>
                                    </div>
                                {{ Form::open(['id' => 'formListCartao']) }}
                                    <div class="col-sm-4">
                                        <span class="pull-right" style="font-size: 14px;">Pesquisar pela Data de Envio:</span>
                                    </div>
                                    <div class="col-sm-2">
                                        {{ Form::select('car_data', $dateCar, '', ['class' => 'form-control', 'id' => 'car_data', 'placeholder' => 'Selecione data...']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-md btn-default pull-right', 'id' => 'btnListCartao', 'name' => 'btnModalBack']) }}
                                    </div>
                                    <div class="col-sm-1">
                                        {{ Form::button('<span class="fas fa-file-excel"></span>', ['class' => 'btn btn-md btn-success pull-right', 'id' => 'btnExcelListCartao', 'name' => 'btnModalBack']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tableListCartao" class="table table-striped" style="margin-bottom:0px;">
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
                   
            </div>
            
        </div>
        @include('cartaoPro.modal_confirma_cartao')
        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/cartaoPro.js') }}"></script>
        <script type='text/javascript'>
            $(document).ready(function() {
                $("#menu-top #cartaoMenu").addClass('menu-top-active');
            });
        </script>
    </div>
@stop