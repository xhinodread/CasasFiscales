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

$latitud = -29.902087;
$longitud = -71.251971;
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
		"windowText"   => "Calle # 123<br>Lat:".$latitud."<br>Lon:".$longitud
);
$map_marker_options = array(
		"showWindow"   => true,
		"windowText"   => "Calle # 123<br>Lat:".$latitud."<br>Lon:".$longitud,
		"markerTitle"  => "Calle # 123<br>Lat:",
		/*"markerIcon"   => "http://labs.google.com/ridefinder/images/mm_20_purple.png",
		"markerShadow" => "http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png"*/
);
?>
<?=$this->Html->script("http://maps.google.com/maps/api/js?sensor=false", false); ?>
<div class="container-flex">

	<div class="row">
		<div class="col-md-3"><legend>Agregar Viviendas</legend></div>
	</div>
    
	<div class="row">
		<div class="col-md-11">
			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/viviendas/agrega', array('class'=>'btn btn-primary') )?></div>
		</div>
	</div>

<div class="row">
	<div class="col-md-11">
		<div class="table-responsiveDos">
			<?=$this->Form->Create('');?>
				<table class="table table-bordered table-condensed" >
					<tr>
						<th>Rol *</th>
						<td colspan="2">
							<?=$this->Form->hidden('Vivienda.activo', array('default' => 1) );?>
							<?=$this->Form->input('Vivienda.rol', array('div'=>array('class'=>'col-md-2'),
																					 'type'=>'text',
																					 'default' => '',
																					 'label' => false,
																					 'placeholder' =>'1111-01',
																					 'class' => 'resaltar form-control inputRut',
																					 'maxlength' => 12,
																					/* 'required'=>'required',*/
																					 'style'=>"text-align: center;"
																	) );
							?>
						</td>
					</tr>

					<tr>
						<th>Dirección</th>
						<td>
							<?=$this->Form->input('Vivienda.calle', array('div'=>array('class'=>'col-sm-10 col-md-10 col-lg-10'),
																					 'type'=>'text',
																					 'label'=>'Calle *',
																					 'default' => '',
																					 'placeholder' =>'Calle de la calle',
																					/* 'required'=>'required',*/
																					 'class' => 'resaltar form-control inputRut') );
							?>
							<?=$this->Form->input('Vivienda.numero', array('div'=>array('class'=>'col-xs-4 col-sm-4 col-md-2 col-lg-2'),
																					 'type'=>'text',
																					 'label' => 'Número *',
																					 'default' => '',
																					 'placeholder' =>'01',
																					/* 'required'=>'required',*/
																					 'class' => 'resaltar form-control inputRut') );
							?>
						</td>
						<td>
							<?=$this->Form->input('Vivienda.sector', array('div'=>array('class'=>'col-sm-5 col-md-5 col-lg-5'),
																					 'type'=>'text',
																					 'label'=>'Sector *',
																					 'default' => '',
																					 'placeholder' =>'Centro',
																					/* 'required'=>'required',*/
																					 'class' => 'resaltar form-control inputRut') );
							?>
							<?=$this->Form->input('Vivienda.block', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'label'=>'Block',
																					 'default' => '',
																					 'placeholder' =>'A',
																					 /*'required'=>'required',*/
																					 'class' => 'resaltar form-control inputRut') );
							?>
							<?=$this->Form->input('Vivienda.depto', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'label'=>'Depto',	
																					 'default' => '',
																					 'placeholder' =>'A-01',
																					 /*'required'=>'required',*/
																					 'class' => 'resaltar form-control inputRut') );
							?>
						</td>
					</tr>

					<tr>
						<th></th>
						<td>
							<?=$this->Form->input('Vivienda.referencia', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																					 'type'=>'text',
																					 'default' => '',
																					 'label' => 'Referencia',
																					 'placeholder' =>'Entre Cuartel de Bomberos y Chile atiende',
																					 'class' => 'resaltar form-control inputRut') );
							?>
						</td>
						<td>
							<?
								$varComuna = split(',', $comunas[4101] );
							?>
							<?=$this->Form->hidden('Vivienda.comuna_id', array('default' => 4101 ));?>
							<?=$this->Form->input('Comuna.comuna_nom', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'default' => $varComuna[0],
																					 'label' => 'Comuna *',
																					 'required'=>'required',
																					 'class' => 'resaltar form-control inputRut') );
							?>
							<?=$this->Form->input('Provincia.id', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'default' => $provincias[41],
																					 'label' => 'Provincia',
																					 'class' => 'form-control inputRut',
																					 'readonly'=>'readonly') );
							?>
							<?=$this->Form->input('Vivienda.cod_postal', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'default' => '',
																					 'label' => 'Codigo Postal',
																					 'placeholder' =>'178776987',
																					 'class' => 'resaltar form-control inputRut') );
							?>
						</td>
					</tr>

					<tr>
						<th></th>
						<td>
							<?=$this->Form->input('Vivienda.latitud', array('div'=>array('class'=>'col-sm-6 col-md-6 col-lg-6'),
																					 'type'=>'text',
																					 'default' => $latitud,
																					 'label' => 'Latitud',
																					 'placeholder' =>'-29.902087',
																					 'class' => 'resaltar form-control inputRut') );
							?>
							<?=$this->Form->input('Vivienda.longitud', array('div'=>array('class'=>'col-sm-6 col-md-6 col-lg-6'),
																					 'type'=>'text',
																					 'default' => $longitud,
																					 'label' => 'Longitud',
																					 'placeholder' =>'-71.251971',
																					 'class' => 'resaltar form-control inputRut') );
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
						<th>Monto Avalúo $ *</th>
						<td colspan="2">
							<?=$this->Form->input('Vivienda.monto_avaluo', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																					 'type'=>'text',
																					 'maxlength' => 12,
																					 'value' => '',
																					 'label' => '',
																					 'placeholder' =>'11.111.111-1',
																					 'class' => 'resaltar form-control inputRut') );
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
				<div><label><?=$this->Funciones->CampoRequerido;?></label></div>
				<?//=$this->Form->submit('Guardar Cambios', array('class' => 'btn btn-primary', 'div'=>false) );?>
				<?=$this->Form->button('Guardar Cambios', array( 'id'=>'subMit', 'class' => 'btn btn-primary inputRut') );?>
			<?=$this->Form->end();?>       
		</div>
	</div>
</div>
	
</div>
<script>
$(document).ready(function(){

	var comunas = [<?=$this->Funciones->arrayJquery($comunas);?>];
		$( "#ComunaComunaNom" ).autocomplete({ 
			source: comunas,
			select: function( event, ui ) {
				$( "#ComunaComunaNom" ).val( ui.item.label );
				$( "#ViviendaComunaId" ).val( ui.item.value );
				return false;
				}
		});
	
	$("#ViviendaMontoAvaluo").keyup(function(){
		$(this).val( NumerosChile( $(this).val() ) );
	});
	
	});
</script>