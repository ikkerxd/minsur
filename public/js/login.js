$(document).ready(function(){
    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
    });  

  /*contact(true);

  function contact(valor){    
    $('#dni').prop( "disabled", valor );
    $('#register_name').prop( "disabled", valor );
    $('#register_email').prop( "disabled", valor );
    $('#register_password').prop( "disabled", valor );
    $('#password-confirm').prop( "disabled", valor );
    $('#phone').prop( "disabled", valor );
    $('#anexo').prop( "disabled", valor );
    $('#btn_register').prop( "disabled", valor );
  }

  function clear_all(){
    $('.rs').val("");
    $('#direction').val("");
    $('#dni').val("");
    $('#register_name').val("");
    $('#register_email').val("");
    $('#register_password').val("");
    $('#password-confirm').val("");
    $('#phone').val("");
    $('#anexo').val("");  
    $(".rpta_search").empty();    
  }*/

  $('#businessName').prop( "disabled", true );
  $('#address').prop( "disabled", true );
  $('#btn_add_company').prop('disabled',true);

  // validar 11 digitos como minimo.
  // $('#ruc').keyup(function() {    
  //   var rucL = $(this).val();
  //   if (rucL.length < 11) {
  //     $('#result_company').html('<label for="name" class="control-label text-danger">11 digitos minimo</label>');
  //   }else{
  //     $('#result_company').html("");
  //     $('#btn_add_company').prop('disabled',false);
  //     $('#businessName').prop( "disabled", false );
  //     $('#address').prop( "disabled", false );
  //   }
  // });

  // validar si existe la empresa  
  $('#ruc').focusout(function(){ 
    var ruc = $(this).val();
    if (ruc.length < 11) {
      $('#result_company').html('<label for="name" class="control-label text-danger">falta 11 digitos</label>');
      $('#businessName').prop('disabled',true);
      $('#address').prop('disabled',true);
      $('#btn_add_company').prop('disabled',true);

    }else{           
     if ($.trim(ruc) != "") {
      $.ajax({
        url: 'search_ruc',
        type: 'POST',
        dataType: 'json',        
        data: {
            /*'_token': $('input[name=_token]').val(),*/
            ruc : ruc
        },
        dataType: 'json',         
        beforeSend : function() {
          $("#result_company").html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Buscando...</span>')
        }      
      })
      .done(function(data) {        
        if (data != "") {                        
          $('#businessName').val(data[0].businessName);
          $('#address').val(data[0].address);             
          $('#btn_add_company').css('display','none');   
          $('#result_company').html('<label for="name" class="control-label text-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Encontrado</label>');
        }
        else{          
          $('#result_company').html('<label for="name" class="control-label text-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <strong>Registrar</strong></label>');          
          $('#businessName').prop( "disabled", false );
          $('#address').prop( "disabled", false );
          $('#businessName').val("");
          $('#address').val("");
          $('#btn_add_company').css('display','block');   
          $('#btn_add_company').prop('disabled',false);
        }
      })      
    } 
  }

  
});

  /*$('#btn_next').click(function(){
    $('#dni').prop( "disabled", false );
    $('#register_name').prop( "disabled", false );
    $('#register_email').prop( "disabled", false );
    $('#register_password').prop( "disabled", false );
    $('#password-confirm').prop( "disabled", false );
    $('#phone').prop( "disabled", false );
    $('#anexo').prop( "disabled", false );
    $('#btn_register').prop( "disabled", false );
  });


  $('#register_company').submit(function(){

    event.preventDefault();
    var ruc = $('#ruc').val();
    var rs  = $('#rs').val();
    var dir = $('#direction').val();

    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/register_company',
      type: 'POST',
      dataType: 'json',
      data: {ruc: ruc, businessName:rs, address:dir},
      beforeSend : function() {
          $("#load_register").html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Buscando...</span>')
        }  
    })
    .done(function() {
      $('.register_success').css('display','block');
      $('.rpta_search').html('<label class="control-label text-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Registrado</label>');
      $('#btn_register_company').hide();
      $('.btn_cancel_ruc').hide();
      $("#load_register").hide();
      contact(false);
    })
  });

  $('#form_register_contact').submit(function(){

    event.preventDefault();
    var dni = $('#dni').val();
    var user  = $('#register_name').val();
    var email = $('#register_email').val();
    var phone = $('#phone').val();
    var anexo = $('#anexo').val();
    var idcompany = $('#idcompany').val();

    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '/register',
      type: 'POST',
      dataType: 'json',
      data: {id_company: idcompany, dni: dni, name: user, email:email, phone:phone, anexo:anexo},
      beforeSend : function() {
          $("#load_register").html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Buscando...</span>')
        }  
    })
    .done(function() {
      console.log('success');
      $('.register_success').css('display','block');
      $('.rpta_search').html('<label class="control-label text-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Registrado</label>');
      $('#btn_register_company').hide();
      $('.btn_cancel_ruc').hide();
      $("#load_register").hide();
      contact(false);
    })
  });*/




});
