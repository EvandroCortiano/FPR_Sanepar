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
    // primeiroDia = datenew.getFullYear() + '-' + ("0" + (datenew.getMonth()+1)).substr(-2) + '-' + "01";
    menosDoisMeses = datenew.getFullYear() + '-' + ("0" + (datenew.getMonth()-1)).substr(-2) + '-' + "01";
    $("#formFiltroDoaRepasse #dataIni").val(primeiroDia);
    $("#formFiltroProducao #dataIni").val(primeiroDia);
    $("#formFiltroCancelados #dataFim").val(primeiroDia);
    $("#formFiltroVencer #dataIni").val(menosDoisMeses);
    $("#formFiltroProducaoSanepar #dataIni").val(primeiroDia);

    //chama funcoes
    filterProduction();
    filterCancel();
    filterVencer();
    filterProducaoSanepar();
});

/************************/
/* Filtros daas doacoes */
/************************/
$("#formFiltroDoaRepasse #btnExcelDoaRepasse").click(function(){
    console.log('btnExcelDoaRepasse');
});
// Realiza pesquisa tela de repasse
$("#formFiltroDoaRepasse #btnFiltroDoaRepasse").click(function(){
    pesquisa = $("form#formFiltroDoaRepasse").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findFiltersRepasse',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        toastr.remove();
        toastr.success("Doações retornadas com sucesso!");
        $('#tableAllDoacao').DataTable({
            destroy: true,
            paging: true,
            searching: false,
            pageLength: 10,
            info: true,
            dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
            language: {
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: "Sistema não retornou nenhum doador!",
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
                { data: 'ddr_nometitular' },
                { data: 'ddr_matricula' },
                { data: 'ddr_cidade' },
                { data: 'doa_data' },
                { data: 'doa_data_final' },
                { data: 'doa_valor_mensal' }
            ]
        });
        $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        $("#tableAllDoacao_paginate").css("margin","-15px 0px 0px 0px");
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao pesquisar doações!");
    });
});

/**************************************************/
/* Filtros para a Producao Semanal dos operadores */
/**************************************************/
$("#formFiltroProducao #btnExcelProducao").click(function(){
    console.log('btnExcelProducao');
});
$("#formFiltroProducao #btnFiltroProducao").click(function(){
    filterProduction();
});
function filterProduction(){
    pesquisa = $("form#formFiltroProducao").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findFilterProducao',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        toastr.success("Produção retornada com Sucesso!");
        $('#tableProducao').DataTable({
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
                { data: 'name' },
                { data: 'ddr_nometitular' },
                { data: 'ddr_matricula' },
                { data: 'doa_data' },
                { data: 'doa_valor_mensal' },
                { data: 'doa_qtde_parcela' }
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar Produção!");
    });
}

/***************************/
/* Filtros para Cancelados */
/***************************/
$("#formFiltroCancelados #btnExcelCancelados").click(function(){
    console.log('btnExcelCancelados');
});
$("#formFiltroCancelados #btnFiltroCancelados").click(function(){
    filterCancel();
});
function filterCancel(){
    pesquisa = $("form#formFiltroCancelados").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findFilterCancelados',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        toastr.success("Cancelados retornado com Sucesso!");
        $('#tableCancelados').DataTable({
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
                { data: 'ddr_nometitular' },
                { data: 'deleted_at' },
                { data: 'info' },
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar Cancelados!");
    });
}

/****************************/
/* Filtros para os a vencer */
/****************************/
$("#formFiltroVencer #btnExcelVencer").click(function(){
    console.log('btnExcelVencer');
});
$("#formFiltroVencer #btnFiltroVencer").click(function(){
    filterVencer();
});
function filterVencer(){
    pesquisa = $("form#formFiltroVencer").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findFilterVencer',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        toastr.success("À vencer retornado com Sucesso!");
        $('#tableAVencer').DataTable({
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
                { data: 'ddr_nometitular' },
                { data: 'doa_data_final' },
                { data: 'doa_valor_mensal' },
                { data: 'doa_qtde_parcela' },
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar À vencer!");
    });
}

/********************************************/
/* Filtros para enviar repasse para Sanepar */
/********************************************/
$("#formFiltroProducaoSanepar #btnExcelRepasse").click(function(){
    console.log('btnExcelRepasse');
});
$("#formFiltroProducaoSanepar #btnDoacaoRepasse").click(function(){
    filterProducaoSanepar();
});
function filterProducaoSanepar(){
    pesquisa = $("form#formFiltroProducaoSanepar").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findRepasseSanepar',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        toastr.success("À vencer retornado com Sucesso!");
        $('#tableProducaoSanepar').DataTable({
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
                { data: 'ddr_id' },
                { data: 'ddr_matricula' },
                { data: 'ddr_nome' },
                { data: 'doa_valor_mensal' },
                { data: 'doa_qtde_parcela' },
                { data: 'smt_nome' },
                { data: 'doa_valor' },
            ]
        });
        // $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        // $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        // toastr.remove();
        toastr.error("Erro ao carregar À vencer!");
    });
}
