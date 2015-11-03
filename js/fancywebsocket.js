var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;
	
	this.bind = function(event_name, callback)
	{
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;
	};
	
	this.send = function(event_name, event_data)
	{
		this.conn.send( event_data );
		return this;
	};
	
	this.connect = function() 
	{
		if ( typeof(MozWebSocket) == 'function' )
		this.conn = new MozWebSocket(url);
		else
		this.conn = new WebSocket(url);
		
		this.conn.onmessage = function(evt)
		{
			dispatch('message', evt.data);
		};
		
		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};
	
	this.disconnect = function()
	{
		this.conn.close();
	};
	
	var dispatch = function(event_name, message)
	{
		if(message == null || message == "")//aqui es donde se realiza toda la accion
			{
				// alert("mensaje nulo o vacio");
			}
			else
			{
				alert(message);
				var JSONdata    = JSON.parse(message); //parseo la informacion
				switch(JSONdata[0].actualizacion)//que tipo de actualizacion vamos a hacer(un nuevo mensaje, solicitud de amistad nueva, etc )
				{
					case '1':
					quitar_espacio(message);
					break;

					case '2':
					colocar_espacio(message);
					break;

					case '3':
					reservar(message);
					break;

					case '4':
					liberar(message);
					break;
					
				}
				//aqui se ejecuta toda la accion				
			}
	}
};

var Server;
function send( text ) 
{
    Server.send( 'message', text );
}
$(document).ready(function() 
{
	Server = new FancyWebSocket('ws://192.168.1.6:8080');
    Server.bind('open', function()
	{
    });
    Server.bind('close', function( data ) 
	{
    });
    Server.bind('message', function( payload ) 
	{
    });
    Server.connect();
});



