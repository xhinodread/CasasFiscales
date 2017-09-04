<?//='elBeneficiario:<pre>'.print_r(count($elBeneficiario), 1).'</pre>';?>
<?//='elBeneficiario:<pre>'.print_r($elBeneficiario, 1).'</pre>';?>
<?//='<pre>'.print_r($beneficiarios, 1).'</pre>';?>
<?//='beneficiariosX: <pre>'.print_r($beneficiariosX, 1).'</pre>';?>
<?//='<pre>'.print_r($this->Funciones->beneficiarioNombrePersona($beneficiarios), 1).'</pre>';?>
<?//='listaDestino: <pre>'.print_r($listaDestino, 1).'</pre>';?>
<?// ='listaBeneficiarios: <pre>'.print_r($listaBeneficiarios, 1).'</pre>';?>
<?//='sueldoBeneficiarios: <pre>'.print_r($sueldoBeneficiarios, 1).'</pre>';?>
<?//='listaSueldos: <pre>'.print_r($listaSueldos, 1).'</pre>';?>
<?//='generaArray: <pre>'.print_r($this->Funciones->generaArray($listaSueldos), 1).'</pre>';?>

<? 
	$listaBeneficiariosTmp = $this->Funciones->beneficiarioNombrePersona($beneficiariosX);  
	foreach( $listaBeneficiariosTmp as $pnt => $lista){
		$listaBeneficiarios[$pnt] =$lista[0];
		$sueldoBeneficiarios[$pnt] =$lista[1];
		$servicioBeneficiario[$pnt] =$lista[2];
	}
	$listaSueldos = $this->Funciones->generaArray($sueldoBeneficiarios);

	// $elBeneficiarioNombre = ( count($elBeneficiario) > 0 ? trim($elBeneficiario['Beneficiario']['nombres']).' '.trim($elBeneficiario['Beneficiario']['paterno']).' '.trim($elBeneficiario['Beneficiario']['materno']) : '');

	$elBeneficiarioNombre = '';
	$estadoTxtBeneficiarioNombre = $elBeneficiarioNombre;
	$elBeneficiarioId = 0;
	$servicio_id = $elBeneficiarioId;
	if( count($elBeneficiario) > 0 ){
		$elBeneficiarioNombre = trim($elBeneficiario['Beneficiario']['nombres']).' '.trim($elBeneficiario['Beneficiario']['paterno']).' '.trim($elBeneficiario['Beneficiario']['materno']);
		$elBeneficiarioId = $elBeneficiario['Beneficiario']['id'];
		$estadoTxtBeneficiarioNombre = array('readonly'=>'readonly');
		$servicio_id = $elBeneficiario['beneficiarios_servicio']['servicio_id'];
	}

?>

