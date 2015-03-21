<div class="large-12 columns">

<h3 class="large-12 columns">Votre dossier a bien été enregistrer, vous avez reçu un mail de confirmation</h3>

<p>Votre numéro de dossier est le : <?php echo $dossier['Dossieradmission']['COD_CAND'] ?></p>
<?php $date = explode('-',$dossier['Session']['date_fermeture']); ?>
<p>Les candidatures seront traités après le <?php echo $date[2].'/'.$date[1].'/'.$date[0]; ?></p>

<?php echo $this->Html->link('Retourner sur mon profil', $url = array('action'=>'index',$this->Session->read('Etudiant.user_id'),$this->Session->read('Etudiant.token')), $options = array('class'=>'button success'), $confirmMessage = false); ?>

</div>