<?
//echo "<pre>".print_r($this->viewVars['mesesApp'], 1)."</pre>";
$mesesApp = $this->viewVars['mesesApp'];
$aniosVista = array(date('Y')=>date('Y'), date('Y')-1=>date('Y')-1);
?>
<script type="text/javascript">
(function($){
	$(document).ready(function () {		
		
		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '< Ant',
			nextText: 'Sig >',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['es']);
		$( function() {	$( "#fecha_cta_cte" ).datepicker();	} );
		$( function() {	$( "#procesosFechaCtaCteSaldo" ).datepicker();	} );
		
		$( function() {
			$( "#dialog" ).dialog({
			  autoOpen: false,
			  //title: 'titulo para este',
			  width: 720,			 
			  show: {
				effect: "blind",
				duration: 1000
			  },
			  hide: {
				effect: "explode",
				duration: 1000				
			  },
			  beforeClose: function(event, ui){
					$("#btnRegistrarPago" ).prop( "disabled", false );
				}
			});
		});
		
		$( function() {
			$( "#dialogDetalle" ).dialog({
			  autoOpen: false,
			  //title: 'titulo para este',
			  width: 900,			 
			  show: {
				effect: "blind",
				duration: 1000
			  },
			  hide: {
				effect: "explode",
				duration: 1000
			  }
			});
		});
		
		$( "a" ).on( "click", function() {
			//console.log(this.id);
			if(this.id == 'opener'){
				$( "#dialog" ).dialog( "open" );
				$("#btnRegistrarPago" ).prop( "disabled", true );				
			}
			
			if(this.id == 'openerDetalle'){
				$( "#dialogDetalle" ).dialog( "open" );
				if ( $("#dialogDetalle").dialog("isOpen") == true ){
					 //Perform some operations;
					//console.log('isOpen');
					llamarDetallePago('33496');
				 }
			}
		});
		
		$("#btnRegistrarPago").click( function(){
			//console.log("click: "+$(location).attr('host'));
			//window.open('/procesos/registrarPago','reciboPago');
			window.open(urlServer+'/procesos/acuse_recibo', 'reciboPago');
		});
		
		$("#btnVerSgdoc").click( function(){
			var elExp = $("#nro_expediente").val();
			var nroExp = 'E14627/2016';
			//console.log(elExp.length);
			if( (elExp).length > 0 ) {
			//console.log("click: "+base_url);
				nroExp = elExp;
				$.ajax({
					method: "POST",
					dataType: "json",
					url: base_url+"procesos/verExpedientesgdoc",
					data: { nroExp: nroExp },
					beforeSend: function(){ 
						//console.log(nroExp);
					},
					success:(function(data){
						var htmlDetalleSgdoc = 'Sin info<br />Emisor: Sin info';
						if( data ){
							htmlDetalleSgdoc = data.materia+'<br />Emisor: '+data.emisor;
							//console.log('objeto');
							//console.log(data);
						}
						/*
						var cnt = 0; pnt = 0;
						$.each( data, function( key, value ) {
							if(cnt == 0){ pnt = key; }cnt++;
							console.log( key + ": " + value );
						});
						*/
						$("#lblDetalleSgdoc").html(htmlDetalleSgdoc);
					}),
					error: function(xhr) { // if error occured
						/// alert("Error occured.\n Please try again");
						$("#lblDetalleSgdoc").html('Ocurrio un error, no se pudo traer el dato.');
						console.log(xhr.responseText);
					}
				});
			}
			//window.open('/procesos/registrarPago','reciboPago');
			// window.open(urlServer+'/procesos/acuse_recibo', 'reciboPago');
		});
		
	});
})(jQuery);
</script>

