<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
//$optionsCumple=array('1'=>'Si Cumple','0'=>'No Cumple');
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }						

//echo '<pre class="little">arrayConsume:'.print_r($arrayConsume, 1).'</pre>';
//echo '<pre class="little">losValidates:'.print_r($this->Session->consume('losValidates'), 1).'</pre>';
// echo '<pre class="little">this:'.print_r($datos, 1).'</pre>';
// echo '<pre class="little">estados_civil:'.print_r($estados_civil, 1).'</pre>';
// echo '<pre>datos:'.print_r($datos, 1).'</pre>';
?>

<div class="container-flex">

    <div class="row">
			<div class="col-md-3"><legend>Administración de Servicio</legend></div>
    </div>
    
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/servicios/agrega', array('class'=>'btn btn-primary') )?></div>
    	</div>
    </div>
    
    <div class="row">
        <div class="col-md-11">
            <div class="table-responsiveDos">
							<?=$this->Form->Create('Servicio');?>
								<table class="table table-bordered table-condensed" >
									<tr>
										<td width="128" style="width:100px;" >Rut</td>
                        <td colspan="2" >
                        	<?=$this->Form->hidden('Servicio.id', array('default' => $datos['Servicio']['id']) );?>
													<?=$this->Form->input('Servicio.rut', array('div'=>array('class'=>'col-md-2'),
																				 'type'=>'text',
																				 /*** 'default' => $funciones->formatoNum($datos['Servicio']['rut']), ***/
																				 'default' => trim($datos['Servicio']['rut']),
																				 'label' => false,
																				 'class' => 'form-control inputRut',
																				 'maxlength' => 12,
																				 'readonly'=>'readonly') );
													?>
                      	</td>
									</tr>
									<tr>
										<td>Nombre</td>
										<td colspan="2">
											<?=$this->Form->input('nombre', array('div'=>array('class'=>'col-md-12'), 
																														'default' => trim($datos['Servicio']['nombre']),
																														'label' => false, 'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td>Sigla</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'siglas', 'ServicioSiglas');?>
											<?=$this->Form->input('siglas', array('div'=>array('class'=>'col-md-2'), 
																														'default' => trim($datos['Servicio']['siglas']),
																														'label' => false,
																														'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td>Jefe del servicio</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'jefe_servicio', 'ServicioJefeServicio');?>
											<?=$this->Form->input('jefe_servicio', array('div'=>array('class'=>'col-md-12'), 
																															'default' => trim($datos['Servicio']['jefe_servicio']),
																															'label' => false,
																															'class' => 'resaltar form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td>Subrogante</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'subrogante', 'ServicioSubrogante');?>
											<?=$this->Form->input('subrogante', array('div'=>array('class'=>'col-md-12'), 
																															'default' => trim($datos['Servicio']['subrogante']),
																															'label' => false,
																															'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>  
									<tr>
										<td>Dirección</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'direccion', 'ServicioDireccion');?>
											<?=$this->Form->input('direccion', array('div'=>array('class'=>'col-md-12'), 
																														'default' => trim($datos['Servicio']['direccion']),
																														'label' => false,
																														'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td>Teléfono</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'telefonos', 'ServicioTelefonos');?>
											<?=$this->Form->input('telefonos', array('div'=>array('class'=>'col-md-12'), 
																														'default' => trim($datos['Servicio']['telefonos']),
																														'label' => false,
																														'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td>E-mail</td>
										<td colspan="2">
											<?=$this->Funciones->msgValidacion($arrayConsume, 'email', 'ServicioEmail');?>
											<?=$this->Form->input('email', array('div'=>array('class'=>'col-md-12'), 
																														'default' => trim($datos['Servicio']['email']),
																														'label' => false,
																														'class' => 'resaltar form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td colspan="3"><?=$this->Form->submit('Guardar Cambios', array('formnovalidate' => true, 'class' => 'btn btn-primary inputRut') );?></td>
									</tr>
								</table>
							<?=$this->Form->end();?>       
						</div>
        </div>
    </div>
    
    
</div>