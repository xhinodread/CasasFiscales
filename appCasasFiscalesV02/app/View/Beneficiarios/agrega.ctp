<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
$optionsCumple=array('1'=>'Si Cumple','0'=>'No Cumple');
$attributesOptionCumple=array('legend'=>false, 'default' => 0, 'div'=>true, 'separator'=> '</div><div class="col-md-2 " >' );
$elMensaje=''; $arrayConsume='';
if( $this->Session->check('losValidates') ) { $arrayConsume = $this->Session->consume('losValidates'); }						
// echo '<pre class="little">arrayConsume:'.print_r($arrayConsume, 1).'</pre>';
?>
<div class="container-flex">

    <div class="row">
		<div class="col-md-3">
   			<legend>Agregar Beneficiario</legend>
   		</div>
    </div>

	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/beneficiarios/agrega', array('class'=>'btn btn-primary') )?></div>
    	</div>
    </div>
    
    <div class="row">
        <div class="col-md-11">
            <div class="table-responsiveDos">
				<?=$this->Form->Create('');?>
                    <table class="table table-bordered table-condensed" >
                      <tr>
                        <td width="128" style="width:100px;" >Rut *</td>
                        <td colspan="2" >
							<?=$this->Form->input('Beneficiario.rut', array('div'=>array('class'=>'col-md-2'),
																	  'type'=>'text',
																	  'default' => '', 'label' => false,
																	  'class' => 'resaltar form-control inputRut',
																	  'placeholder' =>'Rut sin punto ni guion.',
																	  'maxlength' => 12,
																		'autocomplete'=>"off", ) );?>
                     		Rut sin punto ni guion.
                      	</td>
                      </tr>
                      <tr>
                        <td>Nombre *</td>
                        <td colspan="2">
													<?=$this->Form->input('Beneficiario.nombres', array('div'=>array('class'=>'col-md-3'), 
														'default' => '',
														'placeholder' =>'Juan Patricio',
														'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
																			<?=$this->Form->input('Beneficiario.paterno', array('div'=>array('class'=>'col-md-3'), 
														'default' => '',
														'placeholder' =>'Pérez',
														'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
													<?=$this->Form->input('Beneficiario.materno', array('div'=>array('class'=>'col-md-3'), 
														'default' => '',
														'placeholder' =>'Pérez',
														'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
                        </td>
                      </tr>
                      <tr>
                        <td>Telefono *</td>
                        <td colspan="2"><?=$this->Form->input('Beneficiario.celular', array('div'=>array('class'=>'col-md-2'), 'default' => '', 'placeholder' =>'512 207200 - 97854615', 'label' => false, 'class' => 'resaltar form-control inputNombre') );?></td>
                      </tr>
                      <tr>
                        <td>E-Mail *</td>
                        <td colspan="2"><?=$this->Form->input('Beneficiario.email', array('div'=>array('class'=>'col-md-3'), 'default' => '', 'placeholder' =>'soporte@gorecoquimbo.cl', 'label' => false, 'class' => 'resaltar form-control inputNombre') );?></td>
                      </tr>
                      <tr>
                        <td>Estado Civil *</td>
                        <td colspan="2"><?=$this->Form->input('Beneficiario.estcivil_id', array('div'=>array('class'=>'col-md-2'), 'options'=>$estados_civil, 'empty' =>'-- Seleccione --', 'selected' => 0, 'label' => false, 'class'=>'resaltar form-control') );?></td>
                      </tr>
                      <tr>
                        <td>Rut Conyuge</td>
                        <td colspan="2"><?=$this->Form->input('Conyuge.rut', array('div'=>array('class'=>'col-md-2'), 'default' => "", 'placeholder' =>'Rut sin punto ni guion.', 'label' => false, 'class' => 'resaltar form-control inputRut', 'autocomplete'=>"off" ) );?></td>
                      </tr>
                      <tr>
                        <td>Nombre Conyuge</td>
                        <td colspan="2">
                        	<?=$this->Form->input('Conyuge.nombres', array('div'=>array('class'=>'col-md-3'), 'default' => "", 'placeholder' =>'Juanita Eleonor', 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
                        	<?=$this->Form->input('Conyuge.apellidos', array('div'=>array('class'=>'col-md-3'), 'default' => '', 'placeholder' =>'Pérez Garcia', 'label' => false, 'class' => 'resaltar form-control inputNombre') );?>
                        </td>
                      </tr>
                      <tr>
                        <td>Estado Civil Conyuge</td>
                        <td colspan="2"><?=$this->Form->input('Conyuge.estcivil_id', array('div'=>array('class'=>'col-md-2'), 'options'=>$estados_civil, 'empty' =>'-- Seleccione --', 'selected' => 0, 'label' => false, 'class'=>'resaltar form-control') );?></td>
                      </tr>
                      <tr>
                        <td>Servicio</td>
                        <td colspan="2">
                        	<?=$this->Form->hidden('beneficiario_servicio.servicio_id', array('default' => 0) );?>
                        	<?=$this->Form->input('beneficiario_servicio.nombre', array('div'=>array('class'=>'col-md-12'), 'type'=>'text', 'default' => '', 'label' => false, 'placeholder'=>'Digite un servicio', 'class' => 'resaltar form-control inputNombreServicio' ) );?>
                        	
                        	<?//=$this->Form->input('Servicio.nombre', array('div'=>array('class'=>'col-md-12'), 'default' => '', 'label' => false, 'class' => 'form-control inputNombreServicio' ) );?>
                        </td>
                      </tr>
                      <? if(0){ ?>
                       <tr>
                        <td>Casa Asignada</td>
                        <td colspan="2"><?=$this->Form->input('Vivienda.direccion', array('div'=>array('class'=>'col-md-12'), 'default' => '', 'label' => false, 'class' => 'form-control inputNombreServicio readOnly', 'readonly '=>true) );?></td>
                      </tr>
                      <? }else{ echo $this->Form->hidden('Vivienda.direccion', array('div'=>array('class'=>'col-md-12'), 'default' => '', 'label' => false, 'class' => 'form-control inputNombreServicio readOnly', 'readonly '=>true) );} ?>
                      <tr>
                        <td>Cumple Condicion *</td>
                        <td colspan="2">
                            <div class="row">
                                <div class="col-md-1 ">
                                    <?=$this->Form->radio('Beneficiario.cumple', $optionsCumple, $attributesOptionCumple );?>
                                </div>
                            </div>
                            <label style="font-size:12px; color:#900; ">Texto descriptivo explicativo refiriendose a que condiciones debe cumplir el beneficiario.</label>
                        </td>
                      </tr>
                      <tr>
                        <td>Escalafón *</td>
                        <td colspan="2">
                        <?=$this->Form->input('Beneficiario.escalafon', array('div'=>array('class'=>'col-md-2'), 'options'=>$escalafon, 'empty' =>'-- Seleccione --', 'selected' => 0, 'label' => false, 'class'=>'resaltar form-control') );?>
                        <? //=$this->Form->input('Beneficiario.escalafon', array('div'=>array('class'=>'col-md-2'), 'default' => '', 'placeholder' =>'Honorario', 'label' => false, 'class' => 'form-control inputRut') );?></td>
                      </tr>
                      <tr>
                        <td>Grado *</td>
                        <td colspan="2"><?=$this->Form->input('Beneficiario.grado', array('div'=>array('class'=>'col-md-1'), 'default' => '', 'placeholder' =>'0', 'label' => false, 'class' => 'resaltar form-control inputRut', 'min'=>'1', 'max'=>'20' ) );?></td>
                      </tr>
                      <tr>
                        <td>Sueldo Base $ *</td>
                        <td colspan="2">
                        	<? // =$this->Form->input('Beneficiario.sueldo_base', array('div'=>array('class'=>'col-md-2'), 'default' => 0, 'placeholder' =>'1.111.111', 'label' => false, 'class' => 'form-control inputRut') );?>
                        	<?=$this->Form->input('sueldo_base', array('label' => false
																		,'div'=>array('class'=>'col-sm-2 col-md-1')
																		, 'type'=>'text'
																	  , 'placeholder' =>'1.111.111'
																		, 'maxlength' => 20
																	  , 'style' => array('text-align: right;')
																		, 'class' => 'resaltar elForm-control inputRut form-control-danger'
																	) 
												 );								
							?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3">
                        	<div><label><?=$this->Funciones->CampoRequerido;?></label></div>
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
$( document ).ready(function(){
	
	$("#BeneficiarioRut").keyup(function(e){
		// var elValorXd = $(this).val().replace(/\b\d{1,8}\-[K|k|0-9]/gi, '$1' );
		//var elValorXd = $(this).val().replace( /(\d{3}(?!\d?$))\.?/g, '$1.' );

	  /****	/(\d{1,2})\-?(\d{3})\-?(\d{3})/  **** /
		var elValorTexto = $(this).val();
		//var elValorXd = $(this).val().replace( /(\d{3})\-?(\d{3})\-?(\d{3})/, '$1.$2.$3' );
		var elValorXdDos, elValorXd = $(this).val().replace( /(\d{1,2})\-?(\d{3})\-?(\d{3})/, '$1.$2.$3' );
		//console.log(elValorTexto.length );
		//console.log(elValorXd);
		//$(this).val( elValorXd );
		
		if( $(this).val().length >=10 && $(this).val().length <=12  ){
			//console.log("nuevo");
			//console.log(elValorTexto.length );
			var elDv = elValorXd.substring(elValorTexto.length-1);
			elValorXd = elValorXd.substring(0, elValorTexto.length-1);
			/*** elValorXd = elValorXd.replace( /(\d{3})\-?(\d{3})\-?(\d{3})/, '$1.$2.$3' ) + '-' + elDv; *** /
			elValorXd += '-' + elDv;			
			if( $(this).val().length == 12 ){
				elValorXd = elValorXd.replace( /-/m, '' );
				// elValorXdDos = elValorXd.substring(0, elValorTexto.length-2).replace( /(\d{3})\-?(\d{3})\-?(\d{3})/, '$1.$2.$3' );
				//elValorXd = elValorXd.replace( /./m, '' );
				elValorXd = NumerosChile(elValorXd)+ '-' + elDv; ;
			}
			//console.log( elDv );
			//console.log(elValorXd);
			//console.log(elValorXdDos);
		}
		****/
		$(this).val( formateaRut( $(this).val() ) );
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
	
	$("#BeneficiarioSueldoBase").keyup(function(){ $(this).val( NumerosChile( $(this).val() ) ); });
	
	$("#ConyugeRut").keyup(function(e){
		$(this).val( formateaRut( $(this).val() ) );
		if( $(this).val().length >=11 && $(this).val().length <= 12  ){
			if( !evalua_formato_rut($(this).val()) ){ $("#subMit").attr("disabled",true); $(this).css("background-color","red"); return; }
			if( evalua_rut_no_permitidos($(this).val()) >= 0){ $("#subMit").attr("disabled",true); $(this).css("background-color","red"); return; }
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
