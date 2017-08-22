<?//='<pre>'.print_r($beneficiarios, 1).'</pre>';?>
<?//='<pre>'.print_r($beneficiariosX, 1).'</pre>';?>
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
?>

<div class="container-flex">

  <div class="row">
		<div class="col-md-3"><legend>Agregar <?=$ultimo_estado?></legend></div>
  </div>
 
 	<div class="row">
		<div class="col-md-11">
			<div class="table-responsiveDos">
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
								<?=$this->Form->hidden('servicio_id', array('default' => 0) );?>
								<?=$this->Form->hidden('beneficiario_id', array('default' => 0) );?>
								<?=$this->Form->input('beneficiario_nombre', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'text',
																						 'label' => 'Beneficiario',
																						 'placeholder'=>'Nombre del Beneficiario',
																						 'class' => 'form-control inputRut',
																						 'style'=>"text-align: center;") );
								?>
							</td>
							<td>
								<?=$this->Form->input('Arriendos_historial.tipo_destino_id', array('div'=>array('class'=>'col-md-'),
																						 'type'=>'select',
																						 'options' => $listaDestino,
																						 'selected' => $idEstado,
																						 'label' => 'Destino',
																						 'class' => 'form-control inputRut') );
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
																						 'cols'=>200,
																						 'label' => 'Observación',
																						 'class' => 'form-control inputRut') );
								?>
							</td>
							<td>
								<?=$this->Form->input('Arriendos_historial.doc_respaldo', array('label' => 'Documento',
																												'between' => '<br />',
                                                        'type'  => 'file',
																												'accept' => 'application/pdf',
                                                        'class' => 'form-control form_control',
                                                        /*'required'    => 'required',*/
                                                        'placeholder' => 'Documento'
																												));
                ?>
							</td>
						</tr>
					</table>
				<?=$this->Form->submit('Guardar Cambios', array('class' => 'btn btn-primary', 'div'=>false) );?>
				<?=$this->Form->end();?>
			</div>
		</div>
	</div>
   
</div>

<script>
$(document).ready(function(){

	var beneficiarios = [<?=$this->Funciones->arrayJquery($listaBeneficiarios);?>];	
	/*var sueldoBeneficiarios = [<?//=$this->Funciones->generaArray($listaSueldos);?>];	*/
	var sueldoBeneficiario = <?=json_encode($listaSueldos);?>;
	var servicioBeneficiario = <?=json_encode($servicioBeneficiario);?>;
	
	
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

});
</script>