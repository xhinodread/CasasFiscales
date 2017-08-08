<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.view.templates.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 App::import('Vendor','Funcionespropias');
 $funciones = new Funcionespropias();
 $versionApp = "0.1";
 $txtVersion = ' Casas Fiscales - v'.$versionApp.' beta';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?=$this->Html->charset(); ?>
		<title>
			<?=__($txtVersion).' -> ';?>
			<?=$title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css(array('jquery-ui.min', 'jquery-ui.theme', 'bootstrap.min', 'gore-apps', 'bootstrap-datepicker') );
			echo $this->Html->script(array('jquery-1.10.2.min', 'jquery-ui', 'mod01', 'NumberFormat154', 'bootstrap.min', 'Chart.bundle', 'validarut', 'modLlamadas', 'bootstrap-datepicker', 'bootstrap-datepicker.es.min'));
			// 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js'
			echo $scripts_for_layout;
		?>
		<script>
			var base_url='<?=$this->webroot;?>';
		</script>
	</head>
	<body> 
		<div class="container-fluid">
			<div class="row">
			   <div class="col-md- col-md-offset-1">
					<h2 style="width:580px; color:rgb(153,153,153); "><?=__($txtVersion);?></h2>
				</div>
			</div>
			<div class="row">
			   <div class="col-md-1">
					<? //=$this->name?>
					<? $caret = '<span class="caret"></span>'; ?>
					<ul class="nav nav-pills nav-stacked">
						<li role="presentation" class="<?=$funciones->menuSelecc($this->name, 'Pages');?>" ><?=$this->Html->link('Inicio', '/')?></li>
						<li role="presentation" class="<?=$funciones->menuSelecc($this->name, 'Beneficiarios');?>" ><?=$this->Html->link('Beneficiario', '/beneficiarios');?></li>
						<li role="presentation" class="<?=$funciones->menuSelecc($this->name, 'Servicios');?>" ><?=$this->Html->link('Servicios', '/servicios');?></li>
						<li role="presentation" class="<?=$funciones->menuSelecc($this->name, 'Viviendas');?>" ><?=$this->Html->link('Viviendas', '/viviendas');?></li>
	
	<? if(0):?>					
						<li role="presentation" class="<?=$funciones->menuSelecc($this->name, 'Contabilidades');?>" ><?=$this->Html->link('Contabilidad', '/contabilidades' );?></li>
						<li role="presentation" class="dropdown <?=$funciones->menuSelecc($this->name, 'Informes');?>" >
								<?=$this->Html->link('Informes '.$caret, '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'escape'=> false)  );?>
								<!--<span class="caret"></span>-->
							<ul class="dropdown-menu">
								<li role="presentation" ><?=$this->Html->link('Flujos y Bienes', '/informes/flujos_y_bienes');?></li>
								<li role="presentation" ><?=$this->Html->link('Deudores', '/informes/deudores');?></li>
								<li role="presentation" ><?=$this->Html->link('Pagados', '/informes/pagados');?></li>
								<li role="presentation" ><?=$this->Html->link('Servicio', '/informes/por_servicio');?></li>
							</ul>
						</li>

						<li role="presentation" class="dropdown <?=$funciones->menuSelecc($this->name, 'Administrar');?>" >
							<?=$this->Html->link('Administrar '.$caret, '#', array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown', 'escape'=> false) )?>
							<ul class="dropdown-menu">
								<li role="presentation" ><?=$this->Html->link('Usuarios', '#')?></li>
								<li role="presentation" ><?=$this->Html->link('Parametros adicionales', '#')?></li>
							</ul>
						</li>
	<? endif;?>
					
						<li><?=$this->Html->link('Salir', '/');?></li>
				   </ul>
				</div>

				<div class="col-md-11" >
					<?php echo $this->Session->flash(); ?>
					<?php echo $content_for_layout; ?>
				</div>

			</div>
		</div>
		<?php //echo $this->element('sql_dump'); ?>
	</body>
</html>