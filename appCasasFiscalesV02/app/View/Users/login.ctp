<div class="users form">
	<?=$this->Flash->render('auth');?>
	<?=$this->Form->create();?>
		<fieldset>
			<legend><?=__('Ingreso de Usuario'); ?></legend>
			<?=$this->Form->input('username');?>
			<?=$this->Form->input('password');?>
		</fieldset>
	<?=$this->Form->end(__('Login'));?>
</div>