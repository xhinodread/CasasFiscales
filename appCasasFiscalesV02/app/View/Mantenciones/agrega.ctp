<?//=print_r($vivienda, 1);?>
<?//='<pre>'.print_r($mantencion_tipos, 1).'</pre>';?>
<?
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }			
?>
<style>

input:read-only { 
    background-color: yellow;
}

</style>
<div class="container-flex">

	<div class="row">
		<div class="col-md-3"><legend>Agregar Historial</legend></div>
  </div>
  
	<div class="row">
		<div class="col-md-11">
				<div class="table-responsiveDos">
					<div style="float:right; margin-bottom:20px; ">
						<?=$this->Html->link('Volver', '/viviendas/edita/id:'.trim($vivienda['Vivienda']['id']) , array('id'=>'btnNuevaAsignacion', 'class'=>'btn btn-primary') )?>
					</div>
					<?=$this->Form->Create('Mantencione', array('enctype' => 'multipart/form-data'));?>
						<table class="table table-bordered table-condensed table-responsive" >
							<tr>
								<td colspan="4">
								<?=$this->Form->hidden('Vivienda.id', array('default' => trim($vivienda['Vivienda']['id'])) );?>
								<?=$this->Form->input('Vivienda.rol', array('div'=>array('class'=>'col-md-2'),
																					 'type'=>'text',
																					 'default' => trim($vivienda['Vivienda']['rol']),
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
								<th>Fecha *</th>
								<th>Tipo *</th>
								<th>Observación *</th>
								<th>Documento (pdf) *</th>
							</tr>

							<tr>
								<td>
									<?=$this->Form->hidden('vivienda_id', array('default' => trim($vivienda['Vivienda']['id'])) );?>
									<?=$this->Form->input('fecha', array('label' => false,
																												'default' => date("d-m-Y"),
                                                        'type'  => 'text',
                                                        'class' => 'calendarioDisabled form-control form_control text-center',
																											  'style' => 'background-color: white;',
                                                        'required'    => 'required',
                                                        'placeholder' => 'Fecha de Creación',
                                                        'title'       => 'Seleccione Fecha de Creación',
                                                        'readonly'));
                  ?>
                  <label>Seleccione una fecha</label>
								</td>
								<td>
									<?=$this->Form->input('mantentipo_id', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																							 'label' => false,
																							 'options'=> $mantencion_tipos,
																							 'default' => 0,
																							 'class' => 'resaltar form-control inputRut',
																							 'style'=>"text-align: center;",
																							 ) );
									?>
								</td>
								<td>
									<?=$this->Form->input('observacion', array('div'=>array('class'=>'col-sm-12 col-md-12 col-lg-12'),
																												'label' => false,
                                                        'type'  => 'textarea',
                                                        'class' => 'resaltar form-control form_control',
                                                        'required'    => 'required',
                                                        'placeholder' => 'Descripción',
																												'style' => 'resize:none;'
																												));
                  ?>
								</td>
								<td>
									<?=$this->Form->input('documento', array('label' => false,
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
						<label><?=$this->Funciones->CampoRequerido;?></label>
					<?=$this->Form->button('Agregar', array('id'=>'agregar', 'type'  => 'submit', 'class' => 'btn btn-block btn-info form_control col-mx-12'));?>
					<?=$this->Form->end();?> 
				</div>
		</div>
	</div>

</div>
<script>
	$(document).ready(function(){
		
		var created=$('#MantencioneFecha'); 
		var options={
			format: 'dd-mm-yyyy',
			todayHighlight: true,
			autoclose: true,
			language: 'es'
		};
		created.datepicker(options);
		created.datepicker($.datepicker.regional['es']);
		
		$('#MantencioneDocumento').change(function(){
			var msxTamano = 2048;
			var f=this.files[0]
			var peso = (f.size||f.fileSize);
			if( Math.round(peso/1024) > msxTamano){
				alert('Tamaña de archivo no permitido, maximo 2MB');
				$('#agregar').attr('disabled', true);
				$("#MantencioneDocumento").val('');
			}else{
				$('#agregar').attr('disabled', false);
			}
		});
		
	})
</script>