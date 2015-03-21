<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Se connecter'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('password');
	?>
<?php echo $this->Form->submit(__('Se connecter'),array('class'=>'button success')); ?>
