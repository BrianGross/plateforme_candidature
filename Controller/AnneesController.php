<?php
App::uses('AppController', 'Controller');
/**
 * Annees Controller
 *
 * @property Annee $Annee
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AnneesController extends AppController {

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
		$this->Annee->recursive = 0;
		$this->set('annees', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Annee->exists($id)) {
			throw new NotFoundException(__('Invalid annee'));
		}
		$options = array('conditions' => array('Annee.' . $this->Annee->primaryKey => $id));
		$this->set('annee', $this->Annee->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		$d = $this->request->data;

		if ($this->request->is('post')) {

			$this->Annee->create();
			if ($this->Annee->save($this->request->data,true,array('date'))) {
				$this->Session->setFlash(__('The annee has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The annee could not be saved. Please, try again.'));
			}
			
		}


		$currentdate = $this->Annee->find('first',array('order'=>'Annee.id DESC'));

		if (empty($currentdate)) {
			for ($i=0; $i < 21; $i++) { 
			$annee1 = $i + 2015;
			$annee2 = $i + 2016;
			$options[$annee1.'-'.$annee2] = $annee1.'-'.$annee2;
			}
		} else {
			for ($i=0; $i < 21; $i++) {
			$explode = explode('-', $currentdate['Annee']['date']);
			$annee1 = $explode[0] + $i + 1;
			$annee2 = $explode[1] + $i + 1;
			$options[$annee1.'-'.$annee2] = $annee1.'-'.$annee2;
			}
		}


		$this->set('options',$options);

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Annee->exists($id)) {
			throw new NotFoundException(__('Invalid annee'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Annee->save($this->request->data)) {
				$this->Session->setFlash(__('The annee has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The annee could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Annee.' . $this->Annee->primaryKey => $id));
			$this->request->data = $this->Annee->find('first', $options);
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
		$this->Annee->id = $id;
		if (!$this->Annee->exists()) {
			throw new NotFoundException(__('Invalid annee'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Annee->delete()) {
			$this->Session->setFlash(__('The annee has been deleted.'));
		} else {
			$this->Session->setFlash(__('The annee could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function addfichier() {

	}

	public function listefichier($id) {
		$fichiers = $this->Annee->Fichier->find('all',array('conditions'=>array('Fichier.annee_id'=>$id)));

		$this->set('fichiers', $fichiers);
	}

}
