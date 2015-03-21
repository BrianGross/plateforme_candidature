<h3>Vérification des informations personnelles</h3>

<?php echo $this->Form->create('Etudiant',array('action'=>'edit',$session_id,$formation_id,$this->Session->read('Etudiant.user_id'))); ?>

	<?php 

		echo $this->Form->input('nom');
		echo $this->Form->input('nom_marital',array('label'=>'Nom de jeune fille : '));
		echo $this->Form->input('prenom');
		?>

			<?php echo $this->Form->input('date_de_naissance',array('label'=>'Date de Naissance')); ?>

		<?php
		foreach ($pays as $pay) {
			$nom_pays[] = $pay['Pay']['LIB_NAT'];
			$cod_pays[] = $pay['Pay']['COD_PAY'];
					}

		$nb_pays = count($pays);

			for ($i=0; $i < $nb_pays; $i++) { 
				$paays{$cod_pays[$i]} = $nom_pays[$i];
			}


		echo $this->Form->input('pays_de_naissance',array("options"=>$paays,'default'=>$pays_de_naissance));


		echo $this->Form->input('pays_de_nationalite',array("options"=>$paays,'default'=>$pays_de_nationalite));
		echo $this->Form->input('adresse');
		echo $this->Form->input('adresse2',array('label'=>'Complément d\'adresse 2 : '));
		echo $this->Form->input('adresse3',array('label'=>'Complément d\'adresse 3 : '));
			foreach ($departements as $departement) {
			$nom_depar[] = $departement['Departement']['LIB_DEP'];
			$cod_depar[] = $departement['Departement']['COD_DEP'];
					}

		$nb_depar = count($departements);

			for ($i=0; $i < $nb_depar; $i++) { 
				$departementss{$cod_depar[$i]} = $nom_depar[$i];
			}
		echo $this->Form->input('departement',array('options'=>$departementss,'default'=>$departement_real));
		echo $this->Form->input('cp');
		echo $this->Form->input('ville');
		echo $this->Form->input('tel_dom',array('type'=>'text'));
		echo $this->Form->input('tel_port',array('type'=>'text'));
		echo $this->Form->input('email');
		echo $this->Form->hidden('sess',array('value'=>$session_id));
		echo $this->Form->hidden('form',array('value'=>$formation_id));
		echo $this->Form->submit('modifier',array('class'=>'button warning'));
		echo $this->Html->link('continuer', $url = array('action'=>'candidature',$session_id,$formation_id), $options = array('class'=>'button success'), $confirmMessage = false);;
?>
<?php echo $this->Form->end(); ?>
