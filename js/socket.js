$(document).on("ready",function() {

  var id = '';

  verEdificio();
  
  function verEdificio(){
    
    $('div').click(function() { 
     
      //Confirmar click     
      if ( $(this).attr('data') == 'edificios' ) {

        idEdi = $(this).attr('id-edificio');        
        console.log('#btnVerEdificio'+idEdi+' '+$(this).attr('btn-estado'));
        
        if ( $(this).attr('btn-estado') == 'ocultar') {

          $(this).attr('btn-estado','mostrar');
          $('#edificio'+idEdi+' .icono_torre').css({
            'transform': 'rotate(360deg)'  
          }); 

          $('#edificio'+idEdi+' .niveles').slideUp();
                    

        } else {
          
          $(this).attr('btn-estado','ocultar');

          $('#edificio'+idEdi+' .icono_torre').css({
            'transform': 'rotate(180deg)'  
          }); 

          $('#info-niveles'+idEdi).slideDown();
          $('#edificio'+idEdi+' .niveles').slideDown();
          $('#edificio'+idEdi+' .niveles').css({
            'display': 'inline-block',
            'vertical-align': 'top'           
          });
          
        }

        $('.opciones').hide();
        $('.espacios_nivel').hide();
      }
          
    });
  }

   $('input').click(function() {

    if ( $(this).attr('data') == "niveles" ) {
      //Ocultar opciones y espacios_nivel
      $('.opciones').hide();
      $('.espacios_nivel').hide();
      $('#info-niveles'+$(this).attr('id-edificio')).slideUp();
      $('#opcion'+$(this).attr('id-piso')).slideDown();
      $('#espacios'+$(this).attr('id-piso')).slideDown();            
    }
   
    if ( $(this).attr('data') == "opcion" ) {

      var id = $(this).attr('id-piso');
      
      if ( $(this).attr('value') == "Todos" ) {
        // alert('Todos');
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          $(this).fadeIn('slow').show();
          
        });
      }

      if ( $(this).attr('value') == "Disponibles" ) {
        // alert('Disponibles');
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          if ( $(this).attr('data-estado') == 'DISPONIBLE' ) {
            console.log($(this).attr('id')+' DISPONIBLE');
            $(this).fadeIn('slow').show();
          }else{
            $(this).fadeOut('normal').hide();
          }
        });
      }

      if ( $(this).attr('value') == "Reservados" ) {
        // alert('Reservados');        
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          if ( $(this).attr('data-estado') == 'RESERVADO' ) {
            console.log($(this).attr('id')+' RESERVADO');
            $(this).fadeIn('slow').show();
          }else{
            $(this).fadeOut('normal').hide();
          }
        });
        
      }

      if ( $(this).attr('value') == "Ocupados" ) {
        // alert('Ocupados');
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          if ( $(this).attr('data-estado') == 'OCUPADO' ) {
            console.log($(this).attr('id')+' OCUPADO');
            $(this).fadeIn('slow').show();
          }else{
            $(this).fadeOut('normal').hide();
          }
        });
      }

      if ( $(this).attr('value') == "Volver" ) {
        // alert('Volver');
        $('#info-niveles'+$(this).attr('id-edificio')).slideDown();
        $('#opcion'+$(this).attr('id-piso')).slideUp();
        $('#espacios'+$(this).attr('id-piso')).slideUp();       
      }

    }

   });
   
  var idAnterior = '';
  $('th').click(function() {  

    switch ( $(this).attr('data-estado') ) {      

    case 'LIBRE':
      // alert('DISPONIBLE');
      // todos los espacios en disponible
      // $('.espacios').css({
      //   'border': '3px solid #00AB6B'
      // });
      // $('.espacios div.estado').text('LIBRE');
      // $('.espacios').attr('data-estado','LIBRE');
      // $('.espacios div.estado').css({
      //   'background-color': '#00AB6B'
      // });
      // cambiar el objeto a reservado
      // var clase=$(this).attr('class');
      id = $(this).attr('id');
                  
      // $('#'+id).css({
      //   'border': '3px solid #ff5500'
      // });
      // $('#'+id+' div.estado').text('RESERVADO');    
      // $('#'+id+' div.estado').css({
      //   'background-color': '#FF5500'
      // });
      // $(this).attr('data-estado','RESERVADO');
      document.getElementById("espacioSeleccionado").value = id;

      $.ajax({
        type: "POST",
        url: "reservar.php",
        // data: "nespacio="+nespacio+"&placa="+placa+"&nusuario="+nusuario+"&libresA="+libresA+"&ocupadosA="+ocupadosA+"&libresB="+libresB+"&ocupadosB="+ocupadosB+"&libresE="+libresE+"&ocupadosE="+ocupadosE+"&contas1="+contas1+"&contas2="+contas2+"&contap1="+contap1+"&contap2="+contap2+"&contap3="+contap3+"&contbp1="+contbp1+"&contbp2="+contbp2+"&contbp3="+contbp3+"&contbp4="+contbp4,
        data: { nespacio: id, idAnterior: idAnterior},
        dataType:"html",
        success: function(data) 
        {
          // alert(data);
          send(data);// array JSON
          // window.location="../tablero/";          
        },
        error:function(data){
          alert(data);
        }
      });
      // cambiar estado en la base de datos a resevado
      idAnterior = id;
      // $('#parqueo').hide();
      // $('#registrar').show();

      break;

    case 'RESERVADO':
      // alert('RESERVADO');      
      id = $(this).attr('id');      
      document.getElementById("espacioSeleccionado").value = id;
      break;

    case 'OCUPADO':
      // alert('OCUPADO');

      id = $(this).attr('id'); 
      // window.location="../liberar/";
      $.ajax({
        type: "GET",
        url: "../liberar/",
        // data: "nespacio="+nespacio+"&placa="+placa+"&nusuario="+nusuario+"&libresA="+libresA+"&ocupadosA="+ocupadosA+"&libresB="+libresB+"&ocupadosB="+ocupadosB+"&libresE="+libresE+"&ocupadosE="+ocupadosE+"&contas1="+contas1+"&contas2="+contas2+"&contap1="+contap1+"&contap2="+contap2+"&contap3="+contap3+"&contbp1="+contbp1+"&contbp2="+contbp2+"&contbp3="+contbp3+"&contbp4="+contbp4,
        data: { nespacio: id, actualizacion: '4'},
        dataType:"html",
        success: function(data) 
        {
          // alert(data);
          send(data);// array JSON
                    
        },
        error:function(data){
          alert(data);
        }
      });

            
      // cambiar estado en la base de datos a disponible
      break;    
    }
    // alert(clase+" "+valor);
  });

  $('#btnRegistarTicket').click(function (){
      // cambiar el objeto a reservado
      // id = $(this).attr('value');
            
      // $(this).css({
      //   'border': '3px solid #ff5500'
      // });
      // $('#espacio'+id+' div.estado').text('OCUPADO');    
      // $('#espacio'+id+' div.estado').css({
      //   'background-color': '#FF5500'
      // });
      // $(this).attr('data-estado','OCUPADO');
      // document.getElementById("espacioSeleccionado").value = $(this).attr('nombre');
      
  });

  $('#btnRegistrar').click( function(){
    // window.location.href = '../registrar/';
  });

  $('#btnCancelarRegistrar').click( function () {
    // body...
    $('#espacio'+id).css({
      'border': '3px solid #00AB6B'
    });
    $('#espacio'+id+' div.estado').text('DISPONIBLE');    
    $('#espacio'+id+' div.estado').css({
      'background-color': '#00AB6B'
    });
    $(this).attr('data-estado','DISPONIBLE');

    $('#parqueo').show();
    $('#registrar').hide();
  });
 
});