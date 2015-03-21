
<div class="large-12 columns">
<?php echo $this->Html->link('Je suis un ancien étudiant d\'ingémédia', $url = array('action'=>'oldetudiant',$session_id,$formation_id), $options = array(), $confirmMessage = false); ?>
</div>

<div class="large-12 columns">
<?php echo $this->Html->link('Je suis un nouveau étudiant', $url = array('action'=>'info_perso',$session_id,$formation_id), $options = array(), $confirmMessage = false); ?>
</div>