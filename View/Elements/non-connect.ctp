<div class="large-12 columns text-center menu">

	<?php $menu_item = array($this->params['controller'],$this->params['action']); ?>

		<?php if (!empty($menu_item)): ?>
			<?php if ($menu_item[0] == 'formations' AND $menu_item[1] == 'index') {
				$actif[0] = 'actif';
				$actif[1] = '';
				$actif[2] = '';
				$actif[3] = '';
				}
				elseif ($menu_item[0] == 'users' AND $menu_item[1] == 'contact') {
				$actif[0] = '';
				$actif[1] = 'actif';
				$actif[2] = '';
				$actif[3] = '';
				}
				elseif ($menu_item[0] == 'annees' AND $menu_item[1] == 'info') {
				$actif[0] = '';
				$actif[1] = '';
				$actif[2] = 'actif';
				$actif[3] = '';
				}
				elseif ($menu_item[0] == 'etudiants' AND $menu_item[1] == 'login') {
				$actif[0] = '';
				$actif[1] = '';
				$actif[2] = '';
				$actif[3] = 'actif';
			} else {
				$actif[0] = '';
				$actif[1] = '';
				$actif[2] = '';
				$actif[3] = '';
			}  ?>
		<?php endif ?>
		<?php echo $this->Html->link('ACCUEIL', $url = array('action'=>'index','controller'=>'formations'), $options = array('class'=>'link-menu '.$actif[0]), $confirmMessage = false); ?>	

		<?php echo $this->Html->link('CONTACT', $url = array('action'=>'contact','controller'=>'users'), $options = array('class'=>'link-menu '.$actif[1]), $confirmMessage = false); ?>

		<?php echo $this->Html->link('INFORMATION CANDIDATURE', $url = array('action'=>'info','controller'=>'annees'), $options = array('class'=>'link-menu '.$actif[2]), $confirmMessage = false); ?>

		<?php echo $this->Html->link('CONNEXION', $url = array('action'=>'login','controller'=>'etudiants'), $options = array('class'=>'link-menu '.$actif[3]), $confirmMessage = false); ?>

	</div>
