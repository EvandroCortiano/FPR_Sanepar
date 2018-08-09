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

function tdListDoadores(){
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
            {data: 'flag' },
            {data: 'ddr_nome' },
            {data: 'ddr_matricula'},
            {data: 'ddr_telefone_principal' },
            {data: 'link' },
            {data: 'info' },
            ], 
    });
    $("#tableDoadores_wrapper").css("width","98%");
    $('.dataTables_filter [type="search"]').css({'width':'350px','display':'inline-block'});
    $("#tableDoadores_paginate").css("margin","-10px 25px 0px 0px");
}

//Registrar contato para evitar contatos repetidos
function registrarContato(ddr_id){
    $.ajax({
        type: 'get',
        url: '../../doador/find/' + ddr_id,
        dataType: 'json',
    }).done(function(data){
        if(data){
            $("#modalContato .doadorName").html(data.ddr_nome);
            $("#modalContato #formStoreContato #ccs_ddr_id").val(data.ddr_id);
        } else {
            $("#modalContato .doadorName").html(' ');
            $("#modalContato #formStoreContato #ccs_ddr_id").val(0);
        }
    }).fail(function(){
        toastr.remove();
        toastr.error("Erro ao pesquisar doador!");
    });
    $('#modalContato').modal('show');
}

//Cadastrar Status do Contato
$("#modalContato #formStoreContato #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formStoreContato").serialize();

        $.ajax({
            type: 'post',
            url: '../../doador/contatoStore',
            data: data,
            dataType: 'json',
        }).done(function(data){
            console.log(data);
        }).fail(function(){
            toastr.remove();
            toastr.error("Erro ao cadastrar Contato com o Doador!");
        });
        console.log(data);
    }
});

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