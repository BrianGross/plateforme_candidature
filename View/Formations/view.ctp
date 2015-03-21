<div class="large-4 columns">
<h4 class="text-center large-12" style="font-weight:bold;"><?php echo $formation['Formation']['name'].','; ?></h4>
<h4 class="text-center large-12" style="margin-top:-15px;"><?php echo $formation['Formation']['spe']; ?></h4>

<p class="large-12 columns">Objectifs</p>
<p class="large-12 columns"><?php echo $formation['Formation']['description'];  ?></p>
<p class="large-12 columns">Conditions d'accès</p>
<p class="large-12 columns"><?php echo $formation['Formation']['acces'];  ?></p>
<div class="large-12 columns">
	

		<?php $now = date('Y-m-d');  ?>

		<?php $now = '2015-04-03'; ?>
	<?php $nb = count($formation['Session']); ?>
		<?php if (!empty($formation['Session'])): ?>

		
		<?php for ($i=0; $i < $nb ; $i++): ?> 
		<?php 
		$act = $i + 1;
		if ($now >= $formation['Session'][$i]['date_ouverture'] AND $now < $formation['Session'][$i]['date_fermeture']) {
			$nosession[999] = 2;

			echo $this->Html->link('Je candidate pour la session '.$act,array('controller'=>'etudiants','action'=>'rappel_dossier',$formation['Session'][$i]['id'],$formation['Formation']['id']),array('class'=>'button success'));

		} else {
			$nosession[] = "1";
		}
			 ?>

		<?php endfor; ?>

		<?php if (empty($nosession[999])): ?>
			<button class="button warning">Il n'y a pas de session en cours</button>
		<?php endif ?>



	
					
		<?php endif ?>		

</div>

</div>
<div class="large-8 columns">
	<?php $youtube = explode('https://www.youtube.com/watch?v=',$formation['Formation']['youtube']); ?>
<div class="large-12 columns">
<iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo $youtube[1]; ?>" frameborder="0" allowfullscreen></iframe>
</div>

<div class="large-6 columns">

<?php echo $formation['Formation']['colum_1'];  ?>

</div>

<div class="large-6 columns">

<?php echo $formation['Formation']['colum_2'];  ?>

</div>

</div>



