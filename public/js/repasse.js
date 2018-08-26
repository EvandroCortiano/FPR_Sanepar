/**
 * Script for Doacao
 * by Evandro C Cortiano
 */
// Carrega tabela com todas as doacoes
tdListAllDoacao();
function tdListAllDoacao(){
	//Datatable Modal List Ddv
    tableListAllDoa = $('#tableAllDoacao').DataTable({
        "destroy": true,
        "paging": true,
        "searching": false,
        "pageLength": 10,
        "info": true,
        "dom": "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
        "language": {
            "infoEmpty": "Sistema não retornou nenhum doador!",
            "zeroRecords":  "Sistema não retornou nenhum doador!",
            "lengthMenu": "_MENU_",
            "searchPlaceholder": "Pesquisar...",
            // "search": "<div style='float:left'>_INPUT_</div><i class='fa fa-search' style='float:left; margin-left:-25px; padding:8px'></i>",
            "paginate": {
                "previous":"Anterior",
                "next":"Próximo"
            }
        },
        "ajax": {      
            "url": '../../repasse/findAllDoacao',
            "dataSrc": function(json) {
                return json;
            },
            "error": function ( settings, helpPage, message ){
                toastr.error("Erro ao receber Doadores."+message);
            }
        },
        "data" :   [],   
        "columns": [
            {data: 'doador.ddr_nome' },
            {data: 'doador.ddr_matricula'},
            {data: 'doa_valor_mensal'},
            ], 
    });
    $("#tableAllDoacao_wrapper").css("width","97%");
    // $('.dataTables_filter [type="search"]').css({'width':'350px','display':'inline-block'});
    // $('.dataTables_filter').css({'margin-bottom':'-10px'});
    $("#tableAllDoacao_paginate").css("margin","-25px 0px 0px 0px"); 
}