/**
 * Script for Doacao
 * by Evandro C Cortiano
 */

$("#modalCadDoacao #submitStoreDoacao").on('click', function(){
    data = $("form#formStoreDoacao").serialize();

    $.ajax({
        type: 'get',
        data: data,
        dataType: 'json',
        url: '../../doacao/store'
    }).done(function(data){
        console.log(data);
        if(data){
            toastr.success('Doação cadastrado com sucesso!');
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

//Atualiza valor mensal
$("#formStoreDoacao #doa_qtde_parcela").change(function(){
    var parcela = $("#formStoreDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacao #doa_valor").val();

    if(parcela != '' && valorTotal != ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        $("#formStoreDoacao #doa_valor_mensal").val(vlMensal);
    }
});
