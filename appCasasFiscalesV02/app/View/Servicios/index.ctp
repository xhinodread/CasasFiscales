<?
App::import('Vendor', 'Funcionespropias');
$funciones = new Funcionespropias();
$TitleTxtNombre_benef = 'Ej: Gobierno Regional o Gore';
$FormatoTitleTxtNombre_benef = 'Formato: Nombre del Servicio o Siglas del Servicio';
//echo '<pre>conditions:'.print_r($conditions, 1).'</pre>';
// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=> "Nombre" ) ));
////// $this->Paginator->options(array('url' => array($this->passedArgs, "Beneficiario.nombres"=>substr( $conditions['nombres LIKE'], 0, strlen($conditions['nombres LIKE'])-1 ) ) ));
?>
<? // =$this->Session->flash(); ?>
<div class="container-flex warning">

    <div class="row">
		<?=$this->Form->Create('Servicio', array('url'=>'index') );?>
            <div class="col-md-3"><legend>Servicio</legend></div>
            <div class="col-md-4"><?=$this->Form->input('nombre', array('label' => false, 'class'=> 'form-control', 'placeholder'=>'Nombre del Servicio. '.$TitleTxtNombre_benef, 'title'=>$FormatoTitleTxtNombre_benef) );?></div>
            <div class="col-md-5"><?=$this->Form->submit("Buscar", array('class'=> 'btn btn-primary') );?></div>
        <?=$this->Form->end();?>  
    </div>
    
	<div class="row">
		<div class="col-md-11">
 			<div style="float:right; margin-bottom:20px; "><?=$this->Html->link('[+] Nuevo', '/servicios/agrega', array('class'=>'btn btn-primary') )?></div>
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
                      <th><?=$this->Paginator->sort('nombre', 'Nombre', array( 'class'=>"text-black") );?></th>
                      <th><?=$this->Paginator->sort('siglas', 'Sigla', array( 'class'=>"text-black") );?></th>
                      <th>Teléfonos</th>
                      <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach($listado as $lista){ ?>
                        <tr class="active__" >
                            <td style="text-align: center;">
															Pagar - 
															<?=$this->Html->link('Administrar', '/servicios/edita/id:'.$lista['Servicio']['id'], array('class'=> 'btn btn-info btn-xs'));?>
															-
															<?=$this->Html->link('Eliminar', array('controller' => 'servicios', 'action' => 'borra', $lista['Servicio']['id']), array('class'=> 'btn btn-info btn-xs'), "Are you sure you wish to delete this recipe?" );?>
                            </td>
                            <td><?=$lista['Servicio']['rut'];?> <?//=$funciones->formatoNum($lista['Servicio']['rut']).'-0';?></td>
                            <td><?=$lista['Servicio']['nombre']; /* .' '.$lista['Servicio']['paterno'].' '.$lista['Servicio']['materno'];*/ ?></td>
                            <td><?=$lista['Servicio']['siglas'];?></td>
                            <td><?=$lista['Servicio']['telefonos'];?></td>
                            <td><?=$lista['Servicio']['email'];?></td>
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