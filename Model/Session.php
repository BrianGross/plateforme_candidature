<?php
App::uses('AppModel', 'Model');
/**
 * Session Model
 *
 * @property Formation $Formation
 */
class Session extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Formation' => array(
			'className' => 'Formation',
			'foreignKey' => 'formation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Dossieradmission' => array(
			'className' => 'Dossieradmission',
			'foreignKey' => 'session_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)

		);

	

}
