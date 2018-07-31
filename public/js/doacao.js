/**
 * Script for Doacao
 * by Evandro C Cortiano
 */

$("#modalCadDoacao #submitStoreDoacao").on('click', function(){
    data = $("form#formStoreDoacao").serialize();

    $.ajax({
        type: 'post',
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

//Atualiza valor mensal atraves do campo da parcela
$("#formStoreDoacao #doa_qtde_parcela").change(function(){
    var parcela = $("#formStoreDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoacao #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != '' && valorTotal != '' && vlMensal == ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoacao #doa_valor_mensal").val(vlMensal);
    }

    //se valor total vazio
    if(parcela != '' && valorTotal == '' && vlMensal != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoacao #doa_valor").val(valorTotal);
    }
});
