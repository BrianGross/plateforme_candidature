<?php
App::uses('AppModel', 'Model');
/**
 * Annee Model
 *
 */
class Annee extends AppModel {

		public $hasMany = array(
		'Docadmin' => array(
            'className' => 'Docadmin'
		),
		'Formation' => array(
            'className' => 'Formation'
		)
		);

}
