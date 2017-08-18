<?
App::import('Vendor', 'Funcionespropias');
//$funciones = new Funcionespropias();
//$optionsCumple=array('1'=>'Si Cumple','0'=>'No Cumple');
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }						

// echo 'arrayConsume<pre class="little">this:'.print_r($arrayConsume, 1).'</pre>';
// echo '<pre class="little">this:'.print_r($datos, 1).'</pre>';
// echo '<pre class="little">estados_civil:'.print_r($estados_civil, 1).'</pre>';
// echo '<pre>comunas:'.print_r($comunas, 1).'</pre>';
// echo '<pre>provincias:'.print_r($provincias, 1).'</pre>';

$latitud = trim($datos['Vivienda']['latitud']); // -29.902087;
$longitud = trim($datos['Vivienda']['longitud']); // -71.251971;
// Override any of the following default options to customize your map 
$map_options = array(
		"id"           => "map_canvas",
		"width"        => "100%",
		"height"       => "200px",
		"zoom"         => 17,
		"type"         => "SATELLITE",
		"localize"     => false,
		"latitude"     => $latitud,
		"longitude"    => $longitud,
		"marker"       => true,
		"markerIcon"   => "http://google-maps-icons.googlecode.com/files/home.png",
		"markerShadow" => "http://google-maps-icons.googlecode.com/files/shadow.png",
		"infoWindow"   => false,
		"windowText"   => trim($datos['Vivienda']['calle'])."# ".trim($datos['Vivienda']['numero'])."<br>Lat:".$latitud."<br>Lon:".$longitud
);
$map_marker_options = array(
		"showWindow"   => true,
		"windowText"   => trim($datos['Vivienda']['calle'])."# ".trim($datos['Vivienda']['numero'])."<br>Lat:".$latitud."<br>Lon:".$longitud,
		"markerTitle"  => trim($datos['Vivienda']['calle'])."# ".trim($datos['Vivienda']['numero']),
		/*"markerIcon"   => "http://labs.google.com/ridefinder/images/mm_20_purple.png",
		"markerShadow" => "http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png"*/
);
?>
<?=$this->Html->script("http://maps.google.com/maps/api/js?sensor=false", false); ?>
<div class="container-flex">

  <div class="row">
		<div class="col-md-3"><legend>Administración de Vivienda</legend></div>
  </div>
   
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/viviendas/agrega', array('class'=>'btn btn-primary') )?></div>
    </div>
  </div>
    
	<div class="row">
			<div class="col-md-11">
					<div class="table-responsiveDos">
						<?=$this->Form->Create('Vivienda');?>
							<table class="table table-bordered table-condensed" >
								<tr>
									<th>Rol</th>
									<td colspan="2">
										<?=$this->Form->hidden('Vivienda.id', array('default' => $datos['Vivienda']['id']) );?>
										<?=$this->Form->input('Vivienda.rol', array('div'=>array('class'=>'col-md-2'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['rol']),
																								 'label' => false,
																								 'class' => 'form-control inputRut',
																								 'maxlength' => 12,
																								 'style'=>"text-align: center;",
																								 'readonly'=>'readonly') );
										?>
									</td>
								</tr>

								<tr>
									<th>Dirección</th>
									<td>
										<?=$this->Form->input('Vivienda.calle', array('div'=>array('class'=>'col-sm-10 col-md-10 col-lg-10'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['calle']),
																								 'class' => 'form-control inputRut') );
										?>
										<?
											$textoLabel = $this->Funciones->msgValidacion($arrayConsume, 'numero', 'ViviendaNumero');
											$textoLabel = ( strlen($textoLabel)>0 ? $textoLabel : 'Número' );
										?>
										<?//=$this->Funciones->msgValidacion($arrayConsume, 'numero', 'ViviendaNumero');?>
										<?=$this->Form->input('Vivienda.numero', array('div'=>array('class'=>'col-xs-4 col-sm-4 col-md-2 col-lg-2'),
																								 'type'=>'text',
																									'label' => $textoLabel,
																								 'default' => trim($datos['Vivienda']['numero']),
																								 'class' => 'form-control inputRut') );
										?>
									</td>
									<td>
										<?=$this->Form->input('Vivienda.sector', array('div'=>array('class'=>'col-sm-5 col-md-5 col-lg-5'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['sector']),
																								 'class' => 'form-control inputRut') );
										?>
										<?=$this->Form->input('Vivienda.block', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['block']),
																								 'class' => 'form-control inputRut') );
										?>
										<?=$this->Form->input('Vivienda.depto', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['depto']),
																								 'class' => 'form-control inputRut') );
										?>
									</td>
								</tr>

								<tr>
									<th></th>
									<td>
										<?=$this->Form->input('Vivienda.referencia', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['referencia']),
																								 'label' => 'Referencia',
																								 'class' => 'form-control inputRut') );
										?>
									</td>
									<td>
										<?
											$varComuna = array(0, 0);
											if( isset($datos['Vivienda']['comuna_id']) && $datos['Vivienda']['comuna_id']>0 ){
												$varComuna = split(',', $comunas[trim($datos['Vivienda']['comuna_id'])] );
											}												
										?>
										<?=$this->Form->hidden('Vivienda.comuna_id', array('default' => trim($datos['Vivienda']['comuna_id'])) );?>
										<?=$this->Form->input('Vivienda.comuna_nom', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'default' => $varComuna[0],
																								 'label' => 'Comuna',
																								 'class' => 'form-control inputRut') );
										?>
										<?=$this->Form->input('Provincia.id', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'default' => $provincias[$varComuna[1]],
																								 'label' => 'Provincia',
																								 'class' => 'form-control inputRut',
																								 'readonly'=>'readonly') );
										?>
										<?=$this->Form->input('Vivienda.cod_postal', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['cod_postal']),
																								 'label' => 'Codigo Postal',
																								 'class' => 'form-control inputRut') );
										?>
									</td>
								</tr>

								<tr>
									<th></th>
									<td>
										<?
											$textoLabel = $this->Funciones->msgValidacion($arrayConsume, 'latitud', 'ViviendaLatitud');
											$textoLabel = ( strlen($textoLabel)>0 ? $textoLabel : 'Latitud' );
										?>
										<?//=$this->Funciones->msgValidacion($arrayConsume, 'latitud', 'ViviendaLatitud');?>
										<?=$this->Form->input('Vivienda.latitud', array('div'=>array('class'=>'col-sm-6 col-md-6 col-lg-6'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['latitud']),
																								 'label' => $textoLabel,
																								 'class' => 'form-control inputRut') );
										?>

										<?
											$textoLabel = $this->Funciones->msgValidacion($arrayConsume, 'longitud', 'ViviendaLongitud');
											$textoLabel = ( strlen($textoLabel)>0 ? $textoLabel : 'Longitud' );
										?>
										<?//=$this->Funciones->msgValidacion($arrayConsume, 'longitud', 'ViviendaLongitud');?>
										<?=$this->Form->input('Vivienda.longitud', array('div'=>array('class'=>'col-sm-6 col-md-6 col-lg-6'),
																								 'type'=>'text',
																								 'default' => trim($datos['Vivienda']['longitud']),
																								 'label' => $textoLabel,
																								 'class' => 'form-control inputRut') );
										?>
									</td>
									<td>
										<div style="float:inherit; text-align:center;" class="col-sm-12 col-md-12 col-lg-12">
											<?=$this->GoogleMap->map($map_options); ?>
											<?=$this->GoogleMap->addMarker("map_canvas", 1, array("latitude" => $latitud, "longitude" => $longitud), $map_marker_options); ?>
										</div>
									</td>
								</tr>									

								<tr>
									<th>Servicio</th>
									<td>
										<?=$this->Form->input('Servicio.nombre', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																								 'type'=>'text',
																								 'default' => 'Servicio.nombre',
																								 'label' => '',
																								 'class' => 'form-control inputRut',
																								 'readonly'=>'readonly') );
										?>
									</td>
									<td>
										<?=$this->Form->input('Servicio.nombre_jefe', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																								 'type'=>'text',
																								 'default' => 'Jefe de Servicio',
																								 'label' => 'Jefe de Servicio',
																								 'class' => 'form-control inputRut',
																								 'readonly'=>'readonly') );
										?>
									</td>
								</tr>

								<tr>
									<th>Beneficiario</th>
									<td colspan="2">
										<?=$this->Form->input('Beneficiario.nombre', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																								 'type'=>'text',
																								 'default' => 'Beneficiario.nombre',
																								 'label' => '',
																								 'class' => 'form-control inputRut',
																								 'readonly'=>'readonly') );
										?>
									</td>
								</tr>

								<tr>
									<th>Monto Avalúo $</th>
									<td colspan="2">
										<?
											$textoLabel = $this->Funciones->msgValidacion($arrayConsume, 'monto_avaluo', 'ViviendaMontoAvaluo');
											$textoLabel = ( strlen($textoLabel)>0 ? $textoLabel : '' );
										?>
										<?=$this->Form->input('Vivienda.monto_avaluo', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'maxlength' => 12,
																								 'value' => $this->Funciones->formatoNum(trim($datos['Vivienda']['monto_avaluo'])),
																								 'label' => $textoLabel,
																								 'class' => 'form-control inputRut') );
										?>.-
									</td>
								</tr>

								<tr>
									<th>Monto Arriendo $</th>
									<td colspan="2">
										<?=$this->Form->input('Arriendo.monto_arriendo', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																								 'type'=>'text',
																								 'value' => 0,
																								 'label' => '',
																								 'class' => 'form-control inputRut',
																								 'readonly'=>'readonly') );
										?>.-
									</td>
								</tr>

							</table>
							<?=$this->Form->submit('Guardar Cambios', array('class' => 'btn btn-primary', 'div'=>false) );?>
							<a href="#mantenciones" id="openerMantenciones" class="btn btn-info">Ver Mantenciones</a><!--<a name="mantenciones" id="mantenciones"></a>-->
							<a href="#asignaciones" id="openerAsignaciones" class="btn btn-info">Ver Asignaciones</a>
						<?=$this->Form->end();?>       
					</div>
			</div>
	</div>

	
	