function quitar_espacio(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var nespacio = JSONdata[0].nespacio;
				var placa = JSONdata[0].placa;
				var nusuario = JSONdata[0].nusuario;
				var edificio = JSONdata[0].edificio;
				var libresA = JSONdata[0].libresA;
				var ocupadosA = JSONdata[0].ocupadosA; 
				var libresB = JSONdata[0].libresB;
				var ocupadosB = JSONdata[0].ocupadosB;
				var libresE = JSONdata[0].libresE;
				var ocupadosE = JSONdata[0].ocupadosE;
				var actualizacion = JSONdata[0].actualizacion;
				var espacios = JSONdata[0].espacios;
				var contas1 = JSONdata[0].contas1;
				var contas2 = JSONdata[0].contas2;
				var contap1 = JSONdata[0].contap1;
				var contap2 = JSONdata[0].contap2;
				var contap3 = JSONdata[0].contap3;
				var contbp1 = JSONdata[0].contbp1;
				var contbp2 = JSONdata[0].contbp2;
				var contbp3 = JSONdata[0].contbp3;
				var contbp4 = JSONdata[0].contbp4;
				// alert(estado);
				// var contenidoDiv  = $("#"+tipo).html();
				// var mensajehtml   = fecha+' : '+mensaje;
				alert("Edificio: "+edificio);

				if (edificio=="1") {
					// alert("entro al 1");
					// alert(libresA);
					var nuevaEtiqueta = document.createElement("p");
					var nuevaEtiquetaO = document.createElement("p");
					var etiquetaAS1 = document.createElement("h3");
					var etiquetaAS2 = document.createElement("h3");
					var etiquetaAP1 = document.createElement("h3");
					var etiquetaAP2 = document.createElement("h3");
					var etiquetaAP3 = document.createElement("h3");
					var txt="";
					var texto = document.createTextNode(libresA);
					var textoO = document.createTextNode(ocupadosA);
					txt = "AS1: Libres = "+(80-contas1)+" / Ocupados = "+contas1;
					var textoAS1 = document.createTextNode(txt);
					txt="";
					txt="AS2: Libres = "+(80-contas2)+"/ Ocupados = "+contas2;
					var textoAS2 = document.createTextNode(txt);
					txt="";
					txt="AP1: Libres = "+(100-contap1)+"/ Ocupados = "+contap1;
					var textoAP1 = document.createTextNode(txt);
					txt="";
					txt="AP2: Libres = "+(100-contap2)+"/ Ocupados = "+contap2;
					var textoAP2 = document.createTextNode(txt);
					txt="";
					txt="AP3: Libres = "+(100-contap3)+"/ Ocupados = "+contap3;
					var textoAP3 = document.createTextNode(txt);

					nuevaEtiqueta.appendChild(texto);
					nuevaEtiquetaO.appendChild(textoO);
					etiquetaAS1.appendChild(textoAS1);
					etiquetaAS2.appendChild(textoAS2);
					etiquetaAP1.appendChild(textoAP1);
					etiquetaAP2.appendChild(textoAP2);
					etiquetaAP3.appendChild(textoAP3);

					nuevaEtiqueta.setAttribute('id','libresA');
					nuevaEtiquetaO.setAttribute('id','ocupadosA');
					nuevaEtiqueta.setAttribute('value',libresA);
					nuevaEtiquetaO.setAttribute('value',ocupadosA);

					var etiquetaAnterior = document.getElementById("libresA");
					var etiquetaAnteriorO = document.getElementById("ocupadosA");
					var etiquetaAnteriorAS1 = document.getElementById("AS1");
					var etiquetaAnteriorAS2 = document.getElementById("AS2");
					var etiquetaAnteriorAP1 = document.getElementById("AP1");
					var etiquetaAnteriorAP2 = document.getElementById("AP2");
					var etiquetaAnteriorAP3 = document.getElementById("AP3");

					etiquetaAnterior.setAttribute('value',libresA);
					etiquetaAnteriorO.setAttribute('value',ocupadosA);

					etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
					etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);

					// nombre_espacioA1

					var th = document.getElementById(nespacio);
					th.style.border = '3px solid #F00';
					var espacio = document.getElementById('nombre_espacio'+nespacio);
					console.log(espacio);
					espacio.setAttribute('data-estado','OCUPADO');
					espacio.innerHTML = 'OCUPADO';					
					espacio.style.background = '#F00';

					// etiquetaAnteriorAS1.parentNode.replaceChild(etiquetaAS1,etiquetaAnteriorAS1);
					// etiquetaAnteriorAS2.parentNode.replaceChild(etiquetaAS2,etiquetaAnteriorAS2);
					// etiquetaAnteriorAP1.parentNode.replaceChild(etiquetaAP1,etiquetaAnteriorAP1);
					// etiquetaAnteriorAP2.parentNode.replaceChild(etiquetaAP2,etiquetaAnteriorAP2);
					// etiquetaAnteriorAP3.parentNode.replaceChild(etiquetaAP3,etiquetaAnteriorAP3);
				} else{
					if (edificio=="2") {
						// alert("entro al 2");
						// alert(libresB);
						var nuevaEtiqueta = document.createElement("p");
						var nuevaEtiquetaO = document.createElement("p");

						var etiquetaBP1 = document.createElement("h3");
						var etiquetaBP2 = document.createElement("h3");
						var etiquetaBP3 = document.createElement("h3");
						var etiquetaBP4 = document.createElement("h3");
						
						var txt="";
						var texto = document.createTextNode(libresA);
						var textoO = document.createTextNode(ocupadosA);
						txt = "BP1: Libres = "+(100-contbp1)+" / Ocupados = "+contbp1;
						var textoBP1 = document.createTextNode(txt);
						txt="";
						txt="BP2: Libres = "+(120-contbp2)+"/ Ocupados = "+contbp2;
						var textoBP2 = document.createTextNode(txt);
						txt="";
						txt="BP3: Libres = "+(120-contbp3)+"/ Ocupados = "+contbp3;
						var textoBP3 = document.createTextNode(txt);
						txt="";
						txt="BP4: Libres = "+(120-contbp4)+"/ Ocupados = "+contbp4;
						var textoBP4 = document.createTextNode(txt);
						

						var texto = document.createTextNode(libresB);
						var textoO = document.createTextNode(ocupadosB);

						nuevaEtiqueta.appendChild(texto);
						nuevaEtiquetaO.appendChild(textoO);
						etiquetaBP1.appendChild(textoBP1);
						etiquetaBP2.appendChild(textoBP2);
						etiquetaBP3.appendChild(textoBP3);
						etiquetaBP4.appendChild(textoBP4);

						nuevaEtiqueta.setAttribute('id','libresB');
						nuevaEtiquetaO.setAttribute('id','ocupadosB');
						nuevaEtiqueta.setAttribute('value',libresB);
						nuevaEtiquetaO.setAttribute('value',ocupadosB);

						var etiquetaAnterior = document.getElementById("libresB");
						var etiquetaAnteriorO = document.getElementById("ocupadosB");
						var etiquetaAnteriorBP1 = document.getElementById("BP1");
						var etiquetaAnteriorBP2 = document.getElementById("BP2");
						var etiquetaAnteriorBP3 = document.getElementById("BP3");
						var etiquetaAnteriorBP4 = document.getElementById("BP4");

						etiquetaAnterior.setAttribute('value',libresB);
						etiquetaAnteriorO.setAttribute('value',ocupadosB);

						etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
						etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);
						etiquetaAnteriorBP1.parentNode.replaceChild(etiquetaBP1,etiquetaAnteriorBP1);
						etiquetaAnteriorBP2.parentNode.replaceChild(etiquetaBP2,etiquetaAnteriorBP2);
						etiquetaAnteriorBP3.parentNode.replaceChild(etiquetaBP3,etiquetaAnteriorBP3);
						etiquetaAnteriorBP4.parentNode.replaceChild(etiquetaBP4,etiquetaAnteriorBP4);

					} else{
						// alert("entro al 3");
						// alert(libresE);
						var nuevaEtiqueta = document.createElement("p");
						var nuevaEtiquetaO = document.createElement("p");
						var etiquetaE1 = document.createElement("h3");

						var txt="";
						txt = "E1: Libres = "+(80-ocupadosE)+" / Ocupados = "+ocupadosE;
						var textoE1 = document.createTextNode(txt);
						var texto = document.createTextNode(libresE);
						var textoO = document.createTextNode(ocupadosE);

						nuevaEtiqueta.appendChild(texto);
						nuevaEtiquetaO.appendChild(textoO);
						etiquetaE1.appendChild(textoE1);

						nuevaEtiqueta.setAttribute('id','libresE');
						nuevaEtiquetaO.setAttribute('id','ocupadosE');
						nuevaEtiqueta.setAttribute('value',libresE);
						nuevaEtiquetaO.setAttribute('value',ocupadosE);

						var etiquetaAnterior = document.getElementById("libresE");
						var etiquetaAnteriorO = document.getElementById("ocupadosE");
						var etiquetaAnteriorE1 = document.getElementById("E1");

						etiquetaAnterior.setAttribute('value',libresE);
						etiquetaAnteriorO.setAttribute('value',ocupadosE);

						etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
						etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);
						etiquetaAnteriorE1.parentNode.replaceChild(etiquetaE1,etiquetaAnteriorE1);

					}
				}
				var etiqueta = document.getElementById(nespacio);
				// etiqueta.setAttribute('data-estado','OCUPADO');
				// etiqueta.css({
    //     			'border': '3px solid #ff5500'
    //   			});
      			// var nEtiqueta = etiqueta.childNode.getElementById('estado');
      			// $('#'+id+' div.estado').text('RESERVADO');    
      			// $('#'+id+' div.estado').css({
        	// 		'background-color': '#FF5500'
      			// });
      			// $(this).attr('data-estado','RESERVADO');

				// etiqueta.parentNode.removeChild(etiqueta);
				// $("#"+tipo).html(contenidoDiv+mensajehtml);
}
function colocar_espacio(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var nespacio = JSONdata[0].nespacio;
				var placa = JSONdata[0].placa;
				var nusuario = JSONdata[0].nusuario;
				var edificio = JSONdata[0].edificio;
				var libresA = JSONdata[0].libresA;
				var ocupadosA = JSONdata[0].ocupadosA; 
				var libresB = JSONdata[0].libresB;
				var ocupadosB = JSONdata[0].ocupadosB;
				var libresE = JSONdata[0].libresE;
				var ocupadosE = JSONdata[0].ocupadosE;
				var actualizacion = JSONdata[0].actualizacion;
				var espacios = JSONdata[0].espacios;
				// alert(estado);
				// var contenidoDiv  = $("#"+tipo).html();
				// var mensajehtml   = fecha+' : '+mensaje;
				alert("Edificio: "+edificio);
				var idPadre=""; // id del padre al que se va a añadir el espacio liberado
				if (edificio=="1") {
					// alert("entro al 1");
					// alert(libresA);
					var nuevaEtiqueta = document.createElement("p");
					var nuevaEtiquetaO = document.createElement("p");
					var texto = document.createTextNode(libresA);
					var textoO = document.createTextNode(ocupadosA);
					nuevaEtiqueta.appendChild(texto);
					nuevaEtiquetaO.appendChild(textoO);
					nuevaEtiqueta.setAttribute('id','libresA');
					nuevaEtiquetaO.setAttribute('id','ocupadosA');
					nuevaEtiqueta.setAttribute('value',libresA);
					nuevaEtiquetaO.setAttribute('value',ocupadosA);
					var etiquetaAnterior = document.getElementById("libresA");
					var etiquetaAnteriorO = document.getElementById("ocupadosA");
					etiquetaAnterior.setAttribute('value',libresA);
					etiquetaAnteriorO.setAttribute('value',ocupadosA);
					etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
					etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);
					idPadre="espaciosVaciosA";
				} else{
					if (edificio=="2") {
						// alert("entro al 2");
						// alert(libresB);
						var nuevaEtiqueta = document.createElement("p");
						var nuevaEtiquetaO = document.createElement("p");
						var texto = document.createTextNode(libresB);
						var textoO = document.createTextNode(ocupadosB);
						nuevaEtiqueta.appendChild(texto);
						nuevaEtiquetaO.appendChild(textoO);
						nuevaEtiqueta.setAttribute('id','libresB');
						nuevaEtiquetaO.setAttribute('id','ocupadosB');
						nuevaEtiqueta.setAttribute('value',libresB);
						nuevaEtiquetaO.setAttribute('value',ocupadosB);
						var etiquetaAnterior = document.getElementById("libresB");
						var etiquetaAnteriorO = document.getElementById("ocupadosB");
						etiquetaAnterior.setAttribute('value',libresB);
						etiquetaAnteriorO.setAttribute('value',ocupadosB);
						etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
						etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);
						idPadre="espaciosVaciosB";
					} else{
						// alert("entro al 3");
						// alert(libresE);
						var nuevaEtiqueta = document.createElement("p");
						var nuevaEtiquetaO = document.createElement("p");
						var texto = document.createTextNode(libresE);
						var textoO = document.createTextNode(ocupadosE);
						nuevaEtiqueta.appendChild(texto);
						nuevaEtiquetaO.appendChild(textoO);
						nuevaEtiqueta.setAttribute('id','libresE');
						nuevaEtiquetaO.setAttribute('id','ocupadosE');
						nuevaEtiqueta.setAttribute('value',libresE);
						nuevaEtiquetaO.setAttribute('value',ocupadosE);
						var etiquetaAnterior = document.getElementById("libresE");
						var etiquetaAnteriorO = document.getElementById("ocupadosE");
						etiquetaAnterior.setAttribute('value',libresE);
						etiquetaAnteriorO.setAttribute('value',ocupadosE);
						etiquetaAnterior.parentNode.replaceChild(nuevaEtiqueta,etiquetaAnterior);
						etiquetaAnteriorO.parentNode.replaceChild(nuevaEtiquetaO,etiquetaAnteriorO);
						idPadre="espaciosVaciosE";
					}
				}
				// alert(estado);

				var contenidoTabla  = $("#"+idPadre).html();
				// alert(contenidoTabla);
				var espaciohtml   = "<th class='espacios' id='"+nespacio+"' value='"+nespacio+"'>"+nespacio+"</th>";
				$("#"+idPadre).html(contenidoTabla+espaciohtml);				
}

function reservar(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var nespacio = JSONdata[0].nespacio;				
				var idAnterior = JSONdata[0].idAnterior;
				var actualizacion = JSONdata[0].actualizacion;

				if ( idAnterior != '') {
					var thAnterior = document.getElementById(idAnterior);
					thAnterior.style.border = '3px solid #00AB6B';
					thAnterior.setAttribute('data-estado','LIBRE');
					var espacioAnterior = document.getElementById('nombre_espacio'+nespacio);
					console.log(espacioAnterior);				
					espacioAnterior.innerHTML = 'LIBRE';					
					espacioAnterior.style.background = '#00AB6B)';
				}
				
				var th = document.getElementById(nespacio);
				th.style.border = '3px solid rgb(255, 255, 0))';
				th.setAttribute('data-estado','RESERVADO');
				var espacio = document.getElementById('nombre_espacio'+nespacio);
				console.log(espacio);
				// espacio.setAttribute('data-estado','RESERVADO');
				espacio.innerHTML = 'RESERVADO';					
				espacio.style.background = 'rgb(255, 255, 0)';
}
