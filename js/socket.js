$(document).on("ready",function() {

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
   

  $('th').click(function() {  

    $('.espacios').css({
      'border': '3px solid #00AB6B'
    });
    $('.espacios div.estado').text('DISPONIBLE');
    $('.espacios').attr('data-estado','DISPONIBLE');
    $('.espacios div.estado').css({
      'background-color': '#00AB6B'
    });

    var clase=$(this).attr('class');
    var id = $(this).attr('value');
          
    $(this).css({
      'border': '3px solid #ff5500'
    });

    $('#espacio'+id+' div.estado').text('RESERVADO');    
    $('#espacio'+id+' div.estado').css({
      'background-color': '#FF5500'
    });

    $(this).attr('data-estado','RESERVADO');
    document.getElementById("espacioSeleccionado").value = $(this).attr('nombre');

    // cambiar estado en la base de datos
    
    // alert(clase+" "+valor);
  });

  
});