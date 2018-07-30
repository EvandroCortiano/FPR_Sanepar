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
