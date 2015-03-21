

<div class="row">
<div class="large-12 columns">
<?php echo $this->Form->create('Formation'); ?>
	<fieldset>
		<legend><?php echo __('Ajouter une session pour la formation '.$formation['Formation']['name'].'de l\'année de candidature '.$formation['Annee']['date']); ?></legend>
		<div class="large-12 columns">
                	<?php echo $this->Form->input('date_ouverture', array('type'=>'date')); ?>

                    <h5>Fermeture</h5>
	<?php echo $this->Form->input('date_fermeture', array('type'=>'date')); ?>
</div>
<?php
		echo $this->Form->input('numero',array('label'=>'Numéro de la session','type'=>'number'));
		echo $this->Form->end('Ajouter');
?>
</div>
</div>