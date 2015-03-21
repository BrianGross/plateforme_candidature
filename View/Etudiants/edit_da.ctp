<div class="large-12 columns">
	<h3 class="large-12 columns">Rappel des documents</h3>
	<table> 
		<thead> 
			<tr> 
				<th>Nom du document</th>
				 <th>Ajouter</th> 
				 <th>Fichier Téléchargé</th>
				 <th>Supprimer</th> 
				</tr> 
			</thead> 
			<tbody>
						<?php foreach ($docadmins as $docadmin): ?>
						<?php echo $this->Form->create('Etudiant', $options = array('action'=>'download_spe','type'=>'file')); ?>
		<tr>
			<td><?php echo $docadmin['Docadmin']['name']; ?></td>
					<td>
						<label for="<?php echo 'doc'.$docadmin['Docadmin']['id']; ?>" class="button warning" style="padding:5px;">Ajouter</label>
				<?php echo $this->Form->input('doc', $options = array('type'=>'file','id'=>'doc'.$docadmin['Docadmin']['id'],'label'=>false,'div'=>false,'style'=>'display:none;')); ?>
				<?php echo $this->Form->hidden('id', $options = array('value'=>$docadmin['Docadmin']['id'])); ?>
				<?php echo $this->Form->hidden('redirect', $options = array('value'=>1)); ?>
				<?php echo $this->Form->hidden('id_da', $options = array('value'=>$id)); ?>
				<?php echo $this->Form->submit('envoyer', $options = array('id'=>'submit'.$docadmin['Docadmin']['id'],'style'=>'display:none;')); ?>
			</td>
			<td>

				<?php foreach ($docadmin['Docetudiant'] as $key): ?>
					<?php if ($key['etudiant_id'] == $this->Session->read('Etudiant.user_id') AND $key['dossieradmission_id'] == $id) {
						$nom_abr = explode('_', $key['file']); 
						 echo $this->Html->link($nom_abr[2],array('controller'=>'etudiants','action'=>'sendfilestudent',$key['file'],$annee['Annee']['date']));
					} ?>
				<?php endforeach ?>



			</td>
			<td>
				<?php foreach ($docadmin['Docetudiant'] as $key): ?>
					<?php if ($key['etudiant_id'] == $this->Session->read('Etudiant.user_id') AND $key['dossieradmission_id'] == $id) {
						echo $this->Html->link(
    'X',
    array('action'=>'deletefilestudent',$key['id'],$id), 
    array(
    ),array('Voulez-vous vraiment supprimer ce fichier ?')
); 
					} ?>
				<?php endforeach ?>

			</td>
			</tr>
			<?php echo $this->Form->end(); ?>
		<?php endforeach ?>
				 </tbody> 
				</table>
</div>

<div class="large-6 columns">



</div>




<div class="large-6 columns">
<?php echo $this->Form->create("Etudiant", array("type" => "file")); 
 ?>
		<h3><?php echo __('Téléchargement de fichiers divers'); ?></h3>

<?php echo $this->Form->input('doc', $options = array('type'=>'file','label'=>false)); ?>

<?php echo $this->Form->submit('Ajouter', $options = array('class'=>'button warning')); ?>

<?php echo $this->Form->end(); ?>
</div>

<div class="large-6 columns">
<h3 class="large-12 columns">Documents téléchargés divers</h3>

<?php foreach ($downloads as $download): ?>
	<?php if (empty($download['Docetudiant']['docadmin_id'])): ?>
		
	
	<div class="large-12 columns">
		<div class="large-8 columns">
		<?php $nom_abr = explode('_', $download['Docetudiant']['file']); ?>

		<?php echo $this->Html->link($nom_abr[2],array('controller'=>'etudiants','action'=>'sendfilestudent',$download['Docetudiant']['file'],$annee['Annee']['date']));?>
</div>
<div class="large-4 columns">
<?php

echo $this->Html->link(
    'X',
    array('action'=>'deletefilestudent',$download['Docetudiant']['id'],$id), 
    array(
    ),array('Voulez-vous vraiment supprimer ce fichier ?')
); ?>
</div>


	</div>
	<?php endif ?>
<?php endforeach ?>



</div>

<div class="coucou">
<?php foreach ($docadmins as $docadmin): ?>
	<script>

		$("#doc<?php echo $docadmin['Docadmin']['id']; ?>").bind('change',function(e){
		var newVal = $(this).val();
        if (newVal != '') {
        	$("#submit<?php echo $docadmin['Docadmin']['id']; ?>").trigger('click');
        };

});




	</script>
<?php endforeach ?>
</div>