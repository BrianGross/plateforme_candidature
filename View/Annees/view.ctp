<div class="annees view">
<h2><?php echo __('Annee'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($annee['Annee']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Anneecandidature'); ?></dt>
		<dd>
			<?php echo h($annee['Annee']['anneecandidature']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Annee'), array('action' => 'edit', $annee['Annee']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Annee'), array('action' => 'delete', $annee['Annee']['id']), array(), __('Are you sure you want to delete # %s?', $annee['Annee']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Annees'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Annee'), array('action' => 'add')); ?> </li>
	</ul>
</div>
