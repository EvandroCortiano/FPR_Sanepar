@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container" style="min-height: 450px">
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
                                        <th>Cep</th>
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