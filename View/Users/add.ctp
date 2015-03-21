<div class="large-12 columns">
<?php echo $this->Form->create('User',array("type" => "file")); ?>
	<fieldset>
		<legend><?php echo __('Ajouter un utilisateur'); ?></legend>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('nom');
		echo $this->Form->input('prenom');
		echo $this->Form->input('avatar',array('label' => 'Entrer une photo','type' => 'file'));
		echo $this->Form->input('password');
		echo $this->Form->input('confirm_password',array("type"=>"password"));

		$options = array('commission'=>'commission','administration'=>'administration','superadmin'=>'superadmin');

		echo $this->Form->input('statut',array('options'=>$options,'empty' => 'Quel droit ?','class'=>'statut'));
?>

		

<?php 
		$formations = array(
			"name"=>array('1'=>'licence 3 Information et Communication','2'=>'Licence 3 TAIS spé TCSA','3'=>'Master 1 Information et Communication','4'=>'Master 2 IM','5'=>'Master 2 Information et Communication spé IM','6'=>'Master 2 spé PNI','7'=>'Master 2 spé E-rédactionnel','8'=>'Master 2 spé IET'),
			"value"=>array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8')
			);
		?>

		<?php	
		for ($i=1; $i <= count($formations['name']); $i++) { 
			echo $this->Form->input('check-'.$formations['value'][$i], array('type'=>'checkbox',
   		 	'value' => $formations['value'][$i],
    		'hiddenField' => false,
    		'class'=>'label-formation'.$i,
    		'label'=> $formations['name'][$i],
    		'div'=>array('id'=>'formation'.$i,'style'=>'display:none;')
			));

			$roles = array('1'=>'Président de commission','2'=>'Président suppléant','3'=>'Titulaire','4'=>'Titulaire suppléant');
			echo $this->Form->input('stat'.$i,array(
				'empty' => 'Quel statut ?',
				'options'=>$roles,
				'div'=>array('id'=>'stat'.$i,'style'=>'display:none;')
				));
		}


		
	?>

	</fieldset>
<?php echo $this->Form->submit(__('Créer'),array('class'=>'button success')); ?>
<?php echo $this->Form->end(); ?>

<script>

	$('.statut').bind('change',function(e){
		var newVal = $(this).val();
        if (newVal == 'commission') {
        	$('.checkbox').css('display','block');
        };

         if (newVal != 'commission') {
        	$('.checkbox').css('display','none');
        };

});

</script>

<?php for ($i=1; $i <= count($formations['name']); $i++): ?>
	<script>

	$('.label-formation<?php echo $i; ?>').change(function(e){
		var Stat = $(this).val();

        if (Stat == '<?php echo $i; ?>') {
        	$('#stat<?php echo $i; ?>').css('display','block');
        }

        });
</script>
<?php endfor; ?>
</div>