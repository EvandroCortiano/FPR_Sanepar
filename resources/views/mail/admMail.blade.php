<html>
    <body>
        <h4>O doador {{ $doador->ddr_titular_conta}} solicitou o cancelamento da doação via Sanepar!</h4>
        <p>Segue dados:</p>
        <p><b>Doador:</b> {{ $doador->ddr_nome }}</p>
        <p><b>Titular da Conta:</b> {{ $doador->ddr_titular_conta }}</p>
        <p><b>Matricula:</b> {{ $doador->ddr_matricula }}</p>
        <p><b>CPF:</b> {{ $doador->ddr_cpf }}</p>
        <p><b>Data Inicio Doação:</b> {{ $doacao->doa_data }}</p>
        <p><b>Data Final Doação:</b> {{ $doacao->doa_data_final }}</p>
        <p><b>Valor Doação:</b> {{ $doacao->doa_valor_mensal }}</p>
        <p><b>Justificativa do Cancelamento:</b> {{ $doacao->doa_justifica_cancelamento }}</p>
        <br><br><br><br>
        <address>
          <small>E-mail enviado pelo sistema FPR Sanepar!</small><br/>
          <small>Support and development by <a href="mailto:contato@evandrocortiano.com.br">Evandro C Cortiano</address></small>
          <small><a href="http://evandrocortiano.com.br/">http://evandrocortiano.com.br/</a></small>
        </address>
    </body>
</html>