@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container" style="min-height: 450px">
        <div class="col-md-12">
            <div class="col-sm-10">
                <div class="row">
                    
                    <div class="table-responsive">
                        <table id="tableAllDoacao" class="table table-striped" style="margin-bottom:0px;">
                            <thead>
                                <tr>
                                    <th>Nome doador</th>
                                    <th>Matricula</th>
                                    <th>valor doação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <a href="{{ URL::to('../../repasse/downloadExcel/xlsx') }}"><button class="btn btn-success">Download Excel xlsx</button></a>
            </div>
        </div>

        <!-- SCRIPT DOACAO  -->
        <script src="{{ asset('js/repasse.js') }}"></script>
    </div>
@stop