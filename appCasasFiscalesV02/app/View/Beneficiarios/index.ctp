<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
$TitleTxtNombre_benef = 'Nombre del Beneficiario. Ej: Juan Pérez Diaz o Juan Pérez o Juan';
$FormatoTitleTxtNombre_benef = 'Formato: Nombre APaterno AMaterno o Nombre APaterno o Nombre';
//echo '<pre>conditions:'.print_r($conditions, 1).'</pre>';
// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=> "Nombre" ) ));
////// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=>substr( $conditions['nombres LIKE'], 0, strlen($conditions['nombres LIKE'])-1 ) ) ));
?>
<? // =$this->Session->flash(); ?>
<? //=debug($listado);?>
<div class="container-flex warning">

    <div class="row">
		<?=$this->Form->Create('');?>
            <div class="col-md-3"><legend>Beneficiario</legend></div>
            <div class="col-md-4">
            	<?=$this->Form->input('nombre_benef', array('label' => false, 'class'=> 'resaltar form-control',
																													'placeholder'=>$TitleTxtNombre_benef, 'title'=>$FormatoTitleTxtNombre_benef) );?>
							<label>Mínimo 3 caracteres.</label>
            </div>
            <div class="col-md-5"><?=$this->Form->submit("Buscar", array('class'=> 'btn btn-primary') );?></div>
        <?=$this->Form->end();?>  
    </div>
    
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/beneficiarios/agrega', array('class'=>'btn btn-primary') )?></div>
    	</div>
    </div>
    <div class="row ">
			<div class="col-md-11 ">
				<div class="">
					<div class="table-responsive panel panel-default">
						<table class="table table-bordered table-striped table-hover table-condensed table-responsive">
							<thead> 
								<tr class="info"  >
									<th width="220px" style="text-align:center;">Acciones</th>
										<th><?=$this->Paginator->sort('rut', 'Rut', array( 'class'=>"text-black") );?></th>
										<th><?=$this->Paginator->sort('nombres', 'Nombre', array( 'class'=>"text-black") );?></th>
										<th><?=$this->Paginator->sort('estcivil_id', 'Estado Civil', array( 'class'=>"text-black") );?></th>
										<th>Rut Conyuge</th>
										<th>Nombre Conyuge</th>
										<th>Servicio</th>
								</tr>
								</thead>
								<tbody>
								<? foreach($listado as $lista){ ?>
										<tr class="active__" >
												<td style="text-align: center;">
													Pagar -
													<?=$this->Html->link('Administrar', '/beneficiarios/edita/id:'.$lista['Beneficiario']['id'], array('class'=> 'btn btn-info btn-xs'));?>
														 -
														<?=$this->Html->link('Eliminar', array('controller' => 'beneficiarios', 'action' => 'borra', $lista['Beneficiario']['id']), array('class'=> 'btn btn-info btn-xs'), "Are you sure you wish to delete this Beneficiario?" );?>
												</td>
												<td ><?=$funciones->formatoNum($lista['Beneficiario']['rut']).'-'.$lista['Beneficiario']['dv'];?></td>
												<td><?=$lista['Beneficiario']['nombres'].' '.$lista['Beneficiario']['paterno'].' '.$lista['Beneficiario']['materno'];?></td>
												<td><?/*=$lista['Beneficiario']['estcivil_id'];*/?><?=$lista['Estcivil']['descripcion'];?></td>
												<td><?=(isset($lista['Conyuge']['rut']) ? $this->Funciones->formatoRut($lista['Conyuge']['rut']) : '---' );?></td>
												<td><?=(isset($lista['Conyuge']['nombres']) ? $lista['Conyuge']['nombres'].' '.$lista['Conyuge']['apellidos'] : '---');?></td>
												<td><p class="h6 col-md-12"><?=(isset($lista['beneficiarios_servicio']['Servicio']['nombre']) ? $lista['beneficiarios_servicio']['Servicio']['nombre'] : '---');?></p></td>
										</tr>
								<? } ?>
								</tbody>
						</table>
						<?
						echo $this->Paginator->prev('« Prev ', null, null, array('class' => 'enabled'));
						echo $this->Paginator->next(' Prox »', null, null, array('class' => 'disabled'));
						?>
						<?='<br>'.$this->Paginator->counter(array('format' => 'Pagina %page% de %pages%, mostrando %current% registros de un total de %count%, iniciando en %start%, con fin %end%'));?>
					</div>
				</div>
			</div>
    </div>
    
</div>