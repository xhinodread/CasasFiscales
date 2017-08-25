<div class="container">
	<div class="row">
		<div class="col-sm-2 col-sm-offset-5 col-md-4 col-md-offset-3 text-center">
			<?=$this->Flash->render('auth');?>
			<?=$this->Form->create();?>
				<h2 class="form-signin-heading">Ingreso de Usuario</h2>
				<div class="row">
					<?=$this->Form->input('username', array('div'=>array('class'=>'col-md-12'), 'class'=>'form-control', 'label'=>false, 'placeholder'=>'Nombre de usuario', 'autofocus'=>true) );?>
				</div>
				<div class="row"><label></label></div>
				<div class="row">
					<?=$this->Form->input('password', array('div'=>array('class'=>'col-md-12'), 'class'=>'form-control', 'label'=>false, 'placeholder'=>'Contraseña' ));?>
				</div>
				<div class="row"><label></label></div>
				<?=$this->Form->submit('Login', array('div'=>array('class'=>'col-md-12'), 'class'=>'btn btn-lg btn-primary btn-block') );?>
			<?=$this->Form->end();?>
		</div>
	</div>
</div>