@extends('templete')

@section(`title`)
	Pessoas a serem contactadas!
@stop

@section('content')
    <div class="container">

        <div class="table-responsive-sm">
            <table class="table table-bordered">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th>Nome doador</th>
                        <th>Matricula</th>
                        <th>valor doação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($doa as $d)
                        <tr>
                            <td>{{ $d->doador['ddr_nome'] }}</td>
                            <td>{{ $d->doador['ddr_matricula'] }}</td>
                            <td>{{ $d->doa_valor_mensal }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@stop