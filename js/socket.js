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
          $('.opciones').hide();
          $('.espacios_nivel').hide();          

        } else {
          
          $(this).attr('btn-estado','ocultar');
          $('#edificio'+idEdi+' .icono_torre').css({
            'transform': 'rotate(180deg)'  
          }); 

          $('#edificio'+idEdi+' .niveles').slideDown();
          $('#edificio'+idEdi+' .niveles').css({
            'display': 'inline-block',
            'vertical-align': 'top'           
          });
          
        }
      }
          
    });
  }

   $('input').click(function(){
    if ( $(this).attr('data') == "niveles" ) {
      //Ocultar opciones y espacios_nivel
      $('.opciones').hide();
      $('.espacios_nivel').hide();
      $('#espacios'+$(this).attr('id-piso')).slideDown('slow');
      $('#opcion'+$(this).attr('id-piso')).show();
    }

    // $(this).attr('id-piso');
    if ( $(this).attr('data') == "opcion" ) {

      if ( $(this).attr('value') == "Todos" ) {
        alert('Todos');  
      }

      if ( $(this).attr('value') == "Disponibles" ) {
        alert('Disponibles');
      }

      if ( $(this).attr('value') == "Reservados" ) {
        alert('Reservados');
      }

      if ( $(this).attr('value') == "Ocupados" ) {
        alert('Ocupados');
      }

    }

   });
  // }
  

  $('th').click(function() {  

    $('.espacios').css({
      'border': '3px solid #00AB6B'
    });
    $('.espacios div.estado').text('DISPONIBLE');    
    $('.espacios div.estado').css({
      'background-color': '#00AB6B'
    });

    var clase=$(this).attr('class');
    var id = $(this).attr('value');
      
    $(this).css({
      'border': '3px solid #ff5500'
    });

    $('#'+id+' div.estado').text('RESERVADO');    
    $('#'+id+' div.estado').css({
      'background-color': '#FF5500'
    });

    $(this).attr('data-estado','RESERVADO');
    document.getElementById("espacioSeleccionado").value = id;

    // cambiar estado en la base de datos
    
    // alert(clase+" "+valor);
  });

  // Arreglo de th de un id
  // $('#espacios1 th')

});