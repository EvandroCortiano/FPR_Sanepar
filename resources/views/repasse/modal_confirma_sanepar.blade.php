<div class="modal fade" id="modalConfirmaSanepar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Retorno Sanepar!</h4>
            </div>
            {{ Form::open(['id' => 'formConfirmaSanepar']) }}
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body" style="padding: 5px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-success" style="padding: 0px 10px;margin: 2px;">
                                Doações efetivadas com sucesso e encontradas no sistema! &nbsp;&nbsp;&nbsp;
                                Clique em 'Cadastrar' para salvar o arquivo no Sistema!
                            </div>
                            <table id="tableRetornoSanepar" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Matricula</th>
                                        <th>Nome Doador</th>
                                        <th>Valor Mensal</th>
                                        <th>Logradouro</th>
                                        <th>Cidade</th>
                                        <th>CEP</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-danger" style="padding: 0px 10px;margin: 2px;">
                                Doações não encontradas no sistema ou com erro!
                            </div>
                            <table id="tableRetornoSaneparError" class="table table-striped" style="margin-bottom:0px;">
                                <thead>
                                    <tr>
                                        <th>Matricula</th>
                                        <th>Nome Doador</th>
                                        <th>Msg. Erro</th>
                                    </tr>
                                </thead>
                            </table>
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