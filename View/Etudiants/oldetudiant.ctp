<?php echo $this->Html->css('normalize'); ?>
<?php echo $this->Html->css('component'); ?>


<?php echo $this->Form->create('Etudiant'); ?>

<div class="large-3 columns"><p> </p></div>
<div class="large-6 columns" style="padding-top:40px;"> 
	<h3 class="large-12 columns"><?php echo __('Se connecter'); ?></h3>
	<?php



		echo $this->Form->input('NUM_INE',array('id'=>'input-email','label'=>'Entrez votre numero INE : ','placeholder'=>'exemple: XXXXXXXXXX'));
	?>
	<?php
		echo $this->Form->input('email_student',array('label'=>'Entrez votre adresse étudiant','placeholder'=>'exemple: brian-gross@univ.etud-tln.fr'));
	?>
	<?php echo $this->Form->submit(__('Se connecter'),array('class'=>'button')); ?>
</div>
<div class="large-3 columns"><p> </p></div>


