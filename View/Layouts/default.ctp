<?php
/**
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		?>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
		<?php
		echo $this->Html->css('app');
		echo $this->Html->css('style');

		echo $this->Html->script('bower_components/modernizr/modernizr');
		?>
		  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<?php 
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>



			

<div class="container">

        <?php echo $this->Session->flash(); ?>

<div class="row">
<div class="large-12 nav-top-social">
	<div class="social large-offset-9 large-3 small-8 small-centered columns text-center">

				<?php $image = $this->Html->image(
    'facebook.png', 
    array(
        'alt'=>'facebook',
        'style' =>'width:25px;'
    )
);

echo $this->Html->link(
    $image,
    'http://facebook.com/Ingemedia', 
    array(
        'target'=>'_blank', 
        'escape' => false
    )
); ?>
		<?php $image = $this->Html->image(
    'twitter.png', 
    array(
        'alt'=>'twitter',
        'style' =>'width:25px;'
    )
);

echo $this->Html->link(
    $image,
    'http://twitter.com/Ingemedia', 
    array(
        'target'=>'_blank', 
        'escape' => false
    )
); ?>

<?php $image = $this->Html->image(
    'google+.png', 
    array(
        'alt'=>'google+',
        'style' =>'width:25px;'
    )
);

echo $this->Html->link(
    $image,
    'https://plus.google.com/112998131019942646432', 
    array(
        'target'=>'_blank', 
        'escape' => false
    )
); ?>

<?php $image = $this->Html->image(
    'youtube.png', 
    array(
        'alt'=>'youtube',
        'style' =>'width:25px;'
    )
);

echo $this->Html->link(
    $image,
    'https://www.youtube.com/channel/UC76buVoHsTSISYqaTfpTUfA', 
    array(
        'target'=>'_blank', 
        'escape' => false
    )
); ?>

	</div>
</div>

<div class="large-12 columns content-page">

<div class="large-12 en-tete">

	<?php echo $this->Html->image('logo_inge.png',array('url'=>array('controller'=>'formations','action'=>'index'),'class'=>'large-2 small-6 columns img-responsive')); ?>
	<?php echo $this->Html->link('Candidature Ingemedia', $url = array('action'=>'index','controller'=>'formations'), $options = array('class'=>'title large-4 small-6 columns'), $confirmMessage = false); ?>
	<div class="large-2 columns"><p> </p></div>
	<?php echo $this->Html->image('logo_univ.png',array('url'=>'http://www.univ-tln.fr/','class'=>'large-4 columns img-responsive logo-univ')); ?>
	</div>
    <?php 

    $verif_id = $this->Session->read('Etudiant.user_id');
        $verif_token = $this->Session->read('Etudiant.token');

     ?>
<?php if (!empty($verif_id) AND !empty($verif_token)): ?>
    <?php echo $this->element('connec'); ?>
<?php else: ?>
    <?php echo $this->element('non-connect'); ?>
<?php endif ?>
	<div class="in-content">
			<?php echo $this->fetch('content'); ?>


</div>
</div>
</div>
</div>
<div class="container">
<div class="row">

<footer class="large-12 footer">

<div class="large-3 columns">

<h3 class="large-12 title-footer ">A propos</h3>
<div class="large-12 content-footer">
Accueil

</div>
<div class="large-12 content-footer">
Contact

</div>
<div class="large-12 content-footer">
Information Candidature
</div>
<div class="large-12 content-footer">
Connexion

</div>
</div>

<div class="large-3 columns">
<h3 class="large-12 title-footer ">Les formations</h3>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>
<div class="large-12 content-footer">
Licence 2 Information et Communication

</div>


</div>

<div class="large-3 columns">
<h3 class="large-12 title-footer ">Ressources</h3>
<div class="large-12 content-footer">
Plateforme de stage

</div>
<div class="large-12 content-footer">
Emploi du temps

</div>


</div>

<div class="large-3 columns">

<h3 class="large-12 title-footer ">Mentions Légales</h3>
<div class="large-12 content-footer">
Contact

</div>
<div class="large-12 content-footer">
Plan du site

</div>
<div class="large-12 content-footer">
Mentions Légales
</div>
<div class="large-12 content-footer">
Université du sud Toulon/Var

</div>


</div>

<div class="large-12 columns">

<h3 class="wh">Partenaires :</h3>

</div>

</footer>			


</div>
</div>

						<?php 

echo $this->Html->script('bower_components/jquery/dist/jquery.min');
echo $this->Html->script('bower_components/foundation/js/foundation.min');
echo $this->Html->script('app');



?>
<script type="text/javascript">

$('#flashMessage').delay( 5000 ).hide( 400 ); 

</script>

</body>
</html>
