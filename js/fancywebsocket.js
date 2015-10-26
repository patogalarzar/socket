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
				// alert(estado);
				// var contenidoDiv  = $("#"+tipo).html();
				// var mensajehtml   = fecha+' : '+mensaje;
				alert("Edificio: "+edificio);

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
					}
				}
				var etiqueta = document.getElementById(nespacio);

				etiqueta.parentNode.removeChild(etiqueta);
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
