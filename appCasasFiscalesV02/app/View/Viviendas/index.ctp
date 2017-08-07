<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
$TitleTxtNombre_vivie = 'Dirección. Ej: Arturo Prat 350 o Prat';
$FormatoTitleTxtNombre_vivie = 'Formato: Calle número o Calle';
//echo '<pre>conditions:'.print_r($conditions, 1).'</pre>';
// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=> "Nombre" ) ));
////// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=>substr( $conditions['nombres LIKE'], 0, strlen($conditions['nombres LIKE'])-1 ) ) ));
?>
<? // =$this->Session->flash(); ?>
<div class="container-flex warning">

    <div class="row">
		<?=$this->Form->Create('Vivienda', array('url'=>'index') );?>
			<div class="col-md-3"><legend>Vivienda</legend></div>
			<div class="col-md-4">
				<?=$this->Form->input('calle', array('label' => false, 'class'=> 'form-control'
																						 , 'placeholder'=>$TitleTxtNombre_vivie, 'title'=>$FormatoTitleTxtNombre_vivie) );?>
			</div>
			<div class="col-md-5"><?=$this->Form->submit("Buscar", array('class'=> 'btn btn-primary') );?></div>
    <?=$this->Form->end();?>  
    </div>
    
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/viviendas/agrega', array('class'=>'btn btn-primary') )?></div>
    	</div>
    </div>
    <div class="row ">
        <div class="col-md-11 ">
        <div class="">
            <div class="table-responsive panel panel-default">
                <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                	<thead> 
                    <tr class="info" >
                    	<th width="220px" style="text-align:center;">Acciones</th>
                    	<th width="100px" style="text-align:center;">Ultimo Pago</th>
                      <th><?=$this->Paginator->sort('rol', 'Rol', array( 'class'=>"text-black") );?></th>
                      <th><?=$this->Paginator->sort('calle', 'Calle', array( 'class'=>"text-black") );?></th>
                      <th><?=$this->Paginator->sort('sector', 'Sector', array( 'class'=>"text-black") );?></th>
                      <th>block, depto</th>
                      <th><?=$this->Paginator->sort('comuna_id', 'Comuna', array( 'class'=>"text-black") );?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($listado as $lista){ ?>
                        <tr class="active__" >
                            <td style="text-align: center;">
                            	Pagar -
                            	<?=$this->Html->link('Administrar', '/viviendas/edita/id:'.$lista['Vivienda']['id'], array('class'=> 'btn btn-info btn-xs'));?>
                              -
                              <?=$this->Html->link('Eliminar', array('controller' => 'viviendas', 'action' => 'borra', $lista['Vivienda']['id']), array('class'=> 'btn btn-info btn-xs'), "Are you sure you wish to delete this recipe?" );?>
                            </td>
                            <td style="text-align: center;">(Ultimo Pago)</td>
                            <td><?=$lista['Vivienda']['rol'];?> <?//=$funciones->formatoNum($lista['Servicio']['rut']).'-0';?></td>
                            <td><?=$lista['Vivienda']['calle'].' #'.$lista['Vivienda']['numero'];?></td>
                            <td><?=$lista['Vivienda']['sector'];?></td>
                            <td><?=$lista['Vivienda']['block'].', '.$lista['Vivienda']['depto'];?></td>
                            <td><?=$lista['Vivienda']['comuna_id'];?></td>
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