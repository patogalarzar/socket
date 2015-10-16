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
	Server = new FancyWebSocket('ws://127.0.0.1:8080');
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
				var actualizacion = JSONdata[0].actualizacion;
				var espacios = JSONdata[0].espacios;
				// alert(estado);
				// var contenidoDiv  = $("#"+tipo).html();
				// var mensajehtml   = fecha+' : '+mensaje;
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
				var actualizacion = JSONdata[0].actualizacion;
				var espacios = JSONdata[0].espacios;
				// alert(estado);
				// var contenidoDiv  = $("#"+tipo).html();
				// var mensajehtml   = fecha+' : '+mensaje;
				var tabla = document.getElementById("espaciosVacios");
				// alert(espacios);
				// tabla.innerHTML = espacios;
				tabla.innerHTML = "<th class='espacios' id='"+nespacio+"' valor='"+nespacio+"'>"+nespacio+"</th>";
}
