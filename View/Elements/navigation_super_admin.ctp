<div class="row">

	<div class="large-12 columns">

		<ul class="inline-list">

			<li><?php echo $this->Html->link('Année de candidature',array('controller'=>'annees','action'=>'index'),array('class'=>' button alert')); ?></li>
			<li><?php echo $this->Html->link('Utilisateurs',array('controller'=>'users','action'=>'index'),array('class'=>' button success')); ?></li>
			<li><?php echo $this->Html->link('Se déconnecter',array('controller'=>'users','action'=>'logout'),array('class'=>' button warning')); ?></li>
		</ul>
	</div>


</div>