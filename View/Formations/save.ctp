<div class="row">

<div class="large-12 columns">
<?php echo $this->Html->link('Connexion étudiante', $url = array('controller'=>'etudiants','action'=>'login'), $options = array('class'=>'button success'), $confirmMessage = false); ?>

<?php echo $this->Html->link('Inscription étudiante', $url = array('controller'=>'etudiants','action'=>'signup'), $options = array('class'=>'button warning'), $confirmMessage = false); ?>

<p>L'année de candidature en cours est <?php echo $annee['Annee']['date']; ?></p>
<?php $now = date('Y-m-d');  ?>
<p>On est le <?php echo $now; ?>
<?php foreach ($formations as $formation): ?>
	

	<?php $compte = count($formation['Session']); ?>
	<?php $ses = array(); ?>
			<?php for ($i=0; $i < $compte ; $i++): ?>
			<?php $nb = $i + 1; ?>
				<?php if ($now >= $formation['Session'][$i]['date_ouverture'] AND $now < $formation['Session'][$i]['date_fermeture']): ?>
					<?php $ses[] = $nb; ?>
				<?php endif ?>
			<?php endfor; ?>
			<?php endforeach ?>

			<?php if (!empty($ses)): ?>
 et la session <?php echo $ses[0]; ?> est en cours.
			<?php else: ?>
 et il n'y a pas de session en cours.
			<?php endif ?>




</p>

<p>Les formations de cette année sont :</p>

<?php foreach ($formations as $formation): ?>
	<div class="large-12 columns">

		<h3 class="large-12"><?php echo $formation['Formation']['name']; ?></h3>

		<div class="large-12 columns">

			<?php echo $this->Html->link('Voir la formation', $url = array('controller'=>'formations', 'action'=>'view',$formation['Formation']['id']), $options = array('class'=>'button success'), $confirmMessage = false); ?>


			<?php $compte = count($formation['Session']); ?>

			<?php for ($i=0; $i < $compte ; $i++): ?> 
			<?php $act = $i + 1; ?>
			<?php $e1 = explode('-', $formation['Session'][$i]['date_ouverture']); ?>
			<?php $ouv = $e1[2]."/".$e1[1]."/".$e1[0]; ?>
			<?php $e2 = explode('-', $formation['Session'][$i]['date_fermeture']); ?>
			<?php $ferm = $e2[2]."/".$e2[1]."/".$e2[0]; ?>
				<p>Pour cette formation, la session <?php echo $act; ?> débute le <?php echo $ouv; ?> et finit le <?php echo $ferm; ?></p>

				<?php $now = date('Y-m-d');  ?>


			<?php if ($now >= $formation['Session'][$i]['date_ouverture'] AND $now < $formation['Session'][$i]['date_fermeture']): ?>
				<p><?php echo 'la session '.$act.' est en cours'; ?></p>
			<?php else: ?>
				<p><?php echo 'la session '.$act.' est fermée'; ?></p>
			<?php endif ?>
			<?php endfor; ?>


		</div>

	</div>
<?php endforeach ?>
</div>
</div>