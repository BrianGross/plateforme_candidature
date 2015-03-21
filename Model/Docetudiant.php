<?php
App::uses('AppModel', 'Model');
/**
 * Docetudiant Model
 *
 * @property Etudiant $Etudiant
 */
class Docetudiant extends AppModel {


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
		'Dossieradmission' => array(
			'className' => 'Dossieradmission',
			'foreignKey' => 'dossieradmission_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Docadmin' => array(
			'className' => 'Docadmin',
			'foreignKey' => 'docadmin_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
