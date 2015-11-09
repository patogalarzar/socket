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
        // console.log('Todos');
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          $(this).fadeIn('slow').show();
          
        });
      }

      if ( $(this).attr('value') == "Libres" ) {
        // console.log('Disponibles');
        $.each( $('#espacios'+id+' th') , function(){
          // console.log('th: '+$(this).attr('id'));
          if ( $(this).attr('data-estado') == 'LIBRE' ) {
            console.log($(this).attr('id')+' LIBRE');
            $(this).fadeIn('slow').show();
          }else{
            $(this).fadeOut('normal').hide();
          }
        });
      }

      if ( $(this).attr('value') == "Reservados" ) {
        // console.log('Reservados');        
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
        // console.log('Ocupados');
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
        // console.log('Volver');
        $('#info-niveles'+$(this).attr('id-edificio')).slideDown();
        $('#opcion'+$(this).attr('id-piso')).slideUp();
        $('#espacios'+$(this).attr('id-piso')).slideUp();       
      }

    }

   });
   
  var idAnterior = '';
  $('th').click(function() {  

    var id = $(this).attr('id');      
    document.getElementById("espacioSeleccionado").value = id;

    switch ( $(this).attr('data-estado') ) {      

    case 'LIBRE':    

      $.ajax({
        async:false,
        type: "POST",
        url: "reservar.php",        
        data: { nespacio: id, idAnterior: idAnterior},
        dataType:"html",
        success: function(data) 
        {
          // console.log(data);
          send(data);// array JSON
          // window.location="../tablero/";          
        },
        error:function(data){
          console.log(data);
        }
      });
      // cambiar estado en la base de datos a resevado
      idAnterior = id;   

      $('#registrar').show();
      $('#parqueo').hide();
           
      $.ajax({
        async:false,
        url : '../registrar/index2.php', 
        data : { nespacio: id }, 
        type : 'GET',
        success: function(data) { 
          $('#registrar').html(data);
        }
      });   
      
      $.ajax({
        async:false,        
        url: "../arreglo.php",        
        success: function(data) {
          // console.log(data);
          send(data);// array JSON          
        },
        error:function(data){
          // console.log(data);
        }
      });

      break;

    case 'RESERVADO':
      // console.log('RESERVADO'); 
      $('#registrar').show();
      $('#parqueo').hide();     
      $.ajax({
        async:false,
        url : '../registrar/index2.php', 
        data : { nespacio: id }, 
        type : 'GET',
        success: function(data) { 
          $('#registrar').html(data);
        }
      });             
      break;

    case 'OCUPADO':
      // console.log('OCUPADO');
     
      $('#liberar').show();
      $('#parqueo').hide();     
      $.ajax({
        async:false,
        url : '../liberar/index2.php', 
        data : { nespacio: id }, 
        type : 'GET',
        success: function(data) { 
          $('#liberar').html(data);
        }
      });
      
      break;    
    }
    // console.log(clase+" "+valor);
  });
 
});