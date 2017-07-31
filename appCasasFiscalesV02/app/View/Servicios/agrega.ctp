<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
//$optionsCumple=array('1'=>'Si Cumple','0'=>'No Cumple');
//$elMensaje=''; $arrayConsume='';
//if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }						
									
// echo '<pre class="little">this:'.print_r($datos, 1).'</pre>';
// echo '<pre class="little">estados_civil:'.print_r($estados_civil, 1).'</pre>';
// echo '<pre>datos:'.print_r($datos, 1).'</pre>';
?>

<div class="container-flex">

	<div class="row">
		<div class="col-md-3"><legend>Agregar Servicio</legend></div>
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
										<td style="width:100px;" >Rut</td>
										<td >
											<?=$this->Form->input('Servicio.rut', array('div'=>array('class'=>'col-md-2'),
																		 'type'=>'text',
																		 /*** 'default' => $funciones->formatoNum($datos['Servicio']['rut']), ***/
																		 'default' => '',
																		 'label' => false,
																		 'class' => 'form-control inputRut',
																		 'placeholder' =>'11.111.111-1',
																		 'maxlength' => 12) );
											?>
										</td>
									</tr>
									<tr>
										<td>Nombre</td>
										<td>
											<?=$this->Form->input('nombre', array('div'=>array('class'=>'col-md-12'), 
																														'default' => '', 'placeholder' =>'Nombre del Servicio',
																														'label' => false, 'class' => 'form-control inputNombre') );
											?>
										</td>
									</tr>
									<tr>
										<td>Sigla</td>
										<td>
												<?=$this->Form->input('siglas', array('div'=>array('class'=>'col-md-2'), 
																															'default' => '', 'placeholder' =>'ABC',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td>Jefe del servicio</td>
										<td>
											<?=$this->Form->input('jefe_servicio', array('div'=>array('class'=>'col-md-12'), 
																															'default' => '', 'placeholder' =>'Nombre del Jefe del Servicio',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td>Subrogante</td>
										<td>
											<?=$this->Form->input('subrogante', array('div'=>array('class'=>'col-md-12'), 
																															'default' => '', 'placeholder' =>'Nombre del Jefe Subrogante del Servicio',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
											?>
										</td>
									</tr>  
									<tr>
										<td>Dirección</td>
										<td>
												<?=$this->Form->input('direccion', array('div'=>array('class'=>'col-md-12'), 
																															'default' => '', 'placeholder' =>'Calle n° 2',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td>Teléfono</td>
										<td>
												<?=$this->Form->input('telefonos', array('div'=>array('class'=>'col-md-12'), 
																															'default' => '', 'placeholder' =>'512 207200 - 97854615',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td>E-mail</td>
										<td>
												<?=$this->Form->input('email', array('div'=>array('class'=>'col-md-12'), 
																															'default' => '', 'placeholder' =>'soporte@gorecoquimbo.cl',
																															'label' => false,
																															'class' => 'form-control inputNombre') );
												?>
										</td>
									</tr>
									<tr>
										<td colspan="2">
											<?=$this->Form->button('Guardar Cambios', array( 'id'=>'subMit', 'class' => 'btn btn-primary inputRut', 'disabled'=>'disabled') );?>
										</td>
									</tr>
								</table>
							<?=$this->Form->end();?>       
						</div>
        </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
	$( "#ServicioRut" ).keyup(function(e) {
		if( $(this).val().length >=11 && $(this).val().length <= 12  ){
			//console.log( evalua_formato_rut($(this).val()) );
			if( !evalua_formato_rut($(this).val()) ){ $("#subMit").attr("disabled",true); $(this).css("background-color","red"); return; }
			//console.log( evalua_rut_no_permitidos($(this).val()) );
			if( evalua_rut_no_permitidos($(this).val()) >= 0){ $("#subMit").attr("disabled",true); $(this).css("background-color","red"); return; }
			//console.log(Valida_Rut( $(this) ))
			if( Valida_Rut( $(this) ) ){ $("#subMit").attr("disabled",false); $(this).css("background-color","white"); }
			else{ $("#subMit").attr("disabled",true); $(this).css("background-color","red"); }
		}else{
			$("#subMit").attr("disabled",true);
			$(this).css("background-color","white");
		}
		return;
	});
});
</script>