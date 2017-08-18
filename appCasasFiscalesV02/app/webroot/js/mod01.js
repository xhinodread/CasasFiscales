var urlServer = 'http://'+$(location).attr('host')+'/demoCasasFiscales/';


function formatoNumero(x) {
	if(isNaN(x))return "";
	n= x.toString().split('.');
	return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".")+(n.length>1?","+n[1]:"");
}

function llamarDetallePago(idDetalle){
	var id = idDetalle; //ui.item.Expediente.id;
	$.ajax({
		url: urlServer+"/procesos/getData/"+id
		,dataType: "json"
		,beforeSend: function(xhr){  /*console.log('llamarDetallePago');*/ }
		,success: function(data){
			//console.log('success');
			//console.log(data);
			//console.log( (data.datos.length) );
			//console.log(data.datos[0].nroEx);
			//console.log(data.datos[1]);
			//console.log(data.Documentos_expediente.Documento.materia);
			//console.log( typeof(data.Documentos_expediente[0].Documento) );
			/*
			var trs=$("#tablaDetallePagos tr").length;
			console.log(trs);
			*/
			var linea = 0;
			$('#tablaDetallePagos tr').each(function() {
				//console.log( $(this) );
				if (linea > 0)
					$(this).remove();
				linea++;
			});
			
			var losDatos = data.datos;
			for(var i=0;i<(data.datos.length);i++){
				var nuevaFila="<tr>";
				// añadimos las columnas
				// var nombreIndice = arrayIndices[i];
				var object = losDatos[i];
				//console.log(object);
				for(property in object) {
					var valor = object[property];
					if(property == 'monto'){
						valor = '$ '+formatoNumero(valor)+'.-';
					}
					//nuevaFila+="<td>"+object[property]+"</td>";
					nuevaFila+="<td>"+valor+"</td>";
				}
				nuevaFila+="</tr>";
				$("#tablaDetallePagos").append(nuevaFila);
			}

		}
		,error: function(xhr,status,error){
			console.log('error: '+error);
			console.log(xhr);
			console.log(xhr.responseText);
		}
	});
}