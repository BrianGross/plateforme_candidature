
<?php echo $this->Form->create('Etudiant'); ?>

		<h3 class="large-12"><?php echo __('S\'inscrire'); ?></h3>
		<p>Votre sexe : </p>
	<?php		
		$options = array('Homme'=>'Homme','Femme'=>'Femme');
		echo $this->Form->input('gender',array('options'=>$options,'type'=>'radio','label'=>false,'div'=>false,'legend'=>false));
		?>
	<?php 

		echo $this->Form->input('nom');
		echo $this->Form->input('nom_marital',array('label'=>'Nom de jeune fille : '));
		echo $this->Form->input('prenom');
		?>
		<div class="large-12">
			<div class="large-12">Date de Naissance</div>
			<div class="large-4 columns">
			<?php echo $this->Form->input('date_de_naissance1',array('label'=>false,'placeholder'=>'jj')); ?>
			</div>
			<div class="large-4 columns">
		<?php echo $this->Form->input('date_de_naissance2',array('label'=>false,'placeholder'=>'mm')); ?>
		</div>
		<div class="large-4 columns">
		<?php echo $this->Form->input('date_de_naissance3',array('label'=>false,'placeholder'=>'aaaa')); ?>
		</div>

		</div>
		<?php
		echo $this->Form->input('ville_de_naissance');
		foreach ($pays as $pay) {
			$nom_pays[] = $pay['Pay']['LIB_NAT'];
			$cod_pays[] = $pay['Pay']['COD_PAY'];
					}

		$nb_pays = count($pays);

			for ($i=0; $i < $nb_pays; $i++) { 
				$paays{$cod_pays[$i]} = $nom_pays[$i];
			}


		echo $this->Form->input('pays_de_naissance',array("options"=>$paays));
		echo $this->Form->input('pays_de_nationalite',array("options"=>$paays));
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
		echo $this->Form->input('departement',array('options'=>$departementss));
		echo $this->Form->input('cp');
		echo $this->Form->input('ville');
		echo $this->Form->input('tel_dom',array('type'=>'text'));
		echo $this->Form->input('tel_port',array('type'=>'text'));
		echo $this->Form->input('email');
		echo $this->Form->input('confirm_email');
		echo $this->Form->input('mdp',array('type'=>'password'));
		echo $this->Form->input('confirm_password',array('type'=>'password'));
	?>

<?php echo $this->Form->submit(__('Créer le compte'),array('class'=>'button')); ?>