<div class="row"> 
    <fieldset>
        <div style="float:right; margin-bottom:20px; ">
            <?=$this->Html->link('[+] Siguiente Canon', '/procesos/registrarPago', array('id'=>'nuevoCanon') )?>
            <br />
            <?=$this->Html->link('[->] Siguiente Vivienda', '/procesos/registrarPago', array('id'=>'nuevoCanon') )?>
        </div>
        
        <div class="col-md-11">
        <legend>Registro de pagos (canon)</legend>
        <!--<div style="margin:0 auto 20px;" >-->
          <!--<table style="width:90%;" border="1" cellpadding="0" cellspacing="0">-->
          <table class="table table-bordered table-condensed" >
              <tr>
                <td width="180"  >Rut Beneficiario</td>
                <td colspan="4">
                    <?=$form->input('rut_institucion', array('default' => "11.111.111-1", 'div'=>false, 'label' => false, 'readonly' =>true,'class' => 'form-control inputRut', 'placeholder'=>'11111111-1') );?>
                    <? //=$form->button('Buscar', array('div'=>false, 'class'=>'submit') );?>
                </td>
              </tr>
              <tr>
                <td>Nombre Beneficiario</td>
                <td colspan="4"><?=$form->input('nombre_beneficiario', array('default' => "Carmen Aida Ramirez Villarroel", 'label' => false, 'readonly' =>true, 'class' => 'form-control inputNombreServicio') );?></td>
              </tr>
              <tr>
                <td>Servicio</td>
                <td colspan="4"><?=$form->input('nombre_servicio', array('default' => "Corporación administrativa del Poder Judicial", 'label' => false, 'readonly' =>true, 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Rol Vivienda</td>
                <td colspan="3"><?=$form->input('rol_vivienda', array('default' => "0229493-056", 'label' => false, 'readonly' =>true, 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Direccion Vivienda</td>
                <td colspan="1"><?=$form->input('direccion_vivienda', array('default' => "Arturo Prat Nro. 350", 'label' => false, 'readonly' =>true, 'class' => 'form-control inputNombreServicio') );?></td>
                <td>Monto mensual (10%) $</td>
                <td class="inputMontos"><label class="form-control" style="border:inset; width:80px">31.322.-</label></td>
              </tr>
              <tr>
                <td>Nro. Expediente</td>
                <td width="526">
                    <?=$form->input('nro_expediente', array('div'=>array('class' =>'col-md-3'), 'default' => "", 'label' => false, 'class' => 'form-control inputRut inputMontos', 'placeholder'=>'E000/YYYY') );?>
                    <? //=$form->button('Ver en SGDOC', array('type'=>'button', 'id'=>'btnVerSgdoc', 'class' =>'button_' ) );?>
                    <?=$form->button('Ver en SGDOC', array('type'=>'button', 'id'=>'btnVerSgdoc', 'class' =>'btn btn-primary' ) );?>
                    <label id="lblDetalleSgdoc" style="border:inset; font-size:12px; margin:8px 0 1px 0; "></label>
                </td>
                <td width="250">Monto de pago de Arriendo $</td>
                <td width="343"><?=$form->input('monto_arriendo', array('default' => "31.322", 'label' => false, 'div'=>array('class' =>'col-md-3'), 'class' => 'form-control', 'placeholder'=>'12345') );?></td>
              </tr>
              <tr>
                <td>Fecha Ingreso Cta. Cte.</td>
                <td>
                    <?=$this->Form->input('fecha_cta_cte', array('div'=>array('class' =>'col-md-3'), 'label' => false, 'readonly' =>true, 'class' => 'form-control', 'placeholder'=>'01/01/2017' ) );?>
                </td>
                <td>Periodo de Pago</td>
                <td>
                    <?=$form->input('anio_pago',array( 'div'=>array('class' =>'col-md-4'), 'label' => false, 'options' => $aniosVista, 'empty' => '--Año--', 'selected' => date('Y')-1, 'class' => 'form-control _inputMontos') );?>
                    <?=$form->input('mes_pago', array( 'div'=>array('class' =>'col-md-5'), 'label' => false, 'options' => $mesesApp, 'empty' => '--Seleccione--', 'selected' => 10, 'class' => 'form-control _inputMontos') );?>
                </td>
              </tr>
              <tr>
                <td>Tipo documento</td>
                <td><?=$form->input('tipo_doc', array('div'=>array('class' =>'col-md-3'), 'label' => false, 'options' => $tipoDoctosApp, 'empty' => '--Seleccione--', 'selected' =>1, 'class' => 'form-control _inputMontos') );?></td>
                <td>Nº cheque, transferencia o depósito</td>
                <td><?=$form->input('nro_doc_pago', array('div'=>array('class' =>'col-md-4'), 'default' => "", 'label' => false, 'class' => 'form-control inputMontos', 'placeholder'=>'1234567') );?></td>
              </tr>
              <tr>
                <td>Documento de Respaldo (pdf)</td>
                <td colspan="3"><?=$form->input('cumple_condicion_benef', array('type'=>'file', 'label'=>false, 'class' =>'btn btn-primary' ));?></td>
              </tr>
              <tr>
                <td colspan="5"><?=$form->button('Registrar Pago', array('id'=>'btnRegistrarPago', 'class' =>'btn btn-primary' ) );?></td>
              </tr>
            </table>
        </div>
    </fieldset>
</div>

<div class="row"> 
<fieldset>  
    <div class="col-md-11">
    <legend class="text-center" >Historico de Pagos</legend>
        <!--<table width="0" border="0">-->
        <table class="table table-bordered table-condensed table-hover" >
          <tr>
            <th>Nro. Expediente</th>
            <th>Monto de Transacción</th>
            <th>Fecha Ingreso Cta. Cte.</th>
            <th>Fecha de Vencimiento</th>
            <th>Mes Pagado</th>
            <th>Nº cheque, <br />transferencia o depósito</th>
            <th>Tipo documento</th>
            <th>Fecha de Registro<br /><label style="font-size:9px;">Fecha de Ingreso Cta. Cte. o Fecha del sistema</label></th>
            <th>Estado Pago</th>
          </tr>
          <tr class="danger" >
            <td class="textoCentro" >---</td>
            <td class="inputMontos" > $ 0.- </td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >20-01-2017</td>
            <td class="textoCentro" >Enero 2017</td>
            <td class="inputMontos" >---</td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >---</td>
            <td class="danger" >Moroso</td>
          </tr>
          <tr class="danger" >
            <td class="textoCentro" >---</td>
            <td class="inputMontos" > $ 0.- </td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >20-12-2016</td>
            <td class="textoCentro" >Diciembre 2016</td>
            <td class="inputMontos" >---</td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >---</td>
            <td class="danger" >Moroso</td>
          </tr>
          <tr class="danger">
            <td class="textoCentro" >---</td>
            <td class="inputMontos" > $ 0.- </td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >20-11-2016</td>
            <td class="textoCentro" >Noviembre 2016</td>
            <td class="inputMontos" >---</td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >---</td>
            <td class="danger" >Moroso</td>
          </tr>
          <tr class="danger" >
            <td class="textoCentro" >---</td>
            <td class="inputMontos" > $ 0.- </td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >20-10-2016</td>
            <td class="textoCentro" >Octubre 2016</td>
            <td class="inputMontos" >---</td>
            <td class="textoCentro" >---</td>
            <td class="textoCentro" >---</td>
            <td class="danger" >Moroso</td>
          </tr>
          <tr>
            <td class="textoCentro" >E13560/2016</td>
            <td class="inputMontos" > $ 31.322.- </td>
            <td class="textoCentro" >17-10-2016</td>
            <td class="textoCentro" >20-09-2016</td>
            <td class="textoCentro" >Septiembre 2016</td>
            <td class="inputMontos" >7034875</td>
            <td class="textoCentro" >Deposito<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a> </td>
            <td class="textoCentro" >18-10-2016</td>
            <td class="textoCentro" >Pagado</td>
          </tr>
          <tr>
            <td class="textoCentro" >E13559/2016</td>
            <td class="inputMontos" > $ 21.322.- </td>
            <td class="textoCentro" >17-09-2016</td>
            <td class="textoCentro" >20-08-2016</td>
            <td class="textoCentro" >Agosto 2016</td>
            <td class="inputMontos" >7034848</td>
            <td class="textoCentro" >Transferencia<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-09-2016</td>
            <td class="textoCentro">
            	Saldo en contra $ -10.000.- <br />
                <a href="#SaldarDeuda1" id="opener" title="Saldo en contra $ -10.000.-" class="btn btn-warning" >Saldar Deuda</a>
                <a name="SaldarDeuda1" id="SaldarDeuda1"></a>
            </td>
          </tr>
          <tr>
            <td class="textoCentro" >E96543/2016</td>
            <td class="inputMontos" > $ 31.322.- </td>
            <td class="textoCentro" >17-08-2016</td>
            <td class="textoCentro" >20-07-2016</td>
            <td class="textoCentro" >Julio 2016</td>
            <td class="inputMontos" >9882871</td>
            <td class="textoCentro" >Deposito<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-08-2016</td>
            <td class="textoCentro" >Pagado</td>
          </tr>
          <tr>
            <td class="textoCentro" >E55484/2016</td>
            <td class="inputMontos" > $ 31.322.- </td>
            <td class="textoCentro" >17-07-2016</td>
            <td class="textoCentro" >20-06-2016</td>
            <td class="textoCentro" >Junio 2016</td>
            <td class="inputMontos" >5645656</td>
            <td class="textoCentro" >Deposito<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-07-2016</td>
            <td class="textoCentro" >Pagado</td>
          </tr>
          <tr>
            <td class="textoCentro" >E33496/2016</td>
            <td class="inputMontos" > $ 31.322.- </td>
            <td class="textoCentro" >17-06-2016</td>
            <td class="textoCentro" >20-05-2016</td>
            <td class="textoCentro" >Mayo 2016</td>
            <td class="inputMontos" >5466544</td>
            <td class="textoCentro" >Deposito<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-06-2016</td>
            <td class="textoCentro" >
            	Pagado<br />
            	<a href="#VerDetalle1" id="openerDetalle" class="btn btn-primary">Ver Detalle</a>
                <a name="VerDetalle1" id="VerDetalle1"></a>
            </td>
          </tr>
          <tr class="success" >
            <td class="textoCentro" >E12848/2016</td>
            <td class="inputMontos" > $ 41.322.- <strong>Pagado:</strong>$ 31.322.- </td>
            <td class="textoCentro" >17-05-2016</td>
            <td class="textoCentro" >20-04-2016</td>
            <td class="textoCentro" >Abril 2016</td>
            <td class="inputMontos" >6541653</td>
            <td class="textoCentro" >Cheque<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-05-2016</td>
            <td class="textoCentro" >Saldo a favor $ 10.000.-</td>
          </tr>
          <tr>
            <td class="textoCentro" >E355/2016</td>
            <td class="inputMontos" > $ 31.322.- </td>
            <td class="textoCentro" >17-04-2016</td>
            <td class="textoCentro" >20-03-2016</td>
            <td class="textoCentro" >Marzo 2016</td>
            <td class="inputMontos" >9846574</td>
            <td class="textoCentro" >Deposito<br /><a href="#" id="openerVerDoc" title="Deposito" class="btn btn-info" >Ver Documento de Respaldo</a></td>
            <td class="textoCentro" >18-04-2016</td>
            <td class="textoCentro" >Pagado</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
	</div>
</fieldset>
</div>

<div id="dialog" title="Saldar Deuda" >
	<h1 style="color:#F00;">Saldo en contra $ -10.000.- </h1>
    <?=$this->Form->create('procesos', array('action' =>'saldarDeuda') );?>
    <?=$form->hidden('id_vivienda', array('default' => "123") );?>
    <?=$form->hidden('id_veneficiario', array('default' => "321") );?>
    <table style="width:99%;" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td>Nro. Expediente</td>
        <td width="274"><?=$form->input('nro_expediente_saldo', array('default' => "", 'label' => false, 'class' => 'inputRut inputMontos', 'placeholder'=>'E000/YYYY') );?></td>
        <td width="207">Monto Arriendo $</td>
        <td width="952"><?=$form->input('monto_arriendo_saldo', array('default' => "10.000", 'label' => false, 'readonly' =>true, 'class' => 'inputMontos', 'placeholder'=>'12345') );?></td>
      </tr>
      <tr>
        <td>Fecha Ingreso Cta. Cte.</td>
        <td>
            <? //=$form->input('fecha_cta_cte2', array('default' => "", 'label' => false, 'class' => 'inputRut') );?>
            <?=$this->Form->input('fecha_cta_cte_saldo', array('div' => false,  'label' => false, 'readonly' =>true, 'style' =>'width:110px; text-align:center;', 'placeholder'=> date('d/m/Y') ) );?>
        </td>
        <td>Mes de Pago</td>
        <td>
            <?=$form->input('mes_pago_saldo', array( 'div' => false, 'label' => false, 'options' => array(8=>$mesesApp[8]), 'class' => '_inputMontos') );?>
            <?=$form->input('anio_pago_saldo',array( 'div' => false, 'label' => false, 'options' => array(2016 =>2016) , 'class' => '_inputMontos') );?>
        </td>
      </tr>
      <tr>
        <td>Nº cheque, transferencia o depósito</td>
        <td><?=$form->input('nro_doc_pago_saldo', array('default' => "", 'label' => false, 'class' => 'inputMontos', 'placeholder'=>'1234567') );?></td>
        <td>Tipo documento</td>
        <td><?=$form->input('tipo_doc_saldo', array('div' => false, 'label' => false, 'options' => $tipoDoctosApp, 'selected' =>3, 'empty' => '--Seleccione--', 'class' => '_inputMontos') );?></td>
      </tr>
    </table>
    <?= $this->Form->end('Registrar Pago' );?>
</div>

<div id="dialogDetalle" title="Detalle de Pago" >
  <table width="0" border="0" class="tablaDetallePago" id="tablaDetallePagos">
    <tr>
      <th scope="col">Nro. Expediente</th>
      <th scope="col">Monto pagado</th>
      <th scope="col">Fecha Ingreso Cta. Cte.</th>
      <th scope="col">Fecha de Vencimiento</th>
      <th scope="col">Mes Pagado</th>
      <th scope="col">Nº cheque, <br />transferencia o depósito</th>
      <th scope="col">Tipo documento</th>
      <th scope="col">Fecha de Registro</th>
    </tr>
  </table>
</div>