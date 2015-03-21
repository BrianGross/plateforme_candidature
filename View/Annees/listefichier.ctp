<div class="row">
	<h2><?php echo __('Liste des Fichiers'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($annees as $annee): ?>
	<tr>
		<td><?php echo h($annee['Annee']['date']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $annee['Annee']['id']), array('class'=>'button alert min'), __('Are you sure you want to delete # %s?', $annee['Annee']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
</div>
