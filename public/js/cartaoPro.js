/**
 * Script for Doacao
 * by Evandro C Cortiano
 */

//Executar ao abrir a pagina
var primeiroDia = '';
$(document).ready(function(){
    //seta primeiro dia do mes no forme de filtro pesquisa
    var datenew = new Date();
    if(datenew.getDate() > 8){
        primeiroDia = datenew.getFullYear() + '-' + ("0" + (datenew.getMonth()+1)).substr(-2) + '-' + ("0" + (datenew.getDate()-7)).substr(-2);
    } else {
        primeiroDia = datenew.getFullYear() + '-' + ("0" + datenew.getMonth()).substr(-2) + '-' + "20";
    }
    console.log(primeiroDia);
    $("#formProducaoCartao #dataIni").val(primeiroDia);

    //chama funcoes
    filterProductionCard();
});

/**************************************************/
/* Filtros para a Producao Semanal dos operadores */
/**************************************************/
$("#formProducaoCartao #btnExcelProducaoCartao").click(function(){
    $('#modalConfirmaCartao').modal('show');
});
$("#modalConfirmaCartao #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        pesquisa = $("form#formProducaoCartao").serialize();

        $.ajax({
            type: 'get',
            url: '../../cartaoPro/downloadExcelProducao',
            cache: false,
            data: pesquisa
        }).done(function(response){
            toastr.remove();
            if(response){
                $("[data-dismiss=modal]").trigger({ type: "click" });
                toastr.success("Arquivo da Produção gerado com sucesso!");
                window.location.href = response.full;
            } else {
                toastr.error("Erro ao gerar Arquivo da Produção!");
            }
        }).fail(function(){
            toastr.remove();
            toastr.error("Erro ao gerar Arquivo da Produção!");
        });
    }
});
$("#formProducaoCartao #btnProducaoCartao").click(function(){
    filterProductionCard();
});
function filterProductionCard(){
    pesquisa = $("form#formProducaoCartao").serialize();

    $.ajax({
        type: 'get',
        url: '../../cartaoPro/findProducaoCartao',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        // toastr.success("Produção retornada com Sucesso!");
        $('#tableProducaoCartao').DataTable({
            destroy: true,
            paging: true,
            searching: false,
            pageLength: 10,
            info: true,
            dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
            language: {
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: " ",
                zeroRecords:  "<span style='color:red;font-size:13px'>Sistema não retornou nenhum doador. Possivelmente arquivo desse período já foi criado!</span>",
                lengthMenu: "_MENU_",
                searchPlaceholder: "Pesquisar...",
                paginate: {
                    "previous":"Anterior",
                    "next":"Próximo"
                }
            },
            data: data,
            columns: [
                { data: 'ddr_titular_conta' },
                { data: 'ddr_nome' },
                { data: 'ddr_cidade' },
                { data: 'doa_data' },
                { data: 'ddr_nascimento' },
                { data: 'endereco' },
                { data: 'ddr_cep' }
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar Produção Cartão!");
    });
}
/**************************************************/
/* Criar tabela dos já enviados para gerar cartao */
/**************************************************/
$("#formListCartao #btnExcelListCartao").click(function(){
    pesquisa = $("form#formListCartao").serialize();

    $.ajax({
        type: 'get',
        url: '../../cartaoPro/downloadExcelList',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        if(response){
            $("[data-dismiss=modal]").trigger({ type: "click" });
            toastr.success("Arquivo da Produção gerado com sucesso!");
            window.location.href = response.full;
        } else {
            toastr.error("Erro ao gerar Arquivo da Produção!");
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo da Produção!");
    });
});
$("#formListCartao #btnListCartao").click(function(){
    listProductionCard();
});
function listProductionCard(){
    pesquisa = $("form#formListCartao").serialize();

    $.ajax({
        type: 'get',
        url: '../../cartaoPro/findListCartao',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        toastr.success("Listagem retornada com Sucesso!");
        $('#tableListCartao').DataTable({
            destroy: true,
            paging: true,
            searching: false,
            pageLength: 10,
            info: true,
            dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
            language: {
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: " ",
                zeroRecords:  "Sistema não retornou nenhum resultado!",
                lengthMenu: "_MENU_",
                searchPlaceholder: "Pesquisar...",
                paginate: {
                    "previous":"Anterior",
                    "next":"Próximo"
                }
            },
            data: data,
            columns: [
                { data: 'ddr_titular_conta' },
                { data: 'ddr_nome' },
                { data: 'ddr_nascimento' },
                { data: 'endereco' },
                { data: 'ddr_cep' },
                { data: 'ddr_cidade' }
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar Produção Cartão já enviado!");
    });
}