/**
 * Script for Doacao
 * by Evandro C Cortiano
 */
//Salvar Doacao
$("#modalCadDoacao #submitStoreDoacao").on('click', function(){
    data = $("form#formStoreDoacao").serialize();

    $.ajax({
        type: 'post',
        data: data,
        dataType: 'json',
        url: '../../doacao/store'
    }).done(function(data){
        if(data){
            toastr.success('Doação cadastrado com sucesso!');
            window.location.reload();
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
        } else {
            toastr.error("<b>Falha ao cadastrar:</b>");
            return false;
        }
    });
});
$("#formDoadorDoador #submitStoreDoacao").on('click', function(){
    data = $("form#formStoreDoadorDoacao").serialize();
console.log(data);
    $.ajax({
        type: 'post',
        data: data,
        dataType: 'json',
        url: '../../doacao/store'
    }).done(function(data){
        if(data){
            toastr.success('Doação cadastrado com sucesso!');
            window.location.reload();
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
        } else {
            toastr.error("<b>Falha ao cadastrar:</b>");
            return false;
        }
    });
});

//**     Modal      **//
//Atualiza valor mensal atraves do campo da parcela
$("#modalCadDoacao #doa_qtde_parcela").change(function(){
    var parcela = $("#formStoreDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoacao #doa_valor_mensal").val();
    var dt = $("#formStoreDoacao #doa_data").val();

    //se valor parcela vazio
    if(vlMensal == ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoacao #doa_valor_mensal").val(vlMensal);
    } else if (vlMensal != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
        });
        $("#formStoreDoacao #doa_valor").val(valorTotal);
    }  

    if(dt != ''){   
        date = moment(dt);
        date.add((parseInt(parcela)-1), 'month');
        dtfinal = date.format('YYYY-MM-DD');
        
        $("#formStoreDoacao #doa_data_final").val(dtfinal);

        // var data = new Date(dt);
        // data.setDate(data.getDate() + 1);
        // data.setMonth(data.getMonth() + parseInt(parcela)); 
        // data = data.getFullYear() + "-" + ("0" + data.getMonth()).substr(-2) 
        //                         + "-" + ("0" + data.getDate()).substr(-2);
        // $("#formStoreDoacao #doa_data_final").val(data);
    }
});

//Atualiza valor mensal atraves do campo da valor mensal
$("#modalCadDoacao #doa_valor_mensal").change(function(){
    var parcela = $("#formStoreDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoacao #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
        });
        $("#formStoreDoacao #doa_valor").val(valorTotal);
    }   
});

//Atualiza valor mensal atraves do campo da valor total
$("#modalCadDoacao #doa_valor").change(function(){
    var parcela = $("#formStoreDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoacao #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formDoacaoDoador #doa_valor_mensal").val(vlMensal);
    }   
});
// Fim modal

//**     Tela Edit      **//
//Atualiza valor mensal atraves do campo da parcela
$("#formDoadorDoador #doa_qtde_parcela").change(function(){
    var parcela = $("#formStoreDoadorDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoadorDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoadorDoacao #doa_valor_mensal").val();
    var dt = $("#formStoreDoadorDoacao #doa_data").val();

    //se valor parcela vazio
    if(vlMensal == ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoadorDoacao #doa_valor_mensal").val(vlMensal);
    } else if (vlMensal != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
        });
        $("#formStoreDoadorDoacao #doa_valor").val(valorTotal);
    }  

    if(dt != ''){   
        date = moment(dt);
        date.add((parseInt(parcela)-1), 'month');
        dtfinal = date.format('YYYY-MM-DD');
        
        $("#formStoreDoadorDoacao #doa_data_final").val(dtfinal);
        
        // var data = new Date(dt);
        // data.setDate(data.getDate() + 1);
        // data.setMonth(data.getMonth() + parseInt(parcela)); 
        // data = data.getFullYear() + "-" + ("0" + data.getMonth()).substr(-2) 
        //                         + "-" + ("0" + data.getDate()).substr(-2);
        // $("#formStoreDoadorDoacao #doa_data_final").val(data);
        
    }
});

//Atualiza valor mensal atraves do campo da valor mensal
$("#formDoadorDoador #doa_valor_mensal").change(function(){
    var parcela = $("#formStoreDoadorDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoadorDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoadorDoacao #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        valorTotal = parseFloat(vlMensal) * parseFloat(parcela);
        valorTotal = (valorTotal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 4
        });
        $("#formStoreDoadorDoacao #doa_valor").val(valorTotal);
    }   
});

//Atualiza valor mensal atraves do campo da valor total
$("#formDoadorDoador #doa_valor").change(function(){
    var parcela = $("#formStoreDoadorDoacao #doa_qtde_parcela").val();
    var valorTotal = $("#formStoreDoadorDoacao #doa_valor").val();
    var vlMensal = $("#formStoreDoadorDoacao #doa_valor_mensal").val();

    //se valor parcela vazio
    if(parcela != ''){
        vlMensal = parseFloat(valorTotal) / parseFloat(parcela);
        vlMensal = (vlMensal).toLocaleString("pt-BR", {
            // Ajustando casas decimais
            minimumFractionDigits: 2,  
            maximumFractionDigits: 2
          });
        $("#formStoreDoadorDoacao #doa_valor_mensal").val(vlMensal);
    }   
});
// Fim tela Edit