
<script type="text/javascript">
	$(document).ready(function () {
		//alert('JQuery is succesfully included');
	});

	function mantencionHistorial(){
		 $.ajax({
			type: 'POST',
			url: 'index',
			data: 'e=1',
			success: function(data,textStatus,xhr){
					//alert(data);
					$('#layoutJs').innerHtml = data;
			},
			error: function(xhr,textStatus,error){
					alert(textStatus);
			}
		});	
	}
</script>
<?=$this->Html->script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", false); ?>
<?=$this->Html->script("http://maps.google.com/maps/api/js?sensor=false", false); ?>

<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nueva', '/viviendas/admin')?></div>
<div>
    <fieldset>
        <legend>Administración de Viviendas</legend>
        <div style="margin:0 auto 20px;" >
            <?
                $path_docs_historial = '../files/docs_historial/';
                
                $optionSelectComuna = array('La Serena', 'Los Vilos', 'Ovalle');
                $optionSelectProvincia = array('Elqui', 'Limari', 'Choapa');
                $optionSelectAdministrador = array('Gobernador', 'Gore', 'B.B.N.N.');
                $direccion['calle'] = 'Arturo Prat';
                $direccion['nro'] = '350';
                $sector = 'centro';
                $referencia = 'Frente a la plaza de armas.';
                
                $latitud = -29.902087;
                $longitud = -71.251971;
                  // Override any of the following default options to customize your map 
                $map_options = array(
                    "id"           => "map_canvas",
                    "width"        => "400px",
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
                    "windowText"   => $direccion['calle'].' '.$direccion['nro']."<br>Lat:".$latitud."<br>Lon:".$longitud
                  );
                  $map_marker_options = array(
                    "showWindow"   => true,
                    "windowText"   => $direccion['calle'].' '.$direccion['nro']."<br>Lat:".$latitud."<br>Lon:".$longitud,
                    "markerTitle"  => $direccion['calle'].' '.$direccion['nro'],
                    /*"markerIcon"   => "http://labs.google.com/ridefinder/images/mm_20_purple.png",
                    "markerShadow" => "http://labs.google.com/ridefinder/images/mm_20_purpleshadow.png"*/
                  );
            ?>
            <!-- <table style="width:90%; margin:0 auto;" border="1" cellpadding="0" cellspacing="0"> -->
            <table class="table table-bordered table-condensed" >
              <tr>
                <td width="118" style="width:100px;" >Rol</td>
                <td colspan="2" ><?=$form->input('rol', array('div'=>array('class'=>'col-md-2'), 'default' => '0229493-056', 'label' => false, 'class' => 'form-control text-center') );?></td>
              </tr>
              <tr>
                <td>Dirección</td>
                <td>
                    <?=$form->input('calle', array('div'=>array('class'=>'col-md-6'), 'default' => $direccion['calle'], 'class' => 'form-control' ) );?>
                    <?=$form->input('numero', array('div'=>array('class'=>'col-md-2'), 'default' => $direccion['nro'], 'class' => 'form-control text-center' ) );?>
                </td>
                <td>
                    <?=$form->input('sector', array('div'=>array('class'=>'col-md-4'), 'default' => $sector, 'label' => 'Sector', 'class' => 'form-control' ) );?>
                    <?=$form->input('block', array('div'=>array('class'=>'col-md-3'), 'default' => '', 'class' => 'form-control' ) );?>
                    <?=$form->input('departamento', array('div'=>array('class'=>'col-md-3'), 'default' => '', 'class' => 'form-control' ) );?>
                </td>
              </tr>
              <tr>
                <td>Referencia</td>
                <td colspan="2"><?=$form->input('referencia', array('div'=>array('class'=>'col-md-5'), 'default' => $referencia, 'label' => false, 'class' => 'form-control' ) );?></td>
              </tr>
              <tr>
                <td>Comuna</td>
                <td colspan="2"><?=$form->input('comuna', array('div'=>array('class'=>'col-md-2'), 'options'=>$optionSelectComuna, 'empty' =>'-- Seleccione --', 'selected' => '0', 'label' => false, 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Provincia</td>
                <td colspan="2"><?=$form->input('provincia', array('div'=>array('class'=>'col-md-2'), 'options'=>$optionSelectProvincia, 'empty' =>'-- Seleccione --', 'selected' => '0', 'label' => false, 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Codigo Postal</td>
                <td colspan="2"><?=$form->input('cod_postal', array('div'=>array('class'=>'col-md-2'), 'default' => '1710088', 'label' => false, 'class' => 'form-control') );?></td>
              </tr>  
              <tr>
                <td>Coordenadas</td>
                <td width="844">
                    <?=$form->input('latitud', array('div'=>array('class'=>'col-md-3'), 'default' => $latitud, 'label' => 'Lat:', 'class' => 'form-control' ) );?>
                    <!--<div class="clearfix"></div>-->
                    <?=$form->input('longitud', array('div'=>array('class'=>'col-md-3'), 'default' => $longitud, 'label' => 'Lon:', 'class' => 'form-control') );?>
                </td>
                <td width="774">
                    <div style="float:inherit; text-align:center;">
                      <?=$this->GoogleMap->map($map_options); ?>
                      <?=$this->GoogleMap->addMarker("map_canvas", 1, array("latitude" => $latitud, "longitude" => $longitud), $map_marker_options); ?>
                    </div>
                </td>
              </tr>
              <tr>
                <td>Servicio</td>
                <td><?=$form->input('servicio', array('div'=>array('class'=>'col-md-6'), 'default' => 'Sin Asignar', 'label' => false, 'class' => 'form-control') );?></td>
                <td><?=$form->input('comuna', array('div'=>array('class'=>'col-md-3'), 'options'=>$optionSelectAdministrador, 'empty' =>'-- Seleccione --', 'selected' => '0', 'label' => 'Administrador', 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Beneficiario</td>
                <td colspan="2"><?=$form->input('beneficiario', array('div'=>array('class'=>'col-md-2'), 'default' => 'Sin Asignar', 'label' => false, 'class' => 'form-control') );?></td>
              </tr>
              <tr>
                <td>Monto Avalúo $</td>
                <td colspan="2"><?=$form->input('monto_avaluo', array('div'=>array('class'=>'col-md-2'), 'default' => '15.214.654', 'label' => false, 'class' => 'form-control inputMonto') );?>.-</td>
              </tr>
              <tr>
                <td>Monto Arriendo $</td>
                <td colspan="2"><?=$form->input('monto_arriendo', array('div'=>array('class'=>'col-md-2'), 'default' => '14.658', 'label' => false, 'class' => 'form-control inputMonto') );?>.-</td>
              </tr>
              <tr>
                <td colspan="3"><?=$form->button('Guardar Cambios', array('class' => 'btn btn-primary inputRut') );?></td>
              </tr>
            </table>
        </div>
        <? //echo "<pre>".print_r($this->params, 1)."</pre>"; ?>
      <div style="float:left; margin:0 auto;">    
		<?
            $elParams = ( isset($this->params['pass']) && count($this->params['pass'])>0 ? $this->params['pass'] : 'vacio');
            $optionSelectMantencion = array('Mantención', 'Ampliación', 'Reparación', 'Demolición', 'Construcción');
            $optionSelect = array('Devolución', 'Asignación');
            $textoDefault = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
            $textoDefault1 = "But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you ...";
        ?>
        <table class="table table-bordered table-condensed" >
                <tr>
                    <td style="width:150px; text-align:center; background-color:<?=($elParams[0] == 1 ? '#FC0;': '#FFF;')?>" ><?=$this->Html->link('Historial de Mantención', '/viviendas/admin/1');?></td>
                    <td style="width:150px; text-align:center; background-color:<?=($elParams[0] == 2 ? '#FC0;': '#FFF;')?>" ><?=$this->Html->link('Historial de Arriendos', '/viviendas/admin/2');?></td>
                </tr>
            </table>
            <?
                //echo "<pre>".print_r($elParams, 1)."</pre>";
                switch($elParams[0]){
                     case 1:
            ?>
                    <table class="table table-bordered table-condensed" >
                        <tr>
                          <th colspan="4">
                                Historial de Mantención
                            <div style="float:right;"><?=$this->Html->link('[+] Nuevo Historial', '/viviendas/admin/1')?></div>
                          </th>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Observación</th>
                            <th>Documento</th>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y');?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelectMantencion, 'empty' =>'-- Seleccione --', 'selected' => '1', 'label' => false, 'class'=>'form-control') );?></td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault, 'label' => false, 'class'=>'form-control') );?></td>
                            <td><?=$form->input('documento', array('type'=>'file', 'label' => false, 'class'=>'btn btn-success') );?></td>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y', strtotime('+1 days'));?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelectMantencion, 'empty' =>'-- Seleccione --', 'selected' => '0', 'label' => false, 'class'=>'form-control') );?></td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault, 'label' => false, 'class'=>'form-control') );?></td>
                            <td>
                                <? $pathFile = $path_docs_historial.'doc01_prop03.pdf';?>
                                <?=$this->Html->link('Informe de Mantención', $pathFile, array('target' => '_blank', 'class'=>'btn btn-success') );?>
                            </td>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y', strtotime('+4 days'));?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelectMantencion, 'empty' =>'-- Seleccione --', 'selected' => '2', 'label' => false, 'class'=>'form-control') );?></td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault1, 'label' => false, 'class'=>'form-control') );?></td>
                            <td>
                                <? $pathFile = $path_docs_historial.'doc01_prop03.pdf';?>
                                <?=$this->Html->link('Informe de Mantención', $pathFile, array('target' => '_blank', 'class'=>'btn btn-success') );?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" ><?=$form->button('Agregar Historial de Mantención', array( 'class'=>'btn btn-primary') );?></td>
                        </tr>
                    </table>
            <? 		break;
                    case 2: 
            ?>
                    <table class="table table-bordered table-condensed" >
                        <tr>
                            <th colspan="6">
                                Historial de Arriendos (Asigna vivienda)
                                <div style="float:right;"><?=$this->Html->link('[+] Nuevo Historial', '/viviendas/admin/2')?></div>
                            </th>
                        </tr>
                        <tr>
                            <th>Fecha</th>
                            <th>Destino</th>
                            <th>Beneficiario</th>
                            <th>Monto Arriendo</th>
                            <th>Observación</th>
                            <th>Documento</th>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y', strtotime('-1 days'));?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelect, 'empty' =>'-- Seleccione --', 'selected' => '1', 'label' => false, 'class'=>'form-control') );?></td>
                            <td>Juan Perez</td>
                            <td style="text-align:right; " >$ 14.658.-<br /><strong>Vencimiento: 5 de cada mes</strong></td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault1, 'label' => false, 'class'=>'form-control') );?></td>
                            <td>
                                <? $pathFile = $path_docs_historial.'doc01_prop03.pdf';?>
                                <?=$this->Html->link('Informe de Arriendo', $pathFile, array('target' => '_blank', 'class'=>'btn btn-success') );?>
                            </td>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y', strtotime('-10 days'));?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelect, 'empty' =>'-- Seleccione --', 'selected' => '0', 'label' => false, 'class'=>'form-control') );?></td>
                            <td>Raul Guzman</td>
                            <td style="text-align:right; " >$ 10.589.-</td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault, 'label' => false, 'class'=>'form-control') );?></td>
                            <td><?=$form->input('documento', array('type'=>'file', 'label' => false, 'class'=>'btn btn-success') );?></td>
                        </tr>
                        <tr>
                            <td><?=date('d/m/Y', strtotime('-15 days'));?></td>
                            <td><?=$form->input('tipo_evento', array('options'=>$optionSelect, 'empty' =>'-- Seleccione --', 'selected' => '1', 'label' => false, 'class'=>'form-control') );?></td>
                            <td>Raul Guzman</td>
                            <td style="text-align:right; " >$ 10.589.-<br /><strong>Vencimiento: 20 de cada mes</strong></td>
                            <td><?=$form->input('observacion', array('rows' => '5', 'cols' => '30', 'default' => $textoDefault1, 'label' => false, 'class'=>'form-control') );?></td>
                            <td>
                                <? $pathFile = $path_docs_historial.'doc01_prop03.pdf';?>
                                <?=$this->Html->link('Informe de Arriendo', $pathFile, array('target' => '_blank', 'class'=>'btn btn-success') );?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <?=$form->button('Agregar Historial', array( 'class'=>'btn btn-primary') );?>
                                &nbsp;&nbsp;&nbsp;<label style="display:inline; color:red; ">(En esta seccion es donde se asigna o desasigna una vivienda a un beneficiario)<br>
                                					(La ultima fecha de asignacion deve y tiene que indicar quien vive en la casa actualmente)</label>
                            </td>
                        </tr>
                    </table>
            <? 		break;
                } 
            ?>
       </div>
    </fieldset>
</div>

<hr>
