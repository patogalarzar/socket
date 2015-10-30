$(document).on("ready",function() {

  
  // function verNivel(idObj){
    var bnd = 0;
    $('#btnEdificio1').click(function(){    
      if ( bnd == 0) {
        $('#Edificio1 .icono_torre').css({
          'transform': 'rotate(180deg)'  
        }); 

        $('#Edificio1 .niveles').slideDown();
        $('#Edificio1 .niveles').css({
          'display': 'inline-block',
          'vertical-align': 'top'
          // 'width': '20%'
        });
        

        bnd++;
      } else {
        $('#Edificio1 .icono_torre').css({
          'transform': 'rotate(360deg)'  
        }); 

        $('#Edificio1 .niveles').slideUp();
        bnd--;
      }    
    });


   $('#btnNivel1') .click(function(){
    // $(this).attr('id-piso');
    $('#espacios'+$(this).attr('id-piso')).slideDown('slow');
   });
  // }
  

  $('th').click(function(){      
   
    var clase=$(this).attr('class');
    var id = $(this).attr('id');
      
    $(this).css({
      'border': '3px solid #ff5500'
    });

    $('#'+id+' div.estado').text('RESERVADO');    
    $('#'+id+' div.estado').css({
      'background-color': '#FF5500'
    });

    document.getElementById("espacioSeleccionado").value = id;

    // cambiar estado en la base de datos
    
    // alert(clase+" "+valor);
  });

});