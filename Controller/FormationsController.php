<?php
App::uses('AppController', 'Controller');
/**
 * Formations Controller
 *
 * @property Formation $Formation
 * @property PaginatorComponent $Paginator
 */
class FormationsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $recursive = 2;

	public function index(){

		//on récupère l'année de candidature
		$date1 = date('Y');
		$date2 = date('Y') + 1;
		$current = $date1.'-'.$date2;
		$annee = $this->Formation->Annee->find('first',array('conditions'=>array('Annee.date'=>$current)));
		//debug($annee);
		$this->set('annee',$annee);

		//on récupère les formations de l'année de candidature
		$formations = $this->Formation->find('all',array('conditions'=>array('Formation.annee_id'=>$annee['Annee']['id'])));
		//debug($formations, $showHtml = null, $showFrom = true);
		$this->set('formations', $formations);


	}

	public function view($id) {
		$formation = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$id)));
		$this->set('formation', $formation);
	}

	public function addsession($id){
		if ($this->Auth->user('is_super_admin') != 1 OR  $this->Auth->user('is_administration') != 1) {
			$this->redirect($url = array('controller'=>'formations','action'=>'index'));
			die();
		}

		if ($this->request->is("post")) {
			$d = $this->request->data;


			$d['Session']['numero'] = $d['Formation']['numero'];
			/*
			$a = explode('/',$d['Formation']['date_ouverture']);
			$date_ouv = $a[2].'-'.$a[1].'-'.$a[0];


			$date1 = DateTime::createFromFormat('Y-n-j', $date_ouv);
			$rdate1 = date_format($date1, 'Y-n-j');

			$b = explode('/',$d['Formation']['date_fermeture']);
			$date_ferm = $b[2].'-'.$b[1].'-'.$b[0];

			$date2 = date_time_set('Y-n-j', $date_ferm);


			debug($date2);
			*/
			$d['Session']['date_ouverture'] = $d['Formation']['date_ouverture'];
			$d['Session']['date_fermeture'] = $d['Formation']['date_fermeture'];
			$d['Session']['formation_id'] = $id;
			
			
			$this->Formation->Session->create();
			if ($this->Formation->Session->save($d,true,array('date_ouverture','date_fermeture','formation_id','numero'))) {
				$this->Session->setFlash(__('La session a bien été sauvegarder'));
				return $this->redirect(array('action' => 'index'));
			}

			

		}

		$formation = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$id)));
			$this->set('formation', $formation);

	}

}
