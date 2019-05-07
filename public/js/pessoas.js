/**
 * Script for Pessoas
 * by Evandro C Cortiano
 */
// Padrao do Toastr
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-full-width",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'wait'});
}).ajaxStop(function() {
    $(document.body).css({'cursor' : 'default'});
});

function tdListPessoas(){
    inicial = $("form#formNumberPessoasWhere #numberInicial").val();
    final = $("form#formNumberPessoasWhere #numberFinal").val();
    mailing = $("form#formNumberPessoasWhere [name=pes_campanha]").val();

	//Datatable Modal List Ddv
    tablePessoas = $('#tablePessoas').DataTable({
        "destroy": true,
        "paging": true,
        "searching": true,
        "pageLength": 25,
        "info": false,
        "dom": "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
        "language": {
            "infoEmpty": "Sistema não retornou nenhum doador!",
            "zeroRecords":  "Sistema não retornou nenhum doador!",
            "lengthMenu": "_MENU_",
            "searchPlaceholder": "Pesquisar...",
            "search": "<div style='float:left'>_INPUT_</div><i class='fa fa-search' style='float:left; margin-left:-25px; padding:8px'></i>",
            "paginate": {
                "previous":"Anterior",
                "next":"Próximo"
            }
        },
        "ajax": {      
            "type":'GET',
            "url": '../../pessoas/show',
            "data": {"inicial":inicial,"final":final,'mailing':mailing},
            "dataSrc": function(json) {
                return json;
            },
            "error": function ( settings, helpPage, message ){
                toastr.error("Erro ao receber Doadores."+message);
            }
        },
        "data" :   [],   
        "columns": [
            {data: 'flag',"width": "4%" },
            {data: 'pes_nome',"width": "15%" },
            {data: 'pes_mae',"width": "11%"},
            {data: 'pes_nascimento',"width": "8%"},
            {data: 'pes_endereco',"width": "10%"},
            {data: 'pes_cidade',"width": "8%"},
            {data: 'telefones',"width": "10%"},
            {data: 'pes_obs',"width": "11%"},
            {data: 'link',"width": "8%"},
            {data: 'info',"width": "12%" },
            ]
    });
    $("#tableDoadores_wrapper").css("width","98%");
    $('.dataTables_filter [type="search"]').css({'width':'350px','display':'inline-block'});
    $("#tableDoadores_paginate").css("margin","-10px 25px 0px 0px");
}

//Registrar contato para evitar contatos repetidos
function registrarContatoPessoas(pes_id){
    $.ajax({
        type: 'get',
        url: '../../pessoas/find/' + pes_id,
        dataType: 'json',
    }).done(function(data){
        if(data){
            $("#modalContatoPessoas .doadorName").html(data.pes_nome);
            $("#modalContatoPessoas #formStoreContatoPessoas #ccs_pes_id").val(data.pes_id);
        } else {
            $("#modalContatoPessoas .doadorName").html(' ');
            $("#modalContatoPessoas #formStoreContatoPessoas #ccs_pes_id").val(0);
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao pesquisar doador!");
    });
    $('#modalContatoPessoas').modal('show');
}

//Cadastrar Status do Contato (pessoas)
$("#modalContatoPessoas #formStoreContatoPessoas #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formStoreContatoPessoas").serialize();
        
        $.ajax({
            type: 'post',
            url: '../../pessoas/contatoStorePessoas',
            data: data,
            dataType: 'json',
        }).done(function(data){
            if(data){
                $("[data-dismiss=modal]").trigger({ type: "click" });
                toastr.remove();
                toastr.success("Contato adicionado com sucesso!")
                tablePessoas.ajax.url('../../pessoas/show').load();
            }
        }).fail(function(){
            toastr.remove();
            toastr.error("Erro ao cadastrar Contato!");
        });
    }
});

