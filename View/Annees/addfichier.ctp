<div class="annees form">
<?php echo $this->Form->create('Annee'); ?>
	<fieldset>
		<legend><?php echo __('Ajouter un fichier'); ?></legend>
	<?php



		echo $this->Form->input('date',array('options'=>$options));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Annees'), array('action' => 'index')); ?></li>
	</ul>
</div>
