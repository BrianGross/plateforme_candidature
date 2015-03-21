<?php
App::uses('AppModel', 'Model');
/**
 * Dossieradminission Model
 *
 * @property Etudiant $Etudiant
 * @property Formation $Formation
 */
class Dossieradmission extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Etudiant' => array(
			'className' => 'Etudiant',
			'foreignKey' => 'etudiant_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Session' => array(
			'className' => 'Session',
			'foreignKey' => 'session_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Docetudiant' => array(
			'className' => 'Docetudiant',
			'foreignKey' => 'dossieradmission_id',
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