//Registrar doacao e cadastra doador
function cadastrarDoadorDoacao(pes_id){
    $.ajax({
        type: 'get',
        url: '../../pessoas/find/' + pes_id,
        dataType: 'json',
    }).done(function(data){
        if(data){
            $("#modalPessoasDoacao .doadorName").html(data.pes_nome);
            $("#modalPessoasDoacao #formStoreDoacaoPessoas #pes_id").val(data.pes_id);
        } else {
            $("#modalPessoasDoacao .doadorName").html(' ');
            $("#modalPessoasDoacao #formStoreDoacaoPessoas #ccs_pes_id").val(0);
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao pesquisar doador!");
    });
    $('#modalPessoasDoacao').modal('show');
}

//Cadastrar Doador e Doacao
$("#modalPessoasDoacao #formStoreDoacaoPessoas #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formStoreDoacaoPessoas").serialize();

        $.ajax({
            type: 'post',
            url: '../../pessoas/doacaoDoador',
            data: data,
            dataType: 'json',
        }).done(function(data){
            if(data.Error == "Novo"){
                toastr.success("Doação e Doador cadastrado com sucesso!");
                window.location.replace("../../doador/edit/"+data.ddr_id);
            } else if(data.Error == 'Existe') {
                toastr.warning("Doador já cadastrado na lista de doadores!");
                $('#doadorExisteEncaminhar').modal('show');
                $("#doadorExisteEncaminhar #formDoadorEncaminhar #doador_pes_id").val(data.ddr_pes_id);
                $("#doadorExisteEncaminhar #formDoadorEncaminhar #doador_id").val(data.ddr_id);
                $("#doadorExisteEncaminhar .nomeDoador").html(data.ddr_nome);
            }
        }).fail(function(data){
            toastr.remove();
            toastr.error("Erro ao cadastrar Doador e Doação!<br/>"+data.responseText);
        });
    }
});

//**     Modal  Valores    **//
//Atualiza valor mensal atraves do campo da parcela
$("#modalPessoasDoacao #doa_qtde_parcela").change(function(){
    var parcela = $("#formStoreDoacaoPessoas #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacaoPessoas #doa_valor").val();
    var vlMensal = $("#formStoreDoacaoPessoas #doa_valor_mensal").val();
    var dt = $("#formStoreDoacaoPessoas #doa_data").val();

    //se valor parcela vazio
    if(vlMensal == ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoacaoPessoas #doa_valor_mensal").val(vlMensal);
    } else if (vlMensal != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
        });
        $("#formStoreDoacaoPessoas #doa_valor").val(valorTotal);
    }  

    if(dt != ''){   
        date = moment(dt);
        date.add((parseInt(parcela)-1), 'month');
        dtfinal = date.format('YYYY-MM-DD');
        
        $("#formStoreDoacaoPessoas #doa_data_final").val(dtfinal);

        // var data = new Date(dt);
        // data.setDate(data.getDate() + 1);
        // data.setMonth(data.getMonth() + parseInt(parcela)); 
        // data = data.getFullYear() + "-" + ("0" + data.getMonth()).substr(-2) 
        //                         + "-" + ("0" + data.getDate()).substr(-2);
        // $("#formStoreDoacaoPessoas #doa_data_final").val(data);
    }
});

//Atualiza valor mensal atraves do campo da valor mensal
$("#modalPessoasDoacao #doa_valor_mensal").change(function(){
    var parcela = $("#formStoreDoacaoPessoas #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacaoPessoas #doa_valor").val();
    var vlMensal = $("#formStoreDoacaoPessoas #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
        });
        $("#formStoreDoacaoPessoas #doa_valor").val(valorTotal);
    }   
});

//Atualiza valor mensal atraves do campo da valor total
$("#modalPessoasDoacao #doa_valor").change(function(){
    var parcela = $("#formStoreDoacaoPessoas #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacaoPessoas #doa_valor").val();
    var vlMensal = $("#formStoreDoacaoPessoas #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formDoacaoDoador #doa_valor_mensal").val(vlMensal);
    }   
});
// Fim modal

//filtra lista de pessoas
$("#formNumberPessoasWhere #wherePessoasDT").click(function(){
    tdListPessoas();
});

//remove telefone
function retirarTelefonePessoas(pes_id, numero, pes_idNumero){
    $('#deleteTelefone').modal('show');
    $('#deleteTelefone .numberTel').html(numero);
    $('#deleteTelefone #formDeleteTelefone #pes_id').val(pes_id);
    $('#deleteTelefone #formDeleteTelefone #pes_idNumero').val(pes_idNumero);
}
$("#deleteTelefone #formDeleteTelefone #btnModalDeleted").click(function(){
    data = $("form#formDeleteTelefone").serialize();

    $.ajax({
        type: 'put',
        url: '../../pessoas/deleteTelefonePessoas',
        data: data,
        dataType: 'json',
    }).done(function(data){
        if(data){
            $("[data-dismiss=modal]").trigger({ type: "click" });
            toastr.remove();
            toastr.success("Numero do Telefone deletado com sucesso!")
            tablePessoas.ajax.url('../../pessoas/show').load();
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao excluir telefone!");
    });
});

// encaminha usuario para tela de edição do usuario
$("#doadorExisteEncaminhar #formDoadorEncaminhar #irCadastro").click(function(){
    ddrId = $("#doadorExisteEncaminhar #formDoadorEncaminhar #doador_id").val();
    window.location.replace("../../doador/edit/"+ddrId);
});  