<div class="container-flex">

  <div class="row">
		<div class="col-md-3"><legend>Agregar <?=$ultimo_estado?></legend></div>
  </div>
 
 	<div class="row">
		<div class="col-md-11">
			<div class="table-responsiveDos">
				<div style="float:right; margin-bottom:20px; ">
					<?=$this->Html->link('Volver', '/viviendas/edita/id:'.trim($vivienda['Vivienda']['id']) , array('id'=>'btnNuevaAsignacion', 'class'=>'btn btn-primary') )?>
				</div>
				<?=$this->Form->Create('bsv', array('enctype' => 'multipart/form-data'));?>
					<table class="table table-bordered table-condensed table-responsive" >
					
						<tr>
							<td colspan="3">
							<?=$this->Form->input('Vivienda.rol', array('div'=>array('class'=>'col-md-2'),
																				 'type'=>'text',
																				 'default' => trim($vivienda['Vivienda']['rol']),
																				 /*'label' => false,*/
																				 'class' => 'form-control inputRut',
																				 'maxlength' => 12,
																				 'style'=>"text-align: center;",
																				 'readonly'=>'readonly') );
							?>
							</td>
						</tr>
						<tr>
							<td colspan="4">
								<? $direccion = trim($vivienda['Vivienda']['calle']).' #'.trim($vivienda['Vivienda']['numero']); ?>
								<?=$this->Form->input('Vivienda.direccion', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																						 'type'=>'text',
																						 'default' => $direccion,
																						 'class' => 'form-control inputRut',
																						 'readonly'=>'readonly') );
								?>
								<?=$this->Form->input('Vivienda.block', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																						 'type'=>'text',
																						 'default' => trim($vivienda['Vivienda']['block']),
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 'readonly'=>'readonly') );
								?>
								<?=$this->Form->input('Vivienda.depto', array('div'=>array('class'=>'col-sm-3 col-md-3 col-lg-3'),
																						 'type'=>'text',
																						 'default' => trim($vivienda['Vivienda']['depto']),
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 'readonly'=>'readonly') );
								?>
								<?=$this->Form->input('Vivienda.sector', array('div'=>array('class'=>'col-sm-6 col-md-6 col-lg-6'),
																						 'type'=>'text',
																						 'default' => trim($vivienda['Vivienda']['sector']),
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 'readonly'=>'readonly') );
								?>
							</td>
						</tr>
					
						<tr>
							<td>
								<?=$this->Form->hidden('vivienda_id', array('default' => $vivienda_id) );?>
								<?=$this->Form->input('created', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'text',
																						 'default' => date('d/m/Y'),
																						 'label' => 'Fecha',
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 'readonly'=>'readonly') );
								?>
							</td>
							<td>
								<?=$this->Form->hidden('servicio_id', array('default' => $servicio_id) );?>
								<?=$this->Form->hidden('beneficiario_id', array('default' => $elBeneficiarioId) );?>
								<?=$this->Form->input('beneficiario_nombre', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'text',
																						 'default' => $elBeneficiarioNombre,
																						 'label' => 'Beneficiario *',
																						 'placeholder'=>'Nombre del Beneficiario',
																						 'required'    => 'required',
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 $estadoTxtBeneficiarioNombre) );
								?>
							</td>
							<td>
								<? if(0): $this->Form->input('Arriendos_historial.tipo_destino_idX', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'select',
																						 'options' => $listaDestino,
																						 'selected' => $idEstado,
																						 'label' => 'Destino',
																						 'class' => 'form-control inputRut',
																						 'readonly'=>'readonly') ); endif;
								?>
								<?=$this->Form->hidden('Arriendos_historial.destino_id', array('default' => $idEstado) );?>
								<?=$this->Form->input('X.tipo_destino_nombre', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'text',
																						 'default' => $listaDestino[$idEstado],
																						 'label' => 'Destino',																						 
																						 'class' => 'form-control inputRut',
																						 'readonly'=>'readonly') );
								?>
								
							</td>
						</tr>

						<tr>
							<td>
								<?=$this->Form->input('Arriendos_historial.monto_arriendo', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'text',
																						 'default' => 0,
																						 'label' => 'Monto Arriendo',
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;",
																						 'readonly'=>'readonly') );
								?>
							</td>
							<td >
								<?=$this->Form->input('Arriendos_historial.observacion', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'textarea',
																						 'default' => '',
																						 'placeholder'=>'Descripción del tipo',
																						 'required'    => 'required',
																						 'cols'=>200,
																						 'maxlength'=>106,
																						 'label' => 'Observación *',
																						 'class' => 'resaltar form-control inputRut') );
								?>
							</td>
							<td>
								<?=$this->Form->input('Arriendos_historial.doc_respaldo', array('label' => 'Documento (pdf) *',
																												'between' => '<br />',
                                                        'type'  => 'file',
																												'accept' => 'application/pdf',
                                                        'class' => 'resaltar form-control form_control',
                                                        'required'    => 'required',
                                                        'placeholder' => 'Documento'
																												));
                ?>
							</td>
						</tr>
					</table>
					<div><label><?=$this->Funciones->CampoRequerido;?></label></div>
				<?//=$this->Form->submit('Guardar Cambios', array('class' => 'btn btn-primary', 'div'=>false) );?>
				<?=$this->Form->button('Guardar Cambios', array('id'=>'agregar', 'type'  => 'submit', 'class' => 'btn btn-block btn-info form_control col-mx-12'));?>
				<?=$this->Form->end();?>
			</div>
		</div>
	</div>
   
</div>

