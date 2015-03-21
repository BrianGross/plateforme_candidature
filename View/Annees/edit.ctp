<div class="annees form">
<?php echo $this->Form->create('Annee'); ?>
	<fieldset>
		<legend><?php echo __('Edit Annee'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('anneecandidature');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Annee.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Annee.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Annees'), array('action' => 'index')); ?></li>
	</ul>
</div>
