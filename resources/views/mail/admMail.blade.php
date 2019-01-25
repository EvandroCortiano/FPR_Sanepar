<html>
    <body>
        <h4>O doador {{ $doador->ddr_titular_conta}} solicitou o cancelamento da doação via Sanepar!</h4>
        <p>Segue dados:</p>
        <br>
        <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Doador</th>
                    <th scope="col">Titular da Conta</th>
                    <th scope="col">Matricula</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Data Doação</th>
                    <th scope="col">Valor Doação</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>{{ $doador->ddr_nome }}</th>
                    <td>{{ $doador->ddr_titular_conta }}</td>
                    <th>{{ $doador->ddr_matricula }}</th>
                    <td>{{ $doador->ddr_cpf }}</td>
                    <td>{{ $doacao->doa_data }}</td>
                    <td>{{ $doacao->doa_valor_mensal }}</td>
                  </tr>
                </tbody>
              </table>
    </body>
</html>