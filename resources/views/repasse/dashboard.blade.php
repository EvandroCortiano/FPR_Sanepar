@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container" style="min-height: 450px">
        <div class="row">
            <div class="col-md-12" style="margin-top:10px;">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="padding:6px;">
                        <div class="row">
                            <div class="col-sm-2">
                                <span style="font-size: 14px;">Data Inicio:</span>
                                {{ Form::date('dataIni', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataIni']) }}
                            </div>
                            <div class="col-sm-2">
                                <span style="font-size: 14px;">Data Fim:</span>
                                {{ Form::date('dataFim', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'dataFim']) }}
                            </div>
                            <div class="col-sm-2">
                                <span style="font-size: 14px;">Operador:</span>
                                {{ Form::select('operador',['0'=>'Selecione','1'=>'Cancelado','2'=>'Vencido'],'',['class'=>'form-control']) }}
                            </div>
                            <div class="col-sm-2">
                                <span style="font-size: 14px;">Status Doação:</span>
                                {{ Form::select('statusDoa',['0'=>'Selecione','1'=>'Cancelado','2'=>'Vencido'],'',['class'=>'form-control']) }}
                            </div>
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-2">
                                {{ Form::button('<span class="fa fa-search"></span>', ['class' => 'btn btn-lg btn-default pull-right', 'id' => 'btnModalBack', 'name' => 'btnModalBack', 'style' => 'margin-top: 9px;']) }}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="tableAllDoacao" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Nome doador</th>
                                        <th>Matricula</th>
                                        <th>valor doação</th>
                                    </tr>
                                </thead>
                            </table>
                            <a href="{{ URL::to('../../repasse/downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/repasse.js') }}"></script>
    </div>
@stop