<h2>Candidature pour la formation <?php echo $formation['Formation']['name'].', '.$formation['Formation']['spe']; ?></h2>
<p>Etape 1</p>
<h3>Téléchargement des documents obligatoires pour candidater (<?php echo $annee['Annee']['date']; ?>)</h3>

<?php foreach ($docadmins as $docadmin): ?>
	

	<div class="large-12 columns"><?php 
	echo $this->Html->link($docadmin['Docadmin']['name'],array('controller'=>'etudiants','action'=>'sendfile',$docadmin['Docadmin']['id'],$annee['Annee']['date'],$docadmin['Docadmin']['name'],$docadmin['Docadmin']['file']));?>
	</div>
	<?php
	if (!empty($docadmin['Docadmin']['note'])) {
		echo '<div class="large-12 columns">'.$docadmin['Docadmin']['note'].'</div>';
	}
	?>
	<div>



<?php endforeach ?>

<div class="large-12 columns">

<?php echo $this->Html->link('Continuer',array('action'=>'choix',$session_id,$formation_id),array('class'=>'button success right','style'=>'margin-top:20px;')); ?>

</div>
</div>
</div>
