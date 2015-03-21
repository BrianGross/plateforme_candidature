<?php echo $this->Html->css('normalize'); ?>
<?php echo $this->Html->css('component'); ?>


<?php echo $this->Form->create('Etudiant'); ?>

<div class="large-3 columns"><p> </p></div>
<div class="large-6 columns" style="padding-top:40px;"> 
	<h3 class="large-12 columns"><?php echo __('Se connecter'); ?></h3>
	<?php



		echo $this->Form->input('email',array('id'=>'input-email'));
	?>
	<?php
		echo $this->Form->input('mdp',array('type'=>'password'));
	?>
	<?php echo $this->Form->submit(__('Se connecter'),array('class'=>'button')); ?>
</div>
<div class="large-3 columns"><p> </p></div>

<p class="large-12 columns text-center">Vous n'avez pas de compte ?         

 <?php echo $this->Html->link('Inscrivez-vous', $url = array('action'=>'signup'), $options = array('class'=>'button alert'), $confirmMessage = false); ?>
</p>

