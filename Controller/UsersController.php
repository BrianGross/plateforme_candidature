<?php
App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {

		if ($this->Auth->user('is_super_admin') != 1) {
			$this->redirect(array('action'=>'login'));
		}


		$this->User->recursive = 2;
		$this->set("superadmins",$this->User->find("all",array('conditions'=>array('User.is_super_admin'=>1))));
		$this->set("commissions",$this->User->find("all",array('conditions'=>array('AND'=>array('User.is_commission'=>1,'User.is_super_admin'=>0)))));
		$this->set("administrations",$this->User->find("all",array('conditions'=>array('AND'=>array('User.is_administration'=>1,'User.is_super_admin'=>0)))));

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		if ($this->Auth->user('is_super_admin') != 1) {
			$this->redirect(array('action'=>'login'));
		}

		//raccourci pour éviter de taper $this->request->data
		$d = $this->request->data;

		//Si la requête est en POST
		if ($this->request->is('post')) {

			// vérifier que les deux mots de passes sont identique
			if ($d["User"]["password"] != $d["User"]["confirm_password"]) {
				$this->Session->setFlash(__('Mot de passe non identique'));
				die();
			}

			// hashage du mot de passe
			$d["User"]["password"] = Security::hash($d["User"]["password"],null,true);

			// Si l'utilisateur n'est pas un membre de commission, définir le champs formation pour éviter les erreurs
			if (empty($d['User']['formation'])) {
				$d['User']['formation'] = 0;
			}

			// Définir l'utilisateur comme commission
			if ($d["User"]["statut"] == 'commission') {
				$d["User"]["is_commission"] = '1';
			}

			// Définir l'utilisateur comme administration
			if ($d["User"]["statut"] == 'administration') {
				$d["User"]["is_administration"] = '1';
			}

			// Définir l'utilisateur comme superadmin
			if ($d["User"]["statut"] == 'superadmin') {
				$d["User"]["is_commission"] = '1';
				$d["User"]["is_administration"] = '1';
				$d["User"]["is_super_admin"] = '1';
			}

			//sauvegarder la photo

			//Detection pour les membres de commissions
			$rand = rand(1000,1000000000);
			for ($i=1; $i <= 8; $i++) { 
				if (!empty($d['User']['check-'.$i])) {
					if (!empty($d['User']['stat'.$i])) {
						$d['Role']['formation'] = $d['User']['check-'.$i];
						$d['Role']['role'] = $d['User']['stat'.$i];
						$d['Role']['user_id'] = $rand;
						
						$this->User->Role->create();
			if ($this->User->Role->save($d,true,array("user_id","formation","role"))) {
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
			
					}
				}
			}

			//sauvegarde des données en base

			$this->User->create();
			if ($this->User->save($d,true,array("email","password","is_commission","is_administration","is_super_admin","nom","prenom"))) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'saverole',$d['User']['email'],$rand));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}

			
		}
	}

	public function saverole($email,$token) {
		$user_id = $this->User->find('first',array('conditions'=>array('User.email'=>$email)))['User']['id'];
		$roles = $this->User->Role->find('all',array('conditions'=>array('Role.user_id'=>$token)));

		
		foreach ($roles as $role) {
			$right[] = $role['Role']['id'];
		}

		for ($i=0; $i < count($roles) ; $i++) { 
			$this->User->Role->id = $this->User->Role->find('first',array('conditions'=>array('Role.id'=>$right[$i])));
			$this->User->Role->saveField('user_id',$user_id);
		}

		$this->redirect(array('action'=>'index'));

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login() {

			// Vérifier que les données sont envoyer en post
				if ($this->request->is("post")) {

			//Vérifier si les login sont correct
			if($this->Auth->login()) {
				//identier l'utilisateur
				$this->User->id = $this->Auth->user("id");

				//Rediriger les superadmins
				if ($this->Auth->user("is_super_admin") == 1) {
			$this->redirect(array("action"=>"superadmin"));
				$this->Session->setFlash("Vous êtes maintenant connecter","notif");
			}


			}else {
				$this->Session->setFlash("Identifiant incorrect","notif",array('type' => 'error'));
				
			}
		}

		// Si la session du superadmin n'est pas fermer, le rediriger
		if ($this->Auth->user("is_super_admin") == 1) {
			$this->redirect(array("action"=>"superadmin"));
				$this->Session->setFlash("Vous êtes maintenant connecter","notif");
			}

	}


	public function logout(){

		//déconnecter l'utilisateur
		$this->Auth->logout();
		$this->redirect(array("action"=>"index"));
	}


	public function superadmin(){
		if (!$this->Auth->user("is_super_admin")) {
			$this->redirect(array("action"=>"index"));
		}
	}

	public function listeAnnee(){
		
	}

}
