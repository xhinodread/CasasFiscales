<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
$optionsCumple=array('1'=>'Si Cumple','0'=>'No Cumple');
$attributesOptionCumple=array('legend'=>false, 'default' => $datos['Beneficiario']['cumple'], 'div'=>true, 'separator'=> '</div><div class="col-md-2 " >' );
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }						
									
 //echo '<pre class="little">casaAsignada:'.print_r($casaAsignada, 1).'</pre>';
// echo '<pre class="little">this:'.print_r($datos, 1).'</pre>';
// echo '<pre class="little">servicios:'.print_r($servicios, 1).'</pre>';
?>

<div class="container-flex">

	<div class="row">
		<div class="col-md-3"><legend>Administración de Beneficiario</legend></div>
	</div>
    
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/beneficiarios/agrega', array('class'=>'btn btn-primary') )?></div>
  	</div>
  </div>
    
	<div class="row">
		<div class="col-md-11">
			<div class="table-responsiveDos">
				<?=$this->Form->Create('Beneficiario');?>
					<table class="table table-bordered table-condensed" >
						<tr>
							<td width="128" style="width:100px;" >Rut</td>
							<td colspan="2" >
								<?=$this->Form->hidden('Beneficiario.id', array('default' => $datos['Beneficiario']['id']) );?>
								<?=$this->Form->input('Beneficiario.rut', array('div'=>array('class'=>'col-md-2'),
									 'type'=>'text',
									 'default' => $funciones->formatoNum($datos['Beneficiario']['rut']).'-'.$datos['Beneficiario']['dv'],
									 'label' => false,
									 'class' => 'form-control inputRut',
									 'maxlength' => 12,
									 'readonly'=>'readonly') );?>
							</td>
						</tr>
						<tr>
							<td>Nombre</td>
							<td colspan="2">
								<?=$this->Funciones->msgValidacion($arrayConsume, 'nombres', 'BeneficiarioNombres');?>
								<?=$this->Form->input('nombres', array('div'=>array('class'=>'col-md-3'), 
									'default' => trim($datos['Beneficiario']['nombres']),
									'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
								<?=$this->Funciones->msgValidacion($arrayConsume, 'paterno', 'BeneficiarioPaterno');?>
								<?=$this->Form->input('paterno', array('div'=>array('class'=>'col-md-3'), 
									'default' => trim($datos['Beneficiario']['paterno']),
									'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
								<?=$this->Funciones->msgValidacion($arrayConsume, 'materno', 'BeneficiarioMaterno');?>
								<?=$this->Form->input('materno', array('div'=>array('class'=>'col-md-3'), 
									'default' => trim($datos['Beneficiario']['materno']),
									'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
							</td>
						</tr>
						<tr>
							<td>Telefono</td>
							<td colspan="2">
								<?=$this->Funciones->msgValidacion($arrayConsume, 'celular', 'BeneficiarioCelular');?>
								<?=$this->Form->input('celular', array('div'=>array('class'=>'col-md-2'), 'default' => trim($datos['Beneficiario']['celular']), 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
							</td>
						</tr>
						<tr>
							<td>E-Mail</td>
							<td colspan="2">
								<?=$this->Funciones->msgValidacion($arrayConsume, 'email', 'BeneficiarioEmail');?>
								<?=$this->Form->input('email', array('div'=>array('class'=>'col-md-3'), 'default' => trim($datos['Beneficiario']['email']), 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
							</td>
						</tr>
						<tr>
							<td>Estado Civil</td>
							<td colspan="2"><?=$this->Form->input('estcivil_id', array('div'=>array('class'=>'col-md-2'), 'options'=>$estados_civil, 'empty' =>'-- Seleccione --', 'selected' => $datos['Estcivil']['id'], 'label' => false, 'class'=>'form-control') );?></td>
						</tr>
						<tr>
							<td>Rut Conyuge</td>
							<td colspan="2">
								<?=$this->Form->hidden('Conyuge.beneficiario_id', array('default' => (isset($datos['Beneficiario']['id']) ? $datos['Beneficiario']['id'] : 0 )) );?>
								<?=$this->Form->hidden('Conyuge.id', array('default' => (isset($datos['Conyuge']['id']) ? $datos['Conyuge']['id'] : 0 )) );?>
								<?=$this->Form->input('Conyuge.rut', array('div'=>array('class'=>'col-md-2'), 'default' => (isset($datos['Conyuge']['rut']) ? $this->Funciones->formatoRut($datos['Conyuge']['rut']) : '---' ), 'label' => false, 'class' => 'resaltar form-control inputRut') );?>
							</td>
						</tr>
						<tr>
							<td>Nombre Conyuge</td>
							<td colspan="2">
								<?=$this->Form->input('Conyuge.nombres', array('div'=>array('class'=>'col-md-3'), 'default' => (isset($datos['Conyuge']['nombres']) ? trim($datos['Conyuge']['nombres']) : '---'), 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
								<?=$this->Form->input('Conyuge.apellidos', array('div'=>array('class'=>'col-md-3'), 'default' => (isset($datos['Conyuge']['apellidos']) ? trim($datos['Conyuge']['apellidos']) : '---'), 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
							</td>
						</tr>
						<tr>
							<td>Estado Civil Conyuge</td>
							<td colspan="2"><?=$this->Form->input('Conyuge.estcivil_id', array('div'=>array('class'=>'col-md-2'), 'options'=>$estados_civil, 'empty' =>'-- Seleccione --', 'selected' => $datos['Conyuge']['estcivil_id'], 'label' => false, 'class'=>'resaltar form-control') );?></td>
						</tr>
						<tr>
							<td>Servicio</td>
							<td colspan="2">
								<? $nombreServicio = ( isset($servicios[$datos['beneficiarios_servicio']['servicio_id']]) ? trim($servicios[$datos['beneficiarios_servicio']['servicio_id']]) : '');?>
								<?=$this->Form->hidden('beneficiario_servicio.servicio_id', array('default' => $datos['beneficiarios_servicio']['servicio_id']) );?>
								<?=$this->Form->input('beneficiario_servicio.nombre', array('div'=>array('class'=>'col-md-12'), 'type'=>'text', 'default' => $nombreServicio, 'label' => false, 'placeholder'=>'Digite un servicio', 'class' => 'resaltar form-control inputNombreServicio' ) );?>
							</td>
						</tr>
						<tr>
							<td>Casa Asignada</td>
							<td colspan="2">
								<?=$this->Form->input('Vivienda.direccion', array('div'=>array('class'=>'col-md-12'), 'default' => $casaAsignada, 'label' => false, 'class' => 'form-control inputNombreServicio readOnly', 'readonly '=>true) );?>
							</td>
						</tr>
						<tr>
							<td>Cumple Condicion</td>
							<td colspan="2">
									<div class="row">
											<div class="col-md-1 ">
													<?=$this->Form->radio('cumple', $optionsCumple, $attributesOptionCumple );?>
											</div>
									</div>
									<label style="font-size:12px; color:#1A18E0; ">Texto descriptivo explicativo refiriendose a que condiciones debe cumplir el beneficiario.</label>
							</td>
						</tr>
						<tr>
							<td>Escalafón</td>
							<td colspan="2">
								<?=$this->Funciones->msgValidacion($arrayConsume, 'escalafon', 'BeneficiarioEscalafon');?>
								<?=$this->Form->input('escalafon', array('div'=>array('class'=>'col-md-2'), 'options'=>$escalafon, 'empty' =>'-- Seleccione --', 'selected' => trim($datos['Beneficiario']['escalafon']), 'label' => false, 'class'=>'resaltar form-control') );?>
								<? //=$this->Form->input('Beneficiario.escalafon', array('div'=>array('class'=>'col-md-2'), 'default' => trim($datos['Beneficiario']['escalafon']), 'label' => false, 'class' => 'form-control inputRut') );?>
							</td>
						</tr>
						<tr>
							<td>Grado</td>
							<td colspan="2">
								<?=$this->Funciones->msgValidacion($arrayConsume, 'grado', 'BeneficiarioGrado');?>
								<?=$this->Form->input('grado', array('div'=>array('class'=>'col-md-1'), 'default' => trim($datos['Beneficiario']['grado']), 'label' => false, 'class' => 'resaltar form-control inputRut', 'min'=>'1', 'max'=>'20') );?>
							</td>
						</tr>
						<tr>
							<td>Sueldo Base $</td>
							<td colspan="2">
								<? //=$this->Form->input('Beneficiario.sueldo_base', array('div'=>array('class'=>'col-md-2'), 'type'=>'text', 'maxlength' => 10, 'default' => $funciones->formatoNum($datos['Beneficiario']['sueldo_base']), 'label' => false, 'class' => 'form-control inputRut') );?>
								<?=$this->Funciones->msgValidacion($arrayConsume, 'sueldo_base', 'BeneficiarioSueldoBase');?>
								<?//=( isset($arrayConsume['sueldo_base']) ? '<div class="form-group has-error"><label class="control-label" for="BeneficiarioSueldoBase">'.$arrayConsume['sueldo_base'][0].'</label>' : '')?>
								<!--	<div class="form-group has-error">
										<label class="control-label" for="BeneficiarioSueldoBase">< ?=$elMensaje;?></label>
									-->

								<?=$this->Form->input('sueldo_base', array('label' => false
													,'div'=>array('class'=>'col-sm-2 col-md-1')
												/*	, 'error' => false */
													, 'type'=>'text'
													, 'maxlength' => 10
													 /* , 'style' => array('width:7%; text-align: right;')*/
														, 'style' => array('text-align: right;')
													, 'value' => $funciones->formatoNum($datos['Beneficiario']['sueldo_base'])
													, 'class' => 'resaltar elForm-control inputRut form-control-danger'
												)
							 );
							 ?>


	<!-- 
				</div>
			<div class="form-group has-error">
				<label class="control-label" for="inputError1">Su informacíon and you suck</label>
				<input type="text" class="form-control" id="inputError1">
			</div>
								-->
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<? //=$this->Form->button('Guardar Cambios', array('class' => 'btn btn-primary inputRut') );?>
								<?=$this->Form->submit('Guardar Cambios', array('formnovalidate' => true, 'class' => 'btn btn-primary inputRut') );?>
							</td>
						</tr>
					</table>
				<?=$this->Form->end();?>  
			</div>
		</div>
	</div>

</div>

<script>
$(document).ready(function(){

	var losServicios = [<?=$this->Funciones->arrayJquery($servicios);?>];

	$( "#beneficiario_servicioNombre" ).autocomplete({ 
		source: losServicios,
		select: function( event, ui ) {
			$( "#beneficiario_servicioNombre" ).val( ui.item.label );
			$( "#beneficiario_servicioServicioId" ).val( ui.item.value );
			console.log( ui.item.value );
			return false;
			}
	});
	
	$("#BeneficiarioSueldoBase").keyup(function(){
		$(this).val( NumerosChile( $(this).val() ) );
	});

});
</script>



































