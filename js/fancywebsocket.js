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
					case '1': // REGISTRAR ESPACIO
					registrar_espacio(message);					
					break;

					case '2': // LIBERAR ESPACIO
					liberar_espacio(message);
					break;

					case '3': // RESERVAR ESPACIO
					reservar(message);
					break;

					case '4': // CANCELAR REGISTRAR
					cancelar_r(message);
					break;

					case '5': // CANCELAR LIBERAR
					// liberar(message);
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



function registrar_espacio(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var nespacio = JSONdata[0].nespacio;
				var placa = JSONdata[0].placa;
				var nusuario = JSONdata[0].nusuario;
				var edificio = JSONdata[0].edificio;
				var piso = JSONdata[0].piso;				
				var actualizacion = JSONdata[0].actualizacion;
				
				var tag = document.getElementById('reservados'+piso);
				var reservados = tag.getAttribute('value');								
				var nr = 0 + reservados;
				nr--;
				console.log(nr);
				tag.setAttribute('value', nr);			
				tag.innerHTML = nr;

				var tag = document.getElementById('ocupados'+piso);
				var ocupados = tag.getAttribute('value');								
				var no = 0 + ocupados;
				no++;
				console.log(no);
				tag.setAttribute('value', no);			
				tag.innerHTML = no;

				cambiarEstado(message);
				alert("Edificio: "+edificio);
				
}

function liberar_espacio(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var nespacio = JSONdata[0].nespacio;
				var placa = JSONdata[0].placa;
				var nusuario = JSONdata[0].nusuario;
				var edificio = JSONdata[0].edificio;
				var piso = JSONdata[0].piso;				
				var actualizacion = JSONdata[0].actualizacion;
				var espacios = JSONdata[0].espacios;
				// alert(estado);

				var tag = document.getElementById('libres'+piso);
				var libres = tag.getAttribute('value');								
				var nl = 0 + libres;
				nl++;
				console.log(nl);
				tag.setAttribute('value', nl);			
				tag.innerHTML = nl;

				var tag = document.getElementById('ocupados'+piso);
				var ocupados = tag.getAttribute('value');								
				var no = 0 + ocupados;
				no--;
				console.log(no);
				tag.setAttribute('value', no);			
				tag.innerHTML = no;
				
				cambiarEstado(message);

				alert("Edificio: "+edificio);
				var idPadre=""; // id del padre al que se va a añadir el espacio liberado
				var contenidoTabla  = $("#"+idPadre).html();
				// alert(contenidoTabla);
				var espaciohtml   = "<th class='espacios' id='"+nespacio+"' value='"+nespacio+"'>"+nespacio+"</th>";
				$("#"+idPadre).html(contenidoTabla+espaciohtml);				
}

function reservar(message) {
	var JSONdata    = JSON.parse(message); //parseo la informacion
	var nespacio = JSONdata[0].nespacio;				
	var idAnterior = JSONdata[0].idAnterior;
	var actualizacion = JSONdata[0].actualizacion;
	var piso = JSONdata[0].piso;

	var tag = document.getElementById('reservados'+piso);
	var reservados = tag.getAttribute('value');								
	var nr = 0 + reservados;
	nr++;
	console.log(nr);
	tag.setAttribute('value', nr);			
	tag.innerHTML = nr;

	var tag = document.getElementById('libres'+piso);
	var libres = tag.getAttribute('value');								
	var nl = 0 + libres;
	nl--;
	console.log(nl);
	tag.setAttribute('value', nl);			
	tag.innerHTML = nl;

	if ( idAnterior != '') {
		var thAnterior = document.getElementById(idAnterior);
		thAnterior.style.border = '3px solid #00AB6B';
		thAnterior.setAttribute('data-estado','LIBRE');
		var espacioAnterior = document.getElementById('nombre_espacio'+nespacio);
		console.log(espacioAnterior);				
		espacioAnterior.innerHTML = 'LIBRE';					
		espacioAnterior.style.background = '#00AB6B';
	}
				
	var th = document.getElementById(nespacio);
	th.style.border = '3px solid #FF0';
	th.setAttribute('data-estado','RESERVADO');
	var espacio = document.getElementById('nombre_espacio'+nespacio);
	console.log(espacio);
	// espacio.setAttribute('data-estado','RESERVADO');
	espacio.innerHTML = 'RESERVADO';					
	espacio.style.color = '#FFF';
	espacio.style.background = '#FF0';
}

function cancelar_r(message){
	cambiarEstado(message);
}

function cambiarEstado(message) {
	var JSONdata = JSON.parse(message); //parseo la informacion
	var nespacio = JSONdata[0].nespacio;				
			
	switch(JSONdata[0].estado){
		case 'LIBRE':
			var th = document.getElementById(nespacio);
			th.style.border = '3px solid #FF0';
			th.setAttribute('data-estado','RESERVADO');
			var espacio = document.getElementById('nombre_espacio'+nespacio);						
			espacio.innerHTML = 'RESERVADO';			
			espacio.style.background = '#FF0';
			console.log(th);
			break;

		case 'RESERVADO':
			var th = document.getElementById(nespacio);
			th.style.border = '3px solid #F00';
			th.setAttribute('data-estado','OCUPADO');
			var espacio = document.getElementById('nombre_espacio'+nespacio);						
			espacio.innerHTML = 'OCUPADO';			
			espacio.style.background = '#F00';
			console.log(th);
			break;

		case 'OCUPADO':
			var th = document.getElementById(nespacio);
			th.style.border = '3px solid #00AB6B';
			th.setAttribute('data-estado','LIBRE');
			var espacio = document.getElementById('nombre_espacio'+nespacio);						
			espacio.innerHTML = 'LIBRE';			
			espacio.style.background = '#00AB6B';
			console.log(th);
			break;
	}

}