<div id="dialog" title="Basic dialog">
 	<h3 class="ui-widget-header ui-corner-all">ATENCION</h3>
  <p>Seleccione un beneficiario valido.</p>
</div>

<div class="toggler">
	<div id="effect" class="ui-widget-content ui-corner-all">
		<h3 class="ui-widget-header ui-corner-all">ATENCION</h3>
		<p><label>Seleccione un beneficiario valido</label></p>
	</div>
</div>

 <style>
    .toggler { width: 500px; height: 200px; position: fixed; }
    #button { padding: .5em 1em; text-decoration: none; }
    #effect { width: 240px; height: 170px; padding: 0.4em; position: relative; }
    #effect h3 { margin: 0; padding: 0.4em; text-align: center; }
    .ui-effects-transfer { border: 2px dotted gray; }
  </style>

<script>
$(document).ready(function(){
	$( "#dialog" ).hide();
	/**************************** Seleccione un beneficiario valido ********************************/
	$( "button" ).click(function( event ){
		if( $("#bsvBeneficiarioId").val() <= 1 ){
			event.preventDefault();
			//alert('Seleccione un beneficiario valido');
			$(function(){ 
				$( "#dialog" ).dialog(); 
				// setTimeout(function() {	$( "#dialog:visible" ).removeAttr( "style" ).fadeOut();	}, 2000 );
				// setTimeout(function() {	$( "#dialog" ).dialog( "close" ).fadeOut();	}, 3000 );
			});
			
		//	$(function(){ runEffect(); });
 			
		}
		//console.log('prevent default');
	});

		function runEffect() {
			// get effect type from
			var selectedEffect = $( "#effectTypes" ).val();

			// Most effect types need no options passed by default
			var options = {};
			// some effects have required parameters
			if ( selectedEffect === "scale" ) {
				options = { percent: 50 };
			} else if ( selectedEffect === "size" ) {
				options = { to: { width: 280, height: 185 } };
			}
			// Run the effect
			$( "#effect" ).show( selectedEffect, options, 500, callback() );
		};

		//callback function to bring a hidden box back
		function callback() {
			setTimeout(function() {
				$( "#effect:visible" ).removeAttr( "style" ).fadeOut();
			}, 2000 );
		};
	/**************************** FIN Seleccione un beneficiario valido ********************************/
	
	
	var beneficiarios = [<?=$this->Funciones->arrayJquery($listaBeneficiarios);?>];	
	/*var sueldoBeneficiarios = [<?//=$this->Funciones->generaArray($listaSueldos);?>];	*/
	var sueldoBeneficiario = <?=json_encode($listaSueldos);?>;
	var servicioBeneficiario = <?=json_encode($servicioBeneficiario);?>;
	
	$("#bsvBeneficiarioNombre").keyup(function(){
		//console.log( $("#bsvBeneficiarioNombre").val() + ': ' + $("#bsvBeneficiarioNombre").val().length );
		if( $("#bsvBeneficiarioNombre").val().length == 0 ){
			$("#bsvBeneficiarioId").val(0);
		}
	});
	
	
	$( "#bsvBeneficiarioNombre" ).autocomplete({ 
		source: beneficiarios,
		select: function( event, ui ) {
			var montoAriendo = Math.round(sueldoBeneficiario[ui.item.value] * 0.10) ;
			$( "#bsvServicioId" ).val( servicioBeneficiario[ui.item.value] );
			$( "#bsvBeneficiarioNombre" ).val( ui.item.label );
			$( "#bsvBeneficiarioId" ).val( ui.item.value );
			$( "#Arriendos_historialMontoArriendo" ).val( montoAriendo.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1.') );
			return false;
			}
	});
	
	$('#Arriendos_historialDocRespaldo').change(function(){
		var msxTamano = 2048;
		var f=this.files[0]
		var peso = (f.size||f.fileSize);
		if( Math.round(peso/1024) > msxTamano){
			alert('Tamaña de archivo no permitido, maximo 2MB');
			$('#agregar').attr('disabled', true);
			$("#Arriendos_historialDocRespaldo").val('');
		}else{
			$('#agregar').attr('disabled', false);
		}
	});

 $( "#effect" ).hide();
	
});
</script>