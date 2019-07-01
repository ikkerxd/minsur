$('#search_user_validate').submit(function(){
    event.preventDefault();
    var dni = $('#dni_ce').val();  
    $.ajax({
      url: 'json_list_historico',
      type: 'POST',
      dataType: 'json',
      data: {dni: dni},
      success: function (data) {
      $pt = 0; 
      $valr = '';  
      html3= '<span>';
       $.each(data, function(index, value){
        
        var d = new Date(value.fecha);
        var year = d.getFullYear();        
        var month = d.getMonth();
        var day = d.getDate();
        var fulldate = new Date(year + 1, month, day +1);
        var fechaConvert = fulldate.toISOString().slice(0, 10);

        
        var date = new Date();
        
        if (fechaConvert > date.yyyymmdd() ) {
          $valr ="<span class='label label-success'>VIGENTE</span>"          
        }else{
          $valr ="<span class='label label-danger'>CADUDADO</span>"          
        }

         html3 += '<tr>';                 
           html3 += "<td>"+ 
          value.fecha +"</td><td class='text-center'>"+           
          value.dni + "</td><td class='text-center'>" + 
          value.participante + "</td><td class='text-center'>" +          
          value.empresa +"</td><td class='text-center'>" + 
          value.curso +"</td><td class='text-center'>" +        
          value.nota +"</td><td class='text-center'>" +  
          $valr +"</td><td class='text-center'>" +          
          fechaConvert; +"</td>";          
          html3 += '</tr>';           
        });  
       $('.tbody_his_dni').html(html3);
     }
    })
    .done(function(data) {
      
        console.log("success");
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });