  $(window).on('load', function () {
    $(".loader-page").css({visibility:"hidden",opacity:"0"})
  });

  $(document).ready(function(){

    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
    });


    $('#alert').hide();
    $('.btn-delete').click(function(e) {
      e.preventDefault();
      if (!confirm("¿Estas seguro de eliminar?")) {
        return false;
      }

      var row = $(this).parents('tr');
      var form = $(this).parents('form');
      var url = form.attr('action');

      $('#alert').show();

      $.post(url, form.serialize(), function(result){
        row.fadeOut();
        $('#companies_total').html(result.total);
        $('#alert').html(result.message);
      }).fail(function(){
        $('#alert').html('Algo salio mal');
      })
    });

    $('[data-toggle="tooltip"]').tooltip()

    $('.select2').select2()



    /* INICIO SCONTRATA - LISTA DE INSCRIPCIONES CON FILTRO */
    var id_type_courses = $('.type_courses').val();
    var id_locations = $('.locations').val();

    if (id_type_courses != undefined && id_locations != undefined) {
      listar_inscripcion_contrata()  
    }

    $('.type_courses').change(function() {
      id_type_courses = $('.type_courses').val();      
      listar_inscripcion_contrata()
    });


    $('.locations').change(function() {
      id_locations = $('.locations').val();      
      listar_inscripcion_contrata()
    }); 



    function listar_inscripcion_contrata()
    {
      var opt = $('#opt').val();
      console.log(opt);
      console.log(id_locations);
      console.log(id_type_courses);
      var result = "";

      $.ajax({
        url: 'json_inscription',
        type: 'post',
        dataType: 'json',        
        data: {
          idLocation : id_locations,
          idTypeCourse : id_type_courses},
        // beforeSend: function(){
        //   $('.body').html('<br><p><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></p><br>');
        // },
        success: function (data) {
          // console.log('henrry');
          // console.log(data);
         html3= '<span>';
         $.each(data, function(index, value){
          if (opt == 0) {
            result = "<a href='userInscription/"+ value.id +"' class='btn btn-primary btn-sm'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Seleccionar</a>";
          }else{
            result = "<input type='radio' name='rbd_reschedule' id='rbd_reschedule' value="+ value.id +">";
          }

          html3 += '<tr>';
          html3 += "<td>"+
          value.nameLocation +"</td><td class='text-center'>"+
          value.modalidad +"</td><td class='text-center'>"+
          value.nameCourse + "</td><td class='text-center'>" +
          value.startDate +"</td><td class='text-center'>" +
          value.time +"</td><td class='text-center'>" +
          value.hours +" hr</td><td class='text-center'>" +
          value.slot +"</td><td class='text-center'> " +
          result +"</td>";
          html3 += '</tr>';
        });
         $('.body').html(html3);
       }
     });
    }
    /* FIN CONTRATA - LISTA DE INSCRIPCIONES CON FILTRO */

    $('#table_reschedule tbody').click(function(){
    //var valor = $("input[type='radio']:checked").val();
    $('.id_inscription').val($("input[type='radio']:checked").val());
  });

    $('.myModalLabel').click(function(){

    });

    $('.dni_user_details').focusout(function(){   
      var dni = $(this).val();      
      $.ajax({
        url: '/buscar_dni/'+dni,
        type: 'get',          
        success: function (data) {        
          if (!$.trim(data)){   
            $('.resultado_dni').html('<span style="color:red;font-weight:bold;">no encontrado</span>');          
          }
          else{   
            $('.apa').val(data.apellido_paterno);
            $('.ama').val(data.apellido_materno);
            $('.name').val(data.nombres);
            $('.resultado_dni').html('<span style="color:green;font-weight:bold;">encontrado</span>');
          }                   
        }
      });
    });

    function limpiar()
    {
      $('.dni').val("");
      $('.apa').val("");
      $('.ama').val("");
      $('.name').val("");
      $('.resultado_dni').html('');
    }

    $('#order_service').change(function() {
      id_orden_servicio = $('#order_service').val();      
      listar_orden_servicio()
    }); 



    function listar_orden_servicio()
    {  
      $.ajax({
        url: 'json_orden_servicio',
        type: 'post',
        dataType: 'json',        
        data: {id_orden_servicio : id_orden_servicio},
        beforeSend: function(){
          $('.tbody_os').html('<br><p><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></p><br>');
        },        
        success: function (data) {    
         html3= '<span>'; 
         $.each(data, function(index, value){
          html3 += '<tr>';                 
          html3 += "<td>"+ 
          value.dni +"</td><td class='text-center'>"+           
          value.firstLastName + "</td><td class='text-center'>" + 
          value.secondLastName +"</td><td class='text-center'>" + 
          value.name +"</td><td class='text-center'>" + 
          value.position +"</td><td class='text-center'>" + 
          value.condition +"</td>";
          html3 += '</tr>';           
        });        
         $('.tbody_os').html(html3);
       }
     });
    }



    $('.optradio').click(function() {
      var value = $('input[name=optradio]:checked').val(); 
      if (value == "Agente Interbank") {          
        $('#info_interbank').html('<i class="fa fa-external-link" aria-hidden="true"></i> Ir al tutorial Agente Interbank');
        $('#info_interbank').attr("href", "https://ighgroup.com/mmg/download_file/agente.pdf");
        $('#info_interbank').css('display','block');
        $('.bxi').css('display','none');
        $('#info_banca').css('display','none');
      }else if(value == "Banca por Internet"){
        $('#link_bcp').attr("href", "https://www.viabcp.com/");
        $('.bxi').css('display','block');
        $('#info_interbank').css('display','none');
        $('#info_banca').css('display','none');
        $('#bxi_per').attr("href", "https://ighgroup.com/mmg/download_file/banca_internet.pdf");
        $('#bxi_emp').attr("href", " https://empresas.netinterbank.com.pe/bpi-empresas/login");
      }else if(value == "Banca móvil"){     
        $('#info_banca').html('<i class="fa fa-external-link" aria-hidden="true"></i> Ir al tutorial Banca Móvil');     
        $('#info_banca').attr("href", "https://ighgroup.com/mmg/download_file/app_movil.pdf");
        $('#info_banca').css('display','block');
        $('#info_interbank').css('display','none');
        $('.bxi').css('display','none');         
      }else{
        $('.bxi').css('display','none');
        $('#info_banca').css('display','none');
        $('#info_interbank').css('display','none');
      }
    });


  // $('.chk_reschedule').on('change', function() {     
  //   if (this.checked) {        

  //   }else{
  //     console.log('no marcado');
  //   }

  // });

  /*$("#search_user_validate").submit(function( event ) {  

    event.preventDefault();
    var dni_ce = $('#dni_ce').val();

    $.ajax({
      url: '/json_search_participant',
      type: 'POST',
      dataType: 'json',
      data: {dni_ce: dni_ce},
    })
    .done(function(data) {
      console.log(data);
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });
    
  });*/

  $('#reschedule_start').submit(function(event) {
    event.preventDefault();

    Swal.fire({
      title: '¿Seguro que deseas reprogramar?',
      text: "si esta deacuerdo clic al boton azul",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Reprogramar!'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',    
          dataType: 'json',  
          data: $(this).serialize(),
        })
        .done(function(data) {
          Swal.fire(
            'Felicitaciones!',
            'Sus participantes han sido programados.',
            'success'
            )
          window.location.href = "detail-Inscription/"+data;
        });   
      }
    })
  });

  $('#cancel_start').submit(function(event) {
    event.preventDefault();    

    Swal.fire({
      title: '¿Estás seguro?',
      text: "¡No podrás revertir esto!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Anular!'
    }).then((result) => {    
      if (result.value) {
        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          dataType: 'json',
          data: $(this).serialize(),
        })
        .done(function(data) {  
          Swal.fire(
            'Eliminado!',
            'Su participante ha sido eliminado.',
            'success'          
            )
          if (data.state == 0) {
            window.location.href = "detail-Inscription/"+data.id;
          }else{
            window.location.href = "details";
          }
        });
      }
    })        
  });

  $('#form_register_inscriptions').click(function() {
    var radioValue = $("input[name='payment_condition']:checked").val();
    if(radioValue == 0)
    {
      $('.msg-1').html('Adjuntar voucher de pago');
      $('#code_transaction').prop('required',true);
      $('#code_transaction').prop('disabled',false);
    }else{
      $('.msg-1').html('Adjuntar carta de compromiso');
      $('#code_transaction').prop('required',false);
      $('#code_transaction').prop('disabled',true);
    }
  });

  $('#form_register_inscriptions').click(function() {
    var radioValue = $("input[name='rdbsubcontrata']:checked").val();
    if(radioValue == 1)
    {
      $('#data_subcontrata').css('display','block');
      $('#rdb_result').css('display','block');
    }else{
      $('#data_subcontrata').css('display','none');
      $('#rdb_result').css('display','none');
    }
  });

  Date.prototype.yyyymmdd = function() {
    var yyyy = this.getFullYear().toString();
  var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
  var dd  = this.getDate().toString();
  return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
};

function add_year(fech)
{
  var d = new Date(fech);
  var year = d.getFullYear();        
  var month = d.getMonth();
  var day = d.getDate();
  var fulldate = new Date(year + 1, month, day +1);
  return fulldate.toISOString().slice(0, 10);

}

$('#search_user_validate').submit(function(){
  event.preventDefault();
  var dni = $('#dni_ce').val(); 

  
  $.ajax({
    url: 'json_list_historico',
    type: 'POST',
    dataType: 'json',
    data: {dni: dni},
    beforeSend: function(){
      $('.tbody_his_dni').html('<br><p><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></p><br>');
    }, 
    success: function (data) {
      var pt = 0; 
      var dni = '';
      var participante = '';
      var empresa_old = '';
      var empresa = '';
      var condicion = '';
      var html3 = "";
      var val = "";
      var npar = 0;
      $.each(data, function(index, value){          

        var fechaOneYear = add_year(value.fecha);
        var date = new Date();
        if (value.id_curso == 13 && fechaOneYear > date.yyyymmdd() && value.nota >= 14)  {
          pt = pt+1;
        }else if(value.id_curso == 42 && fechaOneYear > date.yyyymmdd() && value.nota >= 14){
          pt = pt+1;       
        }else if(value.id_curso == 17 && fechaOneYear > date.yyyymmdd() && value.nota >= 14){
          pt = pt+1;
        }else if(value.id_curso == 18 && fechaOneYear > date.yyyymmdd() && value.nota >= 14){
          pt = pt+1;
        }else if(value.id_curso == 20 && fechaOneYear > date.yyyymmdd()  && value.asistencia == "A"){
          pt = pt+1;
        }else{
          pt = pt+0;
        }
        dni = value.dni;
        participante = value.participante;
        empresa = value.businessName;
      }); 
      if (pt > 2) {
        val = "<span style='font-size:12px' class='label label-primary'>PACK COMPLETO</span>";
      }else{
        val ="<span style='font-size:12px' class='label label-danger'>PACK INCOMPLETO</span>";
      }

      html3 += '<tr>';                 
      html3 += '<td>'+dni+'</td>'; 
      html3 += '<td>'+participante+'</td>'; 
      html3 += '<td>'+empresa+'</td>'; 
      html3 += '<td>'+val+'</td>'; 
      html3 += '<td><a class="btn btn-warning btn-sm" href="detail_history/'+dni+'"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></td>';
      html3 += '</tr>'; 
      if (participante != "") {
        $('.tbody_his_dni').html(html3);
      }else{
        $('.tbody_his_dni').html("No se ha encontrado al participante");
      }
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

});

$('#search_user_validate2').submit(function(){
  event.preventDefault();
  var dni = $('#dni_ce').val();  
  $.ajax({
    url: 'json_list_historico',
    type: 'POST',
    dataType: 'json',
    data: {dni: dni},
    beforeSend: function(){
      $('.tbody_his_dni_2').html('<br><p><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></p><br>');
    },  
    success: function (data) {
      var val = 0;
      var estado = "";
      html3= '<span>'; 
      $.each(data, function(index, value){
        if (value.id_curso == 10) {
          var fechaOneYear = add_year(value.fecha);
          var fecha1 = moment();
          var fecha2 = moment(fechaOneYear);
          if (fecha2.diff(fecha1, 'days') > 0) {
            estado = '<span class="label label-success">VIGENTE</span>';
          }else{
            estado = '<span class="label label-danger">CADUCADO</span>';
          }
          val = val +1 ;
          html3 += '<tr>';        
          html3 += '<td>'+value.fecha+'</td>';          
          html3 += '<td>'+value.dni+'</td>'; 
          html3 += '<td>'+value.participante+'</td>'; 
          html3 += '<td>'+value.nameCourses+'</td>'; 
          html3 += '<td>'+value.businessName+'</td>'; 
          html3 += '<td>'+fechaOneYear+'</td>';  
          html3 += '<td>'+fecha2.diff(fecha1, 'days')+' dias</td>';
          html3 += '<td>'+estado+'</td>';   
          html3 += '</tr>'; 
        }
        $('.tbody_his_dni_2').html(html3);
      });  

      if (val <= 0) {
        $('.tbody_his_dni_2').html("No se registra informacion");
      }
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

});

});
