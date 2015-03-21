
<?php echo $this->Form->create('Etudiant'); ?>

		<h1 class="large-12	columns"><?php echo __('Candidater à la formation '.$formation['Formation']['name']); ?></h1>
		<h3 class="large-12 columns">Diplômes, étude et acquis universitaire</h3>
		<?php 

			foreach ($bacs as $bac) {
				$before = html_entity_decode($bac['Bac']['LIB_BAC']);
				$explode = explode('-',$before);
				if (!empty($explode[1])) {
					$cod[] = $explode[1];
				}
				$lib[] = html_entity_decode($bac['Bac']['COD_BAC']);

			}

			$nb_bac = count($bacs);

			for ($i=0; $i < $nb_bac; $i++) { 
				if (!empty($cod[$i])) {
					$options{$lib[$i]} = $cod[$i];
				}
			}
		
 ?>
		<?php echo $this->Form->input('bac',array('label'=>'Série du Baccalauréat obtenu','options'=>$options)); ?>

		<?php echo $this->Form->input('annee_obtention',array('label'=>'Année d\'obtention du bac : ')); ?>

		<?php foreach ($diplomes as $diplome) {

				$cod_dip[] = html_entity_decode($diplome['Diplome']['lib_tds']);
				$lib_dip[] = html_entity_decode($diplome['Diplome']['code_tds']);

			}

			
			 $level = $formation['Formation']['level']; 
?>

<?php for ($i=2; $i < $level ; $i++): ?>
				
			<?php 
			$nb_diplome = count($diplomes);

			for ($a=0; $a < $nb_diplome; $a++) { 
				$diploome{$lib_dip[$a]} = $cod_dip[$a];
			} ?>

			<?php echo $this->Form->input('bac_'.$i,array('label'=>'Bac +'.$i,'options'=>$diploome,'class'=>'bac_'.$i,'empty'=>'Choisissez')); ?>
			<?php echo $this->Form->input('nom_bac'.$i,array('label'=>'Entrez en toute lettre la spécialité du diplôme','div'=>array('style'=>'display:none;','class'=>'nom_bac'.$i))); ?>
		<?php endfor; ?>

		<?php echo $this->Form->input('autres',array('label'=>'Autres diplômes : ')); ?>

		<?php echo $this->Form->input('last_etablissement',array('label'=>'Dernier établissement : ')); ?>

		<?php echo $this->Form->input('annee_frequentation',array('label'=>'Date, Année de fréquention : ')); ?>

		<?php echo $this->Form->input('adresse_etablissement',array('label'=>'Adresse établissement : ')); ?>

		<?php echo $this->Form->input('ville_etablissement',array('label'=>'Ville établissement : ')); ?>


		<?php foreach ($pays as $pay) {
			$nom_pays[] = $pay['Pay']['LIB_NAT'];
			$cod_pays[] = $pay['Pay']['COD_PAY'];
					}

		$nb_pays = count($pays);

			for ($i=0; $i < $nb_pays; $i++) { 
				$paays{$cod_pays[$i]} = $nom_pays[$i];
			}


		echo $this->Form->input('pays_etablissement',array("options"=>$paays,'label'=>'Pays du dernier établissement : ')); ?>


		<?php if ($formation['Formation']['level'] == 5): ?>
			<?php foreach ($master2s as $master2) {
			$nom_master2[] = $master2['Formation']['spe'];
			$cod_master2[] = $master2['Formation']['id'];
					}

		$nb_m2 = count($master2s);

			for ($i=0; $i < $nb_m2; $i++) { 
				$maaster2{$cod_master2[$i]} = $nom_master2[$i];
			}


		echo $this->Form->input('choix_1',array("options"=>$maaster2,'label'=>'Votre choix 1')); ?>

		<?php
		echo $this->Form->input('choix_2',array("options"=>$maaster2,'label'=>'Votre choix 2')); ?>

		<?php
		echo $this->Form->input('choix_3',array("options"=>$maaster2,'label'=>'Votre choix 3')); ?>


		<?php endif ?>

		<h3 class="large-12 columns">Lettre de motivation : </h3>
		<?php echo $this->Form->input('curriculum_vitae',array('label'=>'Votre lettre de motivation : ','type'=>'textarea','id'=>'editor')); ?>

		<?php echo $this->Form->submit('Continuer', $options = array('class'=>'button success')); ?>
<?php echo $this->Form->end(); ?>

<?php for ($i=2; $i <= $level; $i++): ?>
	<script>

	$('.bac_<?php echo $i; ?>').change(function(e){
		var Stat = $(this).val();

        if (Stat != 0) {
        	$('.nom_bac<?php echo $i; ?>').css('display','block');
        }

        });
</script>

<?php endfor; ?>

<?php $this->Html->script("tinymce/tinymce.min.js",array("inline"=>false)); ?>
<?php $this->html->scriptStart(array("inline"=>false)); ?>
            tinymce.init({
    selector: "textarea#editor",
    plugins : "paste",
        paste_use_dialog : false,
paste_auto_cleanup_on_paste : true,
paste_convert_headers_to_strong : false,
paste_strip_class_attributes : "all",
paste_remove_spans : true,
paste_remove_styles : true,
paste_retain_style_properties : "",

 });
<?php $this->html->scriptEnd(); ?>
