/**
 * Script for Doacao
 * by Evandro C Cortiano
 */
$(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'wait'});
}).ajaxStop(function() {
    $(document.body).css({'cursor' : 'default'});
});

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
    filterProducaoSanepar();
});

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
            url: '../../sanepar/downloadExcelRepasse',
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
        url: '../../sanepar/findRepasseSanepar',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        // toastr.remove();
        // toastr.success("Repasse para Sanepar, retornado com Sucesso!");
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
        url: '../../sanepar/downloadExcelRepasseList',
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
        url: '../../sanepar/findRepasseSaneparList',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        if(data.status){
            toastr.remove();
            toastr.error(data.msg);
        } else {
            // toastr.remove();
            toastr.success("Repasse para Sanepar, retornado com Sucesso!");
            $('#tableListRepasse').DataTable({
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
                    { data: 'ddr_nome' },
                    { data: 'ddr_nascimento' },
                    { data: 'ddr_endereco' },
                    { data: 'ddr_cep' },
                    { data: 'ddr_cidade' }
                ]
            });
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao carregar Repasse para Sanepar!");
    });
}

/***********************************/
/********* Retorno Sanepar *********/
/***********************************/
//variavel controle
var dataSanepar = '';
$("#formImportExcel #btnImportExcel").click(function(){
    // capture o formulário
    var form = $('#formImportExcel')[0];
    // crie um FormData {Object}
    var data = new FormData(form);

    $.ajax({
        type: 'post',
        url: "/sanepar/importSanepar",
        enctype: 'multipart/form-data',
        headers: {
            'X-CSRF-Token': $('meta[name=_token]').attr('content')
        },
        data: data,
        processData: false, // impedir que o jQuery tranforma a "data" em querystring
        contentType: false, // desabilitar o cabeçalho "Content-Type"
        cache: false, // desabilitar o "cache"
        timeout: 600000, // definir um tempo limite (opcional)
        // manipular o sucesso da requisição
        success: function (data) {
            retornoSanepar(data);
            $('#modalConfirmaSanepar').modal('show');
        },
        // manipular erros da requisição
        error: function (e) {
            toastr.remove();
            toastr.error("Erro ao carregar Repasse da Sanepar! " + e);
        }
    });

    function retornoSanepar(data){
        //recebe valores
        dataSanepar = data;
        $('#tableRetornoSanepar').DataTable({
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
            data: data.sucesso,
            columns: [
                { data: 'rto_matricula' },
                { data: 'rto_nome' },
                { data: 'rto_vlr_servico' },
                { data: 'rto_logradouro' },
                { data: 'rto_cidade' },
                { data: 'rto_cep' },
            ]
        });
        $("#tableRetornoSanepar").css("width","100%");
        $('#tableRetornoSaneparError').DataTable({
            destroy: true,
            paging: true,
            searching: false,
            pageLength: 10,
            info: true,
            dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
            language: {
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: " ",
                zeroRecords:  "Não houve erro com as doações!",
                lengthMenu: "_MENU_",
                searchPlaceholder: "Pesquisar...",
                paginate: {
                    "previous":"Anterior",
                    "next":"Próximo"
                }
            },
            data: data.error,
            columns: [
                { data: 'rto_matricula' },
                { data: 'rto_nome' },
                { data: 'msg_erro' },
            ]
        });
        $("#tableRetornoSaneparError").css("width","100%");
    };
});
//salvar arquivo de erro
$("#formConfirmaSanepar #btnSalvarError").off('click').on('click', function(){
    var erro = dataSanepar['error'];
    //adiona _token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'post',
        url: '../../sanepar/storeReturnSaneparError',
        // cache: false,
        data: {
            'error' : erro
            }
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo com os erros na importação do repasse da Sanepar, criado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao criar Arquivo de Error Sanepar!");
    });
});

// Salva arquivo enviado pela sanepar
$("#modalConfirmaSanepar #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        //adiona _token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: '../../sanepar/storeReturnSanepar',
            cache: false,
            data: dataSanepar
        }).done(function(response){
            toastr.remove();
            toastr.success("Arquivo com o repasse da Sanepar, cadastrado com sucesso!");
            $("[data-dismiss=modal]").trigger({ type: "click" });
        }).fail(function(){
            console.log('Fail');
            toastr.remove();
            toastr.error("Erro ao salvar Arquivo da Sanepar!");
        });
    }
});
// btn controle Arquivo Sanepar salvo no BD
$("#formListRecebidos #btnExcelListRecebidos").click(function(){
    pesquisa = $("form#formListRecebidos").serialize();

    $.ajax({
        type: 'get',
        url: '../../sanepar/downloadExcelRecebidosList',
        cache: false,
        data: pesquisa
    }).done(function(response){
        toastr.remove();
        toastr.success("Arquivo recebido Sanepar, gerado com sucesso!");
        window.location.href = response.full;
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao gerar Arquivo recebido Sanepar!");
    });
});
$("#formListRecebidos #btnListRecebidos").click(function(){
    filterRecebidoSaneparListar();
});
function filterRecebidoSaneparListar(){
    pesquisa = $("form#formListRecebidos").serialize();

    $.ajax({
        type: 'get',
        url: '../../sanepar/findRecebidosSaneparList',
        data: pesquisa,
        dataType: 'json',
    }).done(function(data){
        if(data.status){
            toastr.remove();
            toastr.error(data.msg);
        } else {
            // toastr.remove();
            toastr.success("Repasse para Sanepar, retornado com Sucesso!");
            $('#tableListRecebidos').DataTable({
                destroy: true,
                paging: true,
                searching: false,
                pageLength: 10,
                info: true,
                dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
                language: {
                    info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    infoEmpty: " ",
                    zeroRecords:  "Sistema não retornou nenhum dados do Arquivo!",
                    lengthMenu: "_MENU_",
                    searchPlaceholder: "Pesquisar...",
                    paginate: {
                        "previous":"Anterior",
                        "next":"Próximo"
                    }
                },
                data: data,
                columns: [
                    { data: 'rto_nome' },
                    { data: 'rto_matricula' },
                    { data: 'rto_cidade' },
                    { data: 'rto_uf' },
                    { data: 'rto_cep' },
                    { data: 'rto_vlr_servico' }
                ]
            });
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao carregar Repasse para Sanepar!");
    });
}