</div>

<!--<button id="create-user">Create new user</button>-->
<!-- <div id="dialog-form" title="Create new user">
  <p class="validateTips">All form fields are required.</p>
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
      <label for="email">Email</label>
      <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -- >
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>-->

<!--************************************************************************************************-->
<div id="dialogMantenciones" title="Historial de Mantenciones" >
 	<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/mantenciones/agrega/'.$datos['Vivienda']['id'] , array('class'=>'btn btn-primary') )?></div>
  <table width="0" border="0" class="historialMantenciones table table-bordered table-striped table-hover table-condensed table-responsive" id="tablaMantenciones">
    <tr class="info" >
      <th>Fecha</th>
      <th>Tipo</th>
      <th>Observación</th>
      <th>Documento</th>
    </tr>
  </table>
</div>

<div id="dialogAsignaciones" title="Historial de Asignaciones" >
 	<div style="float:right; margin-bottom:20px; ">
 		<?=$this->Html->link('[+] Nuevo', '/Bsvs/agrega/'.$datos['Vivienda']['id'] , array('id'=>'btnNuevaAsignacion', 'class'=>'btn btn-primary') )?>
 	</div>
  <table width="0" border="0" class="historialAsignaciones table table-bordered table-striped table-hover table-condensed table-responsive" id="tablaAsignaciones">
    <tr class="info" >
      <th>Fecha</th>
      <th>Destino</th>
      <th>Beneficiario</th>
      <th>Monto Arriendo</th>
      <th>Observación</th>
      <th>Documento</th>
    </tr>
  </table>
</div>

<script>
$(document).ready(function(){
  //$(function(){
    	var comunas = [<?=$this->Funciones->arrayJqueryConComa($comunas);?>];
			$( "#ViviendaComunaNom" ).autocomplete({ 
				source: comunas,
				select: function( event, ui ) {
					$( "#ViviendaComunaNom" ).val( ui.item.label );
					$( "#ViviendaComunaId" ).val( ui.item.value );
					return false;
					}
			});
		
		/************************************************************************************* /
		var dialog, form;
		function addUser() {
      var valid = true;
			return valid;
    }
		
		dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 400,
      width: 350,
      modal: true,
      buttons: {
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        // allFields.removeClass( "ui-state-error" );
      }
    });
		
		form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
		
		$( "#create-user" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
		
		/ *************************************************************************************/
		
	$( function() {
		$( "#dialogMantenciones" ).dialog({
			autoOpen: false,
			modal: true,
			title: 'Historial de Mantención',
			height: 400,
			width: 900,			 
			show: { effect: "blind", duration: 1000 },
			hide: { effect: "explode", duration: 1000 }
		});
	});

	$( "a" ).on( "click", function() {
		if(this.id == 'openerMantenciones'){
			$( "#dialogMantenciones" ).dialog( "open" );
			if ( $("#dialogMantenciones").dialog("isOpen") == true ){
				//console.log('isOpen');
				llamarHistorialMantencion( $("#ViviendaId").val() );
			 }
		}
	});
	
	$( function() {
		$( "#dialogAsignaciones" ).dialog({
			autoOpen: false,
			modal: true,
			title: 'Historial de Asignaciones',
			height: 400,
			width: 900,			 
			show: { effect: "blind", duration: 1000 },
			hide: { effect: "explode", duration: 1000 }
		});
	});

	$( "a" ).on( "click", function() {
		if(this.id == 'openerAsignaciones'){
			$( "#dialogAsignaciones" ).dialog( "open" );
			if ( $("#dialogAsignaciones").dialog("isOpen") == true ){
				//console.log('isOpen');
				llamarHistorialAsignacion( $("#ViviendaId").val() );
			}
		}
	});
		
});
</script>