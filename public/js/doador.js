/**
 * Script for Doador
 * by Evandro C Cortiano
 */

$("#formStoreDoador #submitStoreDoador").click(function(){
    data = $("form#formStoreDoador").serialize();

    $.ajax({
        type: 'post',
        data: data,
        dataType: 'json',
        url: '../doador/store'
    }).done(function(data){
        if(data){
            toastr.success('Doador ' + data.ddr_nome + ' cadastrado com sucesso!');
        }
    }).fail(function(data){
        if(data.hasOwnProperty('responseText')){
            html = '';
            if(data.responseText){
                var error = JSON.parse(data.responseText);
                if(error){
                    $.each(error, function(i, obj){
                        html += obj + "<br/>";
                    });
                }
            }
            toastr.remove();
            toastr.error("<b>Falha ao cadastrar:</b><br/>" + html);
            return false;	
        }
    });
});

function tdListDadosVitais(){
	//Datatable Modal List Ddv
    tableListDdv = $('#tableDoadores').DataTable({
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
            "url": '../../doador/show',
            "dataSrc": function(json) {
                return json.data;
            },
            "error": function ( settings, helpPage, message ){
                toastr.error("Erro ao receber Doadores."+message);
            }
        },
        "data" :   [],        
        "columns": [
            {data: 'ddr_id' },
            {data: 'ddr_nome' },
            {data: 'ddr_matricula'},
            {data: 'ddr_telefone_principal' },
            {data: 'link' },
            ], 
    });
    $("#tableDoadores_wrapper").css("width","98%");
    $('.dataTables_filter [type="search"]').css({'width':'350px','display':'inline-block'});
    $("#tableDoadores_paginate").css("margin","-10px 25px 0px 0px");
}

