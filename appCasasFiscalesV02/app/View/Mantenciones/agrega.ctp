<?
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }			
?>
<div class="container-flex">

	<div class="row">
		<div class="col-md-3"><legend>Agregar Historial</legend></div>
  </div>
  
	<div class="row">
		<div class="col-md-11">
				<div class="table-responsiveDos">
					<?=$this->Form->Create('Mantencione');?>
						<table class="table table-bordered table-condensed table-responsive" >
							<tr>
								<td >
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
								<td colspan="2">
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
							
						</table>
					<?=$this->Form->end();?> 
				</div>
		</div>
	</div>
						  


</div>