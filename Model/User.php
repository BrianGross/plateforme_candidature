<?php
App::uses('AppModel', 'Model');
/**
 * Admin Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * Validation rules
 *
 * @var array
 */

	
	public $hasMany = array(
		'Role' => array(
            'className' => 'Role'
		)
		);


	public $validate = array(
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'avatar' => array(
			'rule' => array('fileExtension', array("jpg","png","jpeg")), "message" => "Vous ne pouvez uploader que des jpeg ou des png", 'allowEmpty' => true)
		);



		public function fileExtension($check,$extensions,$allowEmpty = true) {
			$file = current($check);
			if ($allowEmpty && empty($file["tmp_name"])) {
				return true;
			}
			$extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
			return in_array($extension, $extensions);
		}

		public function afterSave($created, $options = array()) {
			if (isset($this->data[$this->alias]['avatar'])) {
				$file = $this->data[$this->alias]['avatar'];
				$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
				if (!empty($file["tmp_name"])) {
					$oldextension = $this->field("avatar");
					$oldfile = IMAGES . "professeurs" . DS . $this->id . "." . $oldextension;
					if (file_exists($oldfile)) {
						unlink($oldfile);
					}
					move_uploaded_file($file['tmp_name'], IMAGES . "professeurs" . DS . $this->id . "." . $extension);
					$this->saveField("avatar", $extension);
				}

			}
		}
}
