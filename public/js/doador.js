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
    "showDuration": "400",
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
            toastr.success("Dados atualizado com sucesso!")
            // window.location.replace("../../doador/edit/"+data.ddr_id);
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
        "ordering": false,
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
                toastr.error("<h4>Erro ao receber Doadores."+message+"<br/> Favor contactar o responsável pelo sistema!</h4>)");
            }
        },
        "data" :   [],   
        "columns": [
            {data: 'ddr_id',"width": "5%"},
            {data: 'ddr_nome',"width": "30%"},
            {data: 'ddr_matricula',"width": "8%"},
            {data: 'ddr_cep',"width": "8%"},
            {data: 'ddr_cidade',"width": "12%"},
            {data: 'ddr_telefone_principal',"width": "10%"},
            {data: 'info',"width": "18%"},
            {data: 'link',"width": "10%"},
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
            toastr.error("<h4>Erro ao cadastrar Contato com o Doador! <br/> Favor contactar o responsável pelo sistema!</h4>");
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
            toastr.error("<h4>Erro ao cadastrar Contato com o Doador! <br/> Favor contactar o responsável pelo sistema!</h4>");
        });
    }
});

// cadastra nome da pessoa que vai receber o cartao
$("#modalPesCartao #formStorePesCartao #btnModalStore").confirmation({
    rootSelector: '[data-toggle=modalStore]',
    container: 'body',
    onConfirm: function(){ 
        data = $("form#formStorePesCartao").serialize();
        ccp_dr_id = $("#modalPesCartao #formStorePesCartao #ccp_ddr_id").val();

        $.ajax({
            type: 'post',
            url: '../../doador/pesCartaoStore',
            data: data,
            dataType: 'json',
        }).done(function(data){
            toastr.remove();
            toastr.success("Nome adicionado com sucesso!");
            tdListNomesCartao();
            $("#modalPesCartao").modal("hide");
        }).fail(function(){
            toastr.remove();
            toastr.error("<h4>Erro ao cadastrar Nome! <br/> Favor contactar o responsável pelo sistema!</h4>");
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
                if(data.error){    
                    toastr.remove();
                    toastr.warning(data.msg);
                    setTimeout(function(){ 
                        window.location.replace("../../doador/edit/"+data.doa_ddr_id);
                    }, 4000)
                } else {
                    window.location.replace("../../doador/edit/"+data.doa_ddr_id);
                }
            }).fail(function(){
                toastr.remove();
                toastr.error("<h4>Erro ao suspender doação! <br/> Favor contactar o responsável pelo sistema!</h4>");
            });
        } else {
            toastr.remove();
            toastr.error("<h4>Favor inserir uma justificativa para suspender a doação!</h4>");
        }
    }
});

//Carrega nome para os cartoes mais pro renal
tabListNomesCar = '';
function tdListNomesCartao(){
    ccp_dr_id = $("#modalPesCartao #formStorePesCartao #ccp_ddr_id").val();

    $.ajax({
        type: 'get',
        url: '../../doador/listNomesCar/'+ccp_dr_id,
        dataType: 'json',
    }).done(function(data){
        tabListNomesCar = $('#tablePesCartao').DataTable({
            destroy: true,
            paging: true,
            searching: false,
            pageLength: 10,
            info: true,
            dom: "<'row'<'col-sm-12'<'pull-left'f><'pull-left'T>r<'clearfix'>>>t<'row'<'col-sm-12'<'pull-left'i><'pull-right'p><'clearfix'>>>",
            language: {
                info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                infoEmpty: " ",
                zeroRecords:  "Sistema não retornou nenhum Nome!",
                lengthMenu: "_MENU_",
                searchPlaceholder: "Pesquisar...",
                paginate: {
                    "previous":"Anterior",
                    "next":"Próximo"
                }
            },
            data: data,
            columns: [
                { data: 'ccp_nome',"width": "40%" },
                { data: 'ccp_obs',"width": "48%" },
                { data: 'acao',"width": "12%" }
            ]
        });
    }).fail(function(){
        toastr.remove();
        toastr.error("<h4>Erro ao carregar Nome(s) para cartão(ões)! <br/> Favor contactar o responsável pelo sistema!</h4>");
    });
}

//abre modal para cadastrar Nome Cartao
$("#addNomeCartao").click(function(){
    var ctrlDoacao = $("#ctrlDoacao").val();

    if(ctrlDoacao == 'yes'){
        $("#modalPesCartao").modal("show");
    } else {
        toastr.remove();
        toastr.error("<h4>Favor cadastrar a doação, após o cadastro inserir os nomes das pessoas que receberam o Cartão + Pró Renal!</h4>");
    }
});

//editar cartao
function editCcps(ccp_id){
    $.ajax({
        type: 'get',
        url: '../../doador/editCcps/',
        dataType: 'json',
    }).done(function(data){
        toastr.remove();
        toastr.success("Nome adicionado com sucesso!");
        tdListNomesCartao();
        $("#modalPesCartao").modal("hide");
    }).fail(function(){
        toastr.remove();
        toastr.error("<h4>Erro ao cadastrar Nome! <br/> Favor contactar o responsável pelo sistema!</h4>");
    });
}

//excluir cartao
function deletedCcps(ccp_id){
    console.log(ccp_id);
}