 <div class="large-12 columns">

 <?php if (empty($etudiant['Dossieradmission'])): ?>
 	<h3>Vous n'avez pas encore de dossier de candidature</h3>

 <?php else: ?>
 <h3>Vous avez déposé <?php echo count($etudiant['Dossieradmission']); ?> candidature</h3>
 <table> 
	<thead>
	 <tr> 
	 	<th>Numéro de dossier</th>
	 	 <th>Statut</th>
	 	  <th>Formation</th>
	 	  <th>Session</th>
	 	  <th>Année</th> 
	 	  <th>Action</th> 
	 	</tr> 
	 </thead> 
	 <tbody> 
	 		<?php foreach ($etudiant['Dossieradmission'] as $dossier): ?>
 	<?php if ($dossier['ETA_DOS'] == 99) {
 		$var = 'En attente administrativement';
 	} 
 	elseif ($dossier['ETA_DOS'] == 3) {
		$var = 'Confirmer';
 		}
 	else {
 		$var = 'Refuser';
 	}
 	 ?>

 	 <?php foreach ($formations as $formation): ?>

 	 	<?php if ($formation['Formation']['id'] == $dossier['choix_1']) {
 	 		$form[0] = $formation['Formation']['name'].','.$formation['Formation']['spe'];
 	 		$formaation_id = $formation['Formation']['id'];
 	 	}
 	 	elseif(!empty($dossier['choix_2'])) {
 	 		if ($formation['Formation']['id'] == $dossier['choix_2']) {
 	 		$form[1] = $formation['Formation']['name'].','.$formation['Formation']['spe'];
 	 	}
 	 	}
 	 	elseif(!empty($dossier['choix_3'])) {
 	 		if ($formation['Formation']['id'] == $dossier['choix_3']) {
 	 		$form[2] = $formation['Formation']['name'].','.$formation['Formation']['spe'];
 	 	}
 	 	}
 	 	 else {

 	 	}
 	 	 ?>
 	 <?php endforeach ?>
 	 <tr> 
	 		<td><?php echo $dossier['COD_CAND']; ?></td> 
	 		<td><?php echo $var; ?></td> 
	 		<td>

	 			<?php if (!empty($form[1]) AND !empty($form[2])  ) {
	 				echo 'choix 1 : '.$form[0].'<br/>';
	 				echo 'choix 2 : '.$form[1].'<br/>';
	 				echo 'choix 3 : '.$form[2].'<br/>';
	 			} else {
	 				echo $form[0];
	 			}
	 			 ?>


	 		</td>
	 		<?php foreach ($sessions as $session): ?>
	 			<?php if ($session['Session']['id'] == $dossier['session_id']) {
	 				$in_session[0] = $session['Session']['numero'];
	 				$id_current = $session['Formation']['annee_id'];
	 			} else {
	 				$in_session[1] = '';
	 			}
	 			
	 			 ?>
	 		<?php endforeach ?>
	 		<td><?php if (!empty($in_session[0])) {
	 			echo $in_session[0];
	 		} ?></td>
	 		<?php if (!empty($in_session[0])): ?> 
	 		<?php foreach ($annees as $annee): ?>
	 			<?php if ($annee['Annee']['id'] == $id_current): ?>
	 				<?php $in_date[0] = $annee['Annee']['date'];?>
	 			<?php endif ?>
	 		<?php endforeach ?>
	 				<?php endif; ?>
	 		<td><?php if (!empty($in_date[0])) {
	 			echo $in_date[0];
	 		} ?></td>
	 		<td>
	 			<?php echo $this->Html->link('Modifier les informations', $url = array('action'=>'edit_info_da',$dossier['id'],$formaation_id), $options = array('class'=>'button success','style'=>'padding:5px;'), $confirmMessage = false); ?>
	 			<?php echo $this->Html->link('Modifier les fichiers', $url = array('action'=>'edit_da',$dossier['id']), $options = array('class'=>'button warning','style'=>'padding:5px;'), $confirmMessage = false); ?></td> 
	 	</tr> 
 	<?php endforeach; ?>
 <?php endif ?>
	 	</tbody>
	 	 </table>
 </div>