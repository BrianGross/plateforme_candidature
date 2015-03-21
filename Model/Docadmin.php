<?php
App::uses('AppModel', 'Model');
/**
 * Docadmin Model
 *
 * @property Annee $Annee
 */
class Docadmin extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Annee' => array(
			'className' => 'Annee',
			'foreignKey' => 'annee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Docetudiant' => array(
			'className' => 'Docetudiant',
			'foreignKey' => 'docadmin_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
		);
}
