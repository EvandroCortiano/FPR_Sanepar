/**
 * Script for Doador
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

$("#formStoreDoador #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){
        data = $("form#formStoreDoador").serialize();

        $.ajax({
            type: 'post',
            data: data,
            dataType: 'json',
            url: '../doador/store'
        }).done(function(data){
            if(data){
                toastr.success("Dados atualizado com sucesso!")
                window.location.replace("../../doador/edit/"+data.ddr_id);
            }
        }).fail(function(data){
            if(data.hasOwnProperty('responseText')){
                html = '';
                if(data.responseText){
                    var error = JSON.parse(data.responseText);
                    if(error){
                        $.each(error, function(i, obj){
                            html += "<h4>"+obj + "</h4>";
                        });
                    }
                }
                toastr.remove();
                toastr.error("<b>Falha ao cadastrar:</b><br/>" + html);
                return false;	
            }
        });
}});

// Atualizar os dados do doador
$("#formupdateDoador #btnModalEdit").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formupdateDoador").serialize();
        $.ajax({
            type: 'put',
            url: '../../doador/update',
            data: data,
            dataType: 'json',
        }).done(function(data){
            window.location.replace("../../doador/edit/"+data.ddr_id);
        }).fail(function(data){
            toastr.remove();
            if(data.responseText == 'Error2'){
                toastr.error("<h4>Matricula já existe para outro doador!</h4>");
            } else {
                toastr.error("Erro ao atualizar dados do Doador!");
            }
        });
       
    }
});

$(document).ajaxStart(function() {
    $(document.body).css({'cursor' : 'wait'});
}).ajaxStop(function() {
    $(document.body).css({'cursor' : 'default'});
});

// Carrega doadores
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
                return json;
            },
            "error": function ( settings, helpPage, message ){
                toastr.error("Erro ao receber Doadores."+message);
            }
        },
        "data" :   [],   
        "columns": [
            {data: 'ddr_id' },
            {data: 'ddr_nome' },
            {data: 'ddr_cep'},
            {data: 'ddr_cidade'},
            {data: 'ddr_telefone_principal'},
            {data: 'info' },
            {data: 'link' },
            ], 
    });
    $("#tableDoadores_wrapper").css("width","98%");
    $('.dataTables_filter [type="search"]').css({'width':'350px','display':'inline-block'});
    $('.dataTables_filter').css({'margin-bottom':'-10px'});
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

// cadastra novo telefone - carrega modal
$("#formupdateDoador #addFone").click(function(){
    ddrId = $("#formupdateDoador #ddr_id").val();
    $("#formStoreFone #tel_ddr_id").val(ddrId);
    $('#modalCadFone').modal('show');
});
$("#modalCadFone #formStoreFone #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formStoreFone").serialize();

        $.ajax({
            type: 'post',
            url: '../../doador/foneStore',
            data: data,
            dataType: 'json',
        }).done(function(data){
            window.location.replace("../../doador/edit/"+data.tel_ddr_id);
        }).fail(function(){
            toastr.remove();
            toastr.error("Erro ao cadastrar Contato com o Doador!");
        });
    }
});

//supender doacao
function deletedDoacao(doa_id, doa_ddr_id){
    $("#modalDeletedDoacao #formDeletedDoa #doa_id").val(doa_id);
    $("#modalDeletedDoacao #formDeletedDoa #doa_ddr_id").val(doa_ddr_id);
    $("#modalDeletedDoacao").modal("show");
}
$("#modalDeletedDoacao #formDeletedDoa #btnModalDestroy").confirmation({
    rootSelector: '[data-toggle=modalDestroy]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formDeletedDoa").serialize();

        just = $("#formDeletedDoa #doa_justifica_cancelamento").val();
        if(just != ''){
            $.ajax({
                type: 'put',
                url: '../../doador/destroyDoacao',
                data: data,
                dataType: 'json',
            }).done(function(data){
                window.location.replace("../../doador/edit/"+data.doa_ddr_id);
            }).fail(function(){
                toastr.remove();
                toastr.error("Erro ao suspender doação!");
            });
        } else {
            toastr.remove();
            toastr.error("<h4>Favor inserir uma justificativa para suspender a doação!</h4>");
        }
    }
});