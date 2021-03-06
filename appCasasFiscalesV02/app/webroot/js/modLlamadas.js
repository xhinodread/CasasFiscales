var urlServer = 'http://'+$(location).attr('host')+'/appCasasFiscalesV02';


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

function llamarHistorialMantencion(bsv_id){
	var id = bsv_id; //ui.item.Expediente.id;
	$.ajax({
		url: urlServer+"/mantenciones/getHistorial/"+id
		,dataType: "json"
		,beforeSend: function(xhr){ }
		,success: function(data){
			
			var linea = 0;
			$('#tablaMantenciones tr').each(function() {
				if (linea > 0)
					$(this).remove();
				linea++;
			});
			
			var nuevaFila="<tr><td colspan='4'>Sin Resultados</td></tr>";
			var losDatos = data.Mantencione;
			if( losDatos ){
				for(var i=0;i<(losDatos.length);i++){
					nuevaFila="<tr>";
					// añadimos las columnas
					var object = losDatos[i];
					for(property in object) {
						var valor = object[property]; //+', '+property;
						
						var linkDoc = '', urlDoc='';
						if(property == 'documento'){
							urlDoc=valor;
							linkDoc = '<a href="/appCasasFiscalesV02/viviendas/../'+urlDoc+'" target="_blank" class="btn btn-info">Informe de Mantención</a>';
							//valor += linkDoc;
							valor = linkDoc;
						}
						
						////nuevaFila+="<td>"+object[property]+"</td>";
						nuevaFila+="<td>"+valor+"</td>";
					}
					nuevaFila+="</tr>";
					$("#tablaMantenciones").append(nuevaFila);
				}
			}else{
				//var nuevaFila="<tr><td colspan='4'>Sin Resultados</td></tr>";
				$("#tablaMantenciones").append(nuevaFila);
			}
		}
		,error: function(xhr,status,error){
			console.log('error 1: '+error);
			console.log('error 2: '+xhr);
			console.log('error 3: '+xhr.responseText);
		}
	});
}

function llamarHistorialAsignacion(vivienda_id, beneficiario_id){
	var id = vivienda_id; //ui.item.Expediente.id;
	$.ajax({
		url: urlServer+"/Bsvs/getArriendo/"+id
		,dataType: "json"
		,beforeSend: function(xhr){ }
		,success: function(data){
			var linea = 0;
			$('#tablaAsignaciones tr').each(function() {
				if (linea > 0)
					$(this).remove();
				linea++;
			});
			var nuevaFila="<tr><td colspan='6'>Sin Resultados</td></tr>";
			var losDatos = data.Arriendo,valViv='';
			if( losDatos ){
				for(var i=0;i<(losDatos.length);i++){
					nuevaFila="<tr>";
					// añadimos las columnas
					var object = losDatos[i];					
					for(property in object) {
						var valor = object[property]; //+', '+property;						
						var linkDoc = '', urlDoc='';
						//console.log(property);
						if( property == 'destino' && i==0 ){ valViv = valor; }
						if( property == 'doc_respaldo' ){
							urlDoc=valor;
							linkDoc = '<a href="/appCasasFiscalesV02/bsvs/../'+urlDoc+'" target="_blank" class="btn btn-info">Informe de Asignaciones</a>';
							//valor += linkDoc;
							valor = linkDoc;
						}
						nuevaFila+="<td>"+valor+"</td>";
					}
					nuevaFila+="</tr>";
					$("#tablaAsignaciones").append(nuevaFila);
				}
			}else{
				$("#tablaAsignaciones").append(nuevaFila);
			}
			var urlFinal = $("#btnNuevaAsignacion").attr("href");
			if( valViv == 'Asignación' ){ valViv='Devolución/'+beneficiario_id;}else{valViv='Asignación'; }
			if( (losDatos.length) == 0 ){ valViv='Asignación'; }
			var stringPos = urlFinal.indexOf(valViv);
			if( stringPos <= 0 ){	urlFinal = $("#btnNuevaAsignacion").attr("href")+'/'+valViv; }
			$("#btnNuevaAsignacion").attr("href", urlFinal);
		}
		,error: function(xhr,status,error){
			console.log('error 1: '+error);
			console.log('error 2: '+xhr);
			console.log('error 3: '+xhr.responseText);
		}
	});
}
