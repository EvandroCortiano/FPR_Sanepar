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

/***********************/
/* Filtros das doacoes */
/***********************/
$("#formFiltroDoaRepasse #btnExcelDoaRepasse").click(function(){
    pesquisa = $("form#formFiltroDoaRepasse").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/downloadExcelFiltro',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo!");
    });
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
    pesquisa = $("form#formFiltroProducao").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/downloadExcelProducao',
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
    pesquisa = $("form#formFiltroCancelados").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/downloadExcelCancelados',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo com os Cancelados gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo de Cancelados!");
    });
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
    pesquisa = $("form#formFiltroVencer").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/downloadExcelVencer',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo com os vencimentos, gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo de Vencimentos!");
    });
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
    $('#modalConfirmaRepasse').modal('show');
});
$("#modalConfirmaRepasse #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        pesquisa = $("form#formFiltroProducaoSanepar").serialize();

        $.ajax({
            type: 'get',
            url: '../../repasse/downloadExcelRepasse',
            cache: false,
            data: pesquisa
        }).done(function(response){
            toastr.remove();
            toastr.success("Arquivo com o repasse a Sanepar, gerado com sucesso!");
            $("[data-dismiss=modal]").trigger({ type: "click" });
            window.location.href = response.full;
        }).fail(function(){
            toastr.remove();
            toastr.error("Erro ao gerar Arquivo de Repasse!");
        });
    }
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
        toastr.success("Repasse para Sanepar, retornado com Sucesso!");
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
        toastr.error("Erro ao carregar Repasse para Sanepar!");
    });
}

/********************************************/
/* Filtros para enviar repasse para Sanepar */
/********************************************/
$("#formListRepasse #btnExcelListRepasse").click(function(){
    pesquisa = $("form#formListRepasse").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/downloadExcelRepasseList',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo com o repasse a Sanepar, gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo de Repasse!");
    });
});
$("#formListRepasse #btnListRepasse").click(function(){
    filterProducaoSaneparListar();
});
function filterProducaoSaneparListar(){
    pesquisa = $("form#formListRepasse").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findRepasseSaneparList',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        if(data.status){
            toastr.remove();
            toastr.error(data.msg);
        } else {
            // toastr.remove();
            toastr.success("Repasse para Sanepar, retornado com Sucesso!");
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
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao carregar Repasse para Sanepar!");
    });
}