<div class="row">
	<div class="large-12 columns">
	<h2>Liste des utilisateurs</h2>
	<p><?php echo $this->Html->link(__('Ajouter un utilisateur'), array('action' => 'add'),array('class'=>'button success')); ?></p>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th>Email</th>
			<th>Status</th>
			<th>Formation</th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($superadmins as $user): ?>
	<tr>
		<td><?php echo $user['User']['email']; ?>&nbsp;</td>
		<td>Superadmin</td>
		<td>X</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $user['User']['id']), array('class'=>'button alert min'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
<?php foreach ($jurys as $user): ?>
	<tr>
		<td><?php echo $user['User']['email']; ?>&nbsp;</td>
		<td>Professeur référent</td>

		<?php if ($user['User']['formation'] == 1) {
			$user['User']['formation'] = 'license 3 Information et Communication';
		} ?>

		<?php if ($user['User']['formation'] == 2) {
			$user['User']['formation'] = 'License 3 TAIS spé TCSA';
		} ?>

		<?php if ($user['User']['formation'] == 3) {
			$user['User']['formation'] = 'Master 1 Information et Communication';
		} ?>

		<?php if ($user['User']['formation'] == 4) {
			$user['User']['formation'] = 'Master 2 IM';
		} ?>

		<?php if ($user['User']['formation'] == 5) {
			$user['User']['formation'] = 'Master 2 Information et Communication spé IM';
		} ?>

		<?php if ($user['User']['formation'] == 6) {
			$user['User']['formation'] = 'Master 2 spé PNI';
		} ?>

		<?php if ($user['User']['formation'] == 7) {
			$user['User']['formation'] = 'Master 2 spé E-rédactionnel';
		} ?>

		<?php if ($user['User']['formation'] == 8) {
			$user['User']['formation'] = 'Master 2 spé IET';
		} ?>




		<td><?php echo $user['User']['formation']; ?></td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $user['User']['id']), array('class'=>'button alert min'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>

		<?php foreach ($administrations as $user): ?>
	<tr>
		<td><?php echo $user['User']['email']; ?>&nbsp;</td>
		<td>Administration</td>
		<td>X</td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Supprimer'), array('action' => 'delete', $user['User']['id']), array('class'=>'button alert min'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>


	</tbody>
	</table>

</div>
