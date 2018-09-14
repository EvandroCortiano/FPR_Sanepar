/**
 * Script for Doacao
 * by Evandro C Cortiano
 */

//Executar ao abrir a pagina
var primeiroDia = '';
$(document).ready(function(){
    //seta primeiro dia do mes no forme de filtro pesquisa
    var datenew = new Date();
    primeiroDia = datenew.getFullYear() + '-' + ("0" + datenew.getMonth()).substr(-2) + '-' + "01";
    $("#formProducaoCartao #dataIni").val(primeiroDia);

    //chama funcoes
    filterProductionCard();
});

/**************************************************/
/* Filtros para a Producao Semanal dos operadores */
/**************************************************/
$("#formProducaoCartao #btnProducaoCartao").click(function(){
    pesquisa = $("form#formFiltroProducao").serialize();

    $.ajax({
        type: 'get',
        url: '../../cartaoPro/downloadExcelProducao',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo da Produção gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo da Produção!");
    });
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
        toastr.success("Produção retornada com Sucesso!");
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
                zeroRecords:  "Sistema não retornou nenhum doador!",
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
                { data: 'ddr_nometitular' },
                { data: 'ddr_cidade' },
                { data: 'doa_data' },
                { data: 'ddr_nascimento' },
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