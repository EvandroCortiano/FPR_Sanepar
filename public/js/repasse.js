/**
 * Script for Doacao
 * by Evandro C Cortiano
 */

//Executar ao abrir a pagina
$(document).ready(function(){
    //seta primeiro dia do mes no forme de filtro pesquisa
    var date = new Date();
    primeiroDia = date.getFullYear() + '-' + ("0" + date.getMonth()).substr(-2) + '-' + "01";
    $("#formFiltroDoaRepasse #dataIni").val(primeiroDia);
});

// Realiza pesquisa tela de repasse
$("#formFiltroDoaRepasse #btnFiltroDoaRepasse").click(function(){
    pesquisa = $("form#formFiltroDoaRepasse").serialize();

    $.ajax({
        type: 'get',
        url: '../../repasse/findFiltersReapsse',
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
                { data: 'ddr_nome' },
                { data: 'ddr_matricula' },
                { data: 'doa_valor_mensal' }
            ]
        });
        $("#tableAllDoacao_wrapper").parent().css("overflow-x","hidden");
        $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px");
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao pesquisar doações!");
    });
});