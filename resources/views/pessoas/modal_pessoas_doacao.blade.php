<div class="modal fade" id="modalPessoasDoacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cadastrar doação do Sr(a) <span class="doadorName text-primary"></span>!</h4>
            </div>
            {{ Form::open(['id' => 'formStoreDoacaoPessoas']) }}
                <div class="modal-body">
                    {{ Form::hidden('pes_id', '', ['id'=>'pes_id']) }}
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('doaData', 'Data doação:') }}
                            {{ Form::date('doa_data', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'doa_data']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('doaValorMensal', 'Valor mensal:') }}
                            {{ Form::text('doa_valor_mensal', '', ['class' => 'form-control', 'id' => 'doa_valor_mensal', 'data-mask-type' => 'money']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('doaQtdeParcela', 'Quantidade de Parcelas:') }}
                            {{ Form::number('doa_qtde_parcela', '', ['class' => 'form-control', 'id' => 'doa_qtde_parcela']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('doaValor', 'Valor doação:') }}
                            {{ Form::text('doa_valor', '', ['class' => 'form-control', 'id' => 'doa_valor', 'data-mask-type' => 'money']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {{ Form::label('doaDataFinal', 'Data última parcela:') }}
                            {{ Form::date('doa_data_final', '', ['class' => 'form-control', 'id' => 'doa_data_final']) }}
                        </div>
                        <div class="col-sm-6">
                            {{ Form::label('doaMotivo', 'Motivo:') }}
                            {{ Form::select('doa_smt_id', $mtdoa, null, ['class' => 'form-control', 'id' => 'doa_smt_id', 'placeholder' => 'Selecione motivo...']) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @include('layouts.botoes',['buttons' => ['btnStore', 'btnCancel']])
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>