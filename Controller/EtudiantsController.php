<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Etudiants Controller
 *
 * @property Etudiant $Etudiant
 * @property PaginatorComponent $Paginator
 */
class EtudiantsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Session');

	public function signup(){

		if ($this->request->is('post')) {
			$d = $this->request->data['Etudiant'];
			if ($d['email'] == $d['confirm_email']) {
				if ($d['mdp'] == $d['confirm_password']) {
					$da = $d['date_de_naissance'] = $d['date_de_naissance1'].'-'.$d['date_de_naissance2'].'-'.$d['date_de_naissance3'];
					$saave = sha1($d['mdp']);

					
					$this->Etudiant->create();
					if ($this->Etudiant->save($this->request->data,true,array('nom','nom_marital','prenom','date_de_naissance','ville_de_naissance','departement','pays_de_naissance','pays_de_nationalite','gender','adresse','adresse2','adresse3','cp','ville','tel_dom','tel_port','email','mdp'))) {
						$this->Etudiant->id = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.email'=>$d['email'])));
						$this->Etudiant->saveField('mdp',$saave);
						$this->Etudiant->saveField('date_de_naissance',$da);
						$token = uniqid();
						$this->Etudiant->saveField('token',$token);
						$this->Session->setFlash(__('Votre compte a été créé, vous pouvez maintenant vous enregistrer'));
						$this->Session->write('Etudiant.user_id', $this->Etudiant->id);
					$this->Session->write('Etudiant.token', $token);
						$this->redirect(array('action'=>'rappel_dossier',$this->Session->read('Redirect.session'),$this->Session->read('Redirect.formation')));
					} else {
						$this->Session->setFlash(__('Erreur lors de l\'inscription'));
					}
					


				} else {
					$this->Session->setFlash(__('Les deux mots de passe ne sont pas identiques'));
				}
				
			} else {
				$this->Session->setFlash(__('Les deux mails ne sont pas identiques'));
			}
			
		} 
		
		$this->loadModel('Pay');
		$pays = $this->Pay->find('all');
		$this->set('pays',$pays);

		$this->loadModel('Departement');
		$departements = $this->Departement->find('all');
		$this->set('departements',$departements);
		
	}

	public function rappel_dossier($session,$formation) {

		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
		
		if (!empty($session) AND !empty($formation)) {
		
		$this->loadModel('Formation');

		$verif1 = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)));
		$verif2 = $this->Formation->Session->find('first',array('conditions'=>array('Session.id'=>$session)));

		if (!empty($verif1) AND !empty($verif2)) {
				
		$now = date('Y-m-d');
		$now = '2015-04-03';

		if ($now >= $verif2['Session']['date_ouverture'] AND $now < $verif2['Session']['date_fermeture']) {
		
		$deja = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.etudiant_id'=>$verif_id,'Dossieradmission.session_id'=>$session))));

		if (empty($deja)) {
			$this->loadModel('Formation');		
		$this->loadModel('Docadmin');
		$this->loadModel('Annee');
		$id_annee = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)))['Formation']['annee_id'];
		$annee = $this->Annee->find('first',array('conditions'=>array('Annee.id'=>$id_annee)));	
		$docadmins = $this->Docadmin->find('all',array('conditions'=>array('Docadmin.annee_id'=>$id_annee)));
		$this->set('annee',$annee);
		$this->set('docadmins',$docadmins);
		$this->set('session_id',$session);
		$this->set('formation_id',$formation);
		$this->set('formation',$this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation))));
		} else {
			$this->Session->setFlash('Vous avez déjà candidater pour cette formation dans la session '.$verif2['Session']['numero']);
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
		} else {
			$this->Session->setFlash('Les sessions sont fermées pour l\'instant');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
			} else {
			$this->Session->setFlash('Erreur dans l\'url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			}
		} else {
			$this->Session->setFlash('Vous avez rentrer une fausse url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
		} else {
				$this->Session->setFlash(__('Vous devez disposer d\'un compte pour déposer une candidature'));
				$this->Session->write('Redirect.session', $session);
				$this->Session->write('Redirect.formation', $formation);
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}




	}


	public function choix($session,$formation) {

		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
		
		if (!empty($session) AND !empty($formation)) {
		
		$this->loadModel('Formation');

		$verif1 = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)));
		$verif2 = $this->Formation->Session->find('first',array('conditions'=>array('Session.id'=>$session)));

		if (!empty($verif1) AND !empty($verif2)) {
				
		$now = date('Y-m-d');
		$now = '2015-04-03';

		if ($now >= $verif2['Session']['date_ouverture'] AND $now < $verif2['Session']['date_fermeture']) {
		
		$this->set('session_id',$session);
		$this->set('formation_id',$formation);

		} else {
			$this->Session->setFlash('Les sessions sont fermées pour l\'instant');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
			} else {
			$this->Session->setFlash('Erreur dans l\'url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			}
		} else {
			$this->Session->setFlash('Vous avez rentrer une fausse url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
		} else {
				$this->Session->setFlash(__('Vous devez disposer d\'un compte pour déposer une candidature'));
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}




	}






	public function candidature($session,$formation) {

		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
		
		if (!empty($session) AND !empty($formation)) {
		
		$this->loadModel('Formation');

		$verif1 = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)));
		$verif2 = $this->Formation->Session->find('first',array('conditions'=>array('Session.id'=>$session)));

		if (!empty($verif1) AND !empty($verif2)) {
				
		$now = date('Y-m-d');
		$now = '2015-04-03';

		if ($now >= $verif2['Session']['date_ouverture'] AND $now < $verif2['Session']['date_fermeture']) {

			$deja = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.etudiant_id'=>$verif_id,'Dossieradmission.session_id'=>$session))));

		if (empty($deja)) {
			$this->set('formation',$verif1);
			$this->set('etudiant',$this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$verif_id))));

			$mmaster2 = $this->Formation->find('all',array('conditions'=>array('Formation.level'=>5)));
			$this->set('master2s',$mmaster2);

			$this->loadModel('Bac');
			$bacs = $this->Bac->find('all');
			$this->set('bacs',$bacs);

			$this->loadModel('Pay');
			$pays = $this->Pay->find('all');
			$this->set('pays',$pays);

			$this->loadModel('Diplome');
			$diplomes = $this->Diplome->find('all');
			$this->set('diplomes',$diplomes);


			if ($this->request->is('post')) {
				$d = $this->request->data['Etudiant'];
				
				
				//$this->set('cv',$this->request->data['Etudiant']['curriculum_vitae']);
				$code_cand = uniqid();
				$this->request->data['Dossieradmission']['COD_CAND'] = $code_cand;
				$this->request->data['Dossieradmission']['ETA_DOS'] = 99;
				$this->loadModel('Formation');
				$this->request->data['Dossieradmission']['COD_ETP'] = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)))['Formation']['COD_ETP'];
				$this->request->data['Dossieradmission']['CODE_PAYS_NAT'] = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$verif_id)))['Etudiant']['pays_de_nationalite'];
				$this->request->data['Dossieradmission']['PAYS_OBT_NAT'] = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$verif_id)))['Etudiant']['pays_de_nationalite'];
				$this->request->data['Dossieradmission']['PAYS_OBT_DIP'] = $this->request->data['Etudiant']['pays_etablissement'];
				$this->request->data['Dossieradmission']['CODE_COM'] = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$verif_id)))['Etudiant']['pays_de_nationalite'];
				$this->request->data['Dossieradmission']['BUR_DIST'] = $this->request->data['Etudiant']['pays_etablissement'];
				$this->request->data['Dossieradmission']['TYP_CAND'] = $this->request->data['Etudiant']['statut'];
				$this->request->data['Dossieradmission']['COD_AN'] = date('Y');
				$this->request->data['Dossieradmission']['etudiant_id'] = $verif_id;
				$this->request->data['Dossieradmission']['session_id'] = $session;
				$this->request->data['Dossieradmission']['annee_obtention'] = $this->request->data['Etudiant']['annee_obtention'];
				$this->request->data['Dossieradmission']['last_etablissement'] = $this->request->data['Etudiant']['last_etablissement'];
				$this->request->data['Dossieradmission']['annee_frequentation'] = $this->request->data['Etudiant']['annee_frequentation'];
				$this->request->data['Dossieradmission']['adresse_etablissement'] = $this->request->data['Etudiant']['adresse_etablissement'];
				$this->request->data['Dossieradmission']['ville_etablissement'] = $this->request->data['Etudiant']['ville_etablissement'];


				$this->request->data['Dossieradmission']['autres'] = $this->request->data['Etudiant']['autres'];
				$this->request->data['Dossieradmission']['nom_bac_2'] = $this->request->data['Etudiant']['nom_bac2'];
				if (!empty($this->request->data['Etudiant']['nom_bac3'])) {
									$this->request->data['Dossieradmission']['nom_bac_3'] = $this->request->data['Etudiant']['nom_bac3'];

				}
				if (!empty($this->request->data['Etudiant']['nom_bac4'])) {
				$this->request->data['Dossieradmission']['nom_bac_4'] = $this->request->data['Etudiant']['nom_bac4'];

				}
				$this->request->data['Dossieradmission']['bac'] = $this->request->data['Etudiant']['bac'];

				
				$this->Etudiant->Dossieradmission->create();
				if ($this->Etudiant->Dossieradmission->save($this->request->data,true,array('COD_CAND','CODE_COM','BUR_DIST','ETA_DOS','PAYS_OBT_NAT','CODE_PAYS_NAT','PAYS_OBT_DIP','TYP_CAND','COD_AN','etudiant_id','session_id','bac_2','bac_3','bac_4','bac','choix_1','choix_2','choix_3','autres','nom_bac_2','nom_bac_3','nom_bac_4','annee_obtention','last_etablissement','annee_frequentation','adresse_etablissement','ville_etablissement'))) {
				
	$numeroAttribuer = $this->Etudiant->Dossieradmission->find('first',array('order'=>'Dossieradmission.id DESC'))['Dossieradmission']['id'];

	$this->Etudiant->Dossieradmission->id = $numeroAttribuer;
	
	if($numeroAttribuer <=9) {$codecand= "214800000".$numeroAttribuer;}
	if(($numeroAttribuer >9) && ($numeroAttribuer <=99)){ $codecand= "21480000".$numeroAttribuer;}
	if(($numeroAttribuer >99) && ($numeroAttribuer <=999)) {$codecand= "2148000".$numeroAttribuer;}
	if(($numeroAttribuer >999) && ($numeroAttribuer <=9999)){ $codecand= "214800".$numeroAttribuer;}
	if(($numeroAttribuer >9999) && ($numeroAttribuer <=99999)) {$codecand= "21480".$numeroAttribuer;}
	
	$this->Etudiant->Dossieradmission->saveField('COD_CAND',$codecand);

	$this->Etudiant->Dossieradmission->saveField('bac_2',$this->request->data['Etudiant']['bac_2']);
	$this->Etudiant->Dossieradmission->saveField('bac_3',$this->request->data['Etudiant']['bac_3']);
	$this->Etudiant->Dossieradmission->saveField('bac_4',$this->request->data['Etudiant']['bac_4']);

	if (empty($this->request->data['Etudiant']['choix_1'])) {
					$this->Etudiant->Dossieradmission->saveField('choix_1',$this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)))['Formation']['id']);
				} else {
					$this->Etudiant->Dossieradmission->saveField('choix_1',  $this->request->data['Etudiant']['choix_1']);
						$this->Etudiant->Dossieradmission->saveField('choix_2',  $this->request->data['Etudiant']['choix_2']);
						$this->Etudiant->Dossieradmission->saveField('choix_3',  $this->request->data['Etudiant']['choix_3']);
				}

	$this->redirect($url = array('action'=>'download','controller'=>'etudiants',$this->Etudiant->Dossieradmission->id));

				} else {
					$this->Session->setFlash('Erreur');
				}
				
			}
		} else {
		$this->Session->setFlash('Vous avez déjà postuler pour cette formation dans la session '.$verif2['Session']['numero']);
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
	}
		} else {
			$this->Session->setFlash('Les sessions sont fermées pour l\'instant');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
			} else {
			$this->Session->setFlash('Erreur dans l\'url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			}
		} else {
			$this->Session->setFlash('Vous avez rentrer une fausse url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			

		}

		} else {
				$this->Session->setFlash(__('Vous devez disposer d\'un compte pour déposer une candidature'));
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}

		
	}


	public function download($id) {
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$id,'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {
					

			$this->loadModel('Docadmin');
			$this->loadModel('Annee');

			$date = date('Y');
			$real_date = $date.'-';
			$real_date .= $date + 1;
			$this->set('annee',$this->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date))));
			$annee = $this->Docadmin->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date)));
			$docadmins = $this->Docadmin->find('all',array('conditions'=>array('Docadmin.annee_id'=>$annee['Annee']['id'])));
			$this->set('docadmins',$docadmins);
			$this->set('id',$id);
			$downloads = $this->Etudiant->Docetudiant->find('all',array('conditions'=>array('AND'=>array('Docetudiant.etudiant_id'=>$verif_id,'Docetudiant.dossieradmission_id'=>$id))));
			$this->set('downloads',$downloads);
			
			
			if ($this->request->is('post')) {
				$file=$this->request->data['Etudiant']['doc'];
       			$coucou = $this->sanitize($this->request->data['Etudiant']['doc']['name']);
       			$rand = uniqid();
				$extention = strtolower(pathinfo($this->request->data["Etudiant"]["doc"]["name"], PATHINFO_EXTENSION));
						if (!empty($this->request->data["Etudiant"]["doc"]["tmp_name"]) && in_array($extention,array("jpg","png","pdf"))) {

							if (move_uploaded_file($this->request->data["Etudiant"]["doc"]["tmp_name"], IMAGES . 'etudiant-'. $real_date . DS . $verif_id.'_'.$rand.'_'.$coucou)) {
								$this->request->data['Docetudiant']['file'] = $verif_id.'_'.$rand.'_'.$coucou;
								$this->request->data['Docetudiant']['dossieradmission_id'] = $id;
								$this->request->data['Docetudiant']['etudiant_id'] = $verif_id;
							$this->Etudiant->Docetudiant->create();
							if ($this->Etudiant->Docetudiant->save($this->request->data,true,array('file','etudiant_id','session_id'))) {
								$this->Etudiant->Docetudiant->saveField('dossieradmission_id',$id);
							$this->Session->setFlash(__('Le fichier a bien été téléchargé'));
							$this->redirect($url = array('action'=>'download',$id));
								}	
							}
							
						}
					else {
					$this->Session->setFlash(__('Vous ne pouvez uploader que des pdf ou alors le fichier est trop lourd'));
			$this->redirect($url = array('action'=>'download',$id));
					}
			}
			

				} else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
						}else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour enregistrer des fichiers');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}

	}

	public function download_spe(){
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$this->request->data['Etudiant']['id_da'],'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {
					
			$this->loadModel('Docadmin');
			$this->loadModel('Annee');

			$date = date('Y');
			$real_date = $date.'-';
			$real_date .= $date + 1;
			/*
			$this->set('annee',$this->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date))));
			$annee = $this->Docadmin->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date)));
			$docadmins = $this->Docadmin->find('all',array('conditions'=>array('Docadmin.annee_id'=>$annee['Annee']['id'])));
			$this->set('docadmins',$docadmins);
			$this->set('id',$id);
			$downloads = $this->Etudiant->Docetudiant->find('all',array('conditions'=>array('AND'=>array('Docetudiant.etudiant_id'=>$verif_id,'Docetudiant.dossieradmission_id'=>$id))));
			$this->set('downloads',$downloads);
			*/
			
			if ($this->request->is('post')) {
				$file=$this->request->data['Etudiant']['doc'];
       			$coucou = $this->sanitize($this->request->data['Etudiant']['doc']['name']);
       			$rand = uniqid();
				$extention = strtolower(pathinfo($this->request->data["Etudiant"]["doc"]["name"], PATHINFO_EXTENSION));
						if (!empty($this->request->data["Etudiant"]["doc"]["tmp_name"]) && in_array($extention,array("jpg","png","pdf"))) {
							$in = $this->Etudiant->Docetudiant->find('first',array('conditions'=>array('AND'=>array('Docetudiant.etudiant_id'=>$verif_id,'Docetudiant.docadmin_id'=>$this->request->data['Etudiant']['id'],'Docetudiant.dossieradmission_id'=>$this->request->data['Etudiant']['id_da']))));
							debug($in);
							if (!empty($in)) {
					$this->Etudiant->Docetudiant->id = $in['Docetudiant']['id'];
				if ($this->Etudiant->Docetudiant->delete($this->Etudiant->Docetudiant->id)) {
					unlink(IMAGES . DS . 'etudiant-' . $real_date . DS . $in['Docetudiant']['file']);
				} 
							}
							if (move_uploaded_file($this->request->data["Etudiant"]["doc"]["tmp_name"], IMAGES . 'etudiant-'. $real_date . DS . $verif_id.'_'.$rand.'_'.$coucou)) {
								$this->request->data['Docetudiant']['file'] = $verif_id.'_'.$rand.'_'.$coucou;
								$this->request->data['Docetudiant']['docadmin_id'] = $this->request->data['Etudiant']['id'];
								$this->request->data['Docetudiant']['dossieradmission_id'] = $this->request->data['Etudiant']['id_da'];
								$this->request->data['Docetudiant']['etudiant_id'] = $verif_id;
							$this->Etudiant->Docetudiant->create();
							if ($this->Etudiant->Docetudiant->save($this->request->data,true,array('file','etudiant_id','dossieradmission_id','docadmin_id'))) {
								$this->Etudiant->Docetudiant->saveField('dossieradmission_id',$this->request->data['Etudiant']['id_da']);
							
							if (!empty($this->request->data['Etudiant']['redirect'])) {
								$this->Session->setFlash(__('Le fichier a bien été téléchargé'));
								$this->redirect($url = array('action'=>'edit_da',$this->request->data['Etudiant']['id_da']));
							} else {
								$this->Session->setFlash(__('Le fichier a bien été téléchargé'));
								$this->redirect($url = array('action'=>'download',$this->request->data['Etudiant']['id_da']));
							}
							
								}	
							}
						}
					else {
						if (!empty($this->request->data['Etudiant']['redirect'])) {
								$this->Session->setFlash(__('Vous ne pouvez uploader que des pdf ou alors le fichier est trop lourd'));
			$this->redirect($url = array('action'=>'edit_da',$this->request->data['Etudiant']['id_da']));
							} else {
								$this->Session->setFlash(__('Vous ne pouvez uploader que des pdf ou alors le fichier est trop lourd'));
			$this->redirect($url = array('action'=>'download',$this->request->data['Etudiant']['id_da']));
							}
					
					}
			}
			
			debug($this->request->data, $showHtml = null, $showFrom = true);

				} else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
						}else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour enregistrer des fichiers');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}

	}

	public	function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]","}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;","â€”", "â€“", ",", "<",">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}


	public function login(){
		if ($this->request->is('post')) {
			$d = $this->request->data['Etudiant'];
			if (!empty($d['email']) AND !empty($d['mdp'])) {
				$email = $d['email'];
				$mdp = $d['mdp'];
				$verif = $this->Etudiant->find('first',array('conditions'=>array('AND'=>array('Etudiant.email'=>$email,'Etudiant.mdp'=>sha1($mdp)))));
				if (!empty($verif)) {
					$id = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.email'=>$email)))['Etudiant']['id'];
					$token = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.email'=>$email)))['Etudiant']['token'];
					$nom = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.email'=>$email)))['Etudiant']['nom'];
					$prenom = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.email'=>$email)))['Etudiant']['prenom'];
					$this->Session->write('Etudiant.user_id', $id);
					$this->Session->write('Etudiant.token', $token);
					$this->Session->setFlash(__('Bienvenue, '.$prenom.' '.$nom));
					$this->redirect(array('action'=>'index',$verif['Etudiant']['id'],$verif['Etudiant']['token']));
				} else {
					$this->Session->setFlash(__('Informations incorrect'));
				}
				
			} else {
				$this->Session->setFlash(__('Vous avez oublié un champs'));
			}
			
		}
	}

	public function index($id,$token){
		$this->recursive = 2;
		$etudiant = $this->Etudiant->find('first',array('conditions'=>array('AND'=>array('Etudiant.id'=>$id,'Etudiant.token'=>$token))));
		if (!empty($etudiant)) {
			$sess_id = $this->Session->read('Etudiant.user_id');
			$sess_token = $this->Session->read('Etudiant.token');
			if ($sess_id == $id AND $sess_token == $token) {
				$this->set('etudiant',$etudiant);
				$this->loadModel('Formation');
				$this->set('formations',$this->Formation->find('all'));
				$this->loadModel('Session');
				$this->set('sessions',$this->Session->find('all'));
				$this->loadModel('Annee');
				$this->set('annees',$this->Annee->find('all'));
			} else {
				$this->redirect(array('controller'=>'formations','action'=>'index'));
			}
			
		} else {
			$this->redirect(array('controller'=>'formations','action'=>'index'));
		}
		
	}

	public function logout(){
		$this->Session->write('Etudiant.user_id', false);
		$this->Session->write('Etudiant.token', false);
		$this->Session->setFlash(__('Vous êtes maintenant déconnecté(e)'));
		$this->redirect(array('controller'=>'formations','action'=>'index'));
	}


	public function sendfile($id,$date,$name,$extention) {
    $this->response->file(WWW_ROOT.'files/docadmin-'.$date.'/'. $id .'.' . $extention, array('download' => true, 'name' => $name.''.$file));
    //Retourne un objet reponse pour éviter que le controller n'essaie de
    // rendre la vue
    return $this->response;
}

public function sendfilestudent($name,$annee) {
	 $this->response->file(IMAGES . 'etudiant-'.$annee . '/' . $name);
    //Retourne un objet reponse pour éviter que le controller n'essaie de
    // rendre la vue
    return $this->response;
}

public function deletefilestudent($id,$id_da) {
	$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
			$verif_file = $this->Etudiant->Docetudiant->find('first',array('conditions'=>array('AND'=>array('Docetudiant.etudiant_id'=>$verif_id,'Docetudiant.id'=>$id))));

			if (!empty($verif_file)) {
				$this->Etudiant->Docetudiant->id = $id;
				if ($this->Etudiant->Docetudiant->delete($id)) {
					$date = date('Y');
			$real_date = $date.'-';
			$real_date .= $date + 1;
					unlink(IMAGES . DS . 'etudiant-' . $real_date . DS . $verif_file['Docetudiant']['file']);
					$this->Session->setFlash(__('Le fichier a bien été supprimer'));
			$this->redirect($url = array('action'=>'download',$id_da));
				} else {
					$this->Session->setFlash(__('Une erreur est survenue'));
			$this->redirect($url = array('action'=>'download',$id_da));
				}
				
			} else {
				$this->Session->setFlash(__('Vous ne pouvez pas supprimer le fichier d\'un autre étudiant'));
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			}
			


		}
		else {
			$this->Session->setFlash(__('Vous devez disposer d\'un compte pour supprimer les fichiers'));
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}
}

	public function info_perso($session,$formation) {


		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
		
		if (!empty($session) AND !empty($formation)) {
		
		$this->loadModel('Formation');

		$verif1 = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)));
		$verif2 = $this->Formation->Session->find('first',array('conditions'=>array('Session.id'=>$session)));

		if (!empty($verif1) AND !empty($verif2)) {
				
		$now = date('Y-m-d');
		$now = '2015-04-03';

		if ($now >= $verif2['Session']['date_ouverture'] AND $now < $verif2['Session']['date_fermeture']) {
		
		
		$etudiant = $this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$this->Session->read('Etudiant.user_id'))));
		$this->set('etudiant',$etudiant);

		$this->loadModel('Pay');
		$this->set('pays',$this->Pay->find('all'));
		$this->request->data =  $etudiant;
		$pays_de_naissance = $this->Pay->find('first',array('conditions'=>array('Pay.COD_PAY'=>$etudiant['Etudiant']['pays_de_naissance'])));
		$pays1 = $pays_de_naissance['Pay']['LIB_PAY'];
		$this->set('pays_de_naissance',$pays1);
		$pays_de_nationalite = $this->Pay->find('first',array('conditions'=>array('Pay.COD_PAY'=>$etudiant['Etudiant']['pays_de_nationalite'])));
		$pays2 = $pays_de_nationalite['Pay']['LIB_PAY'];
		$this->set('pays_de_nationalite',$pays2);
		$this->loadModel('Departement');
		$this->set('departements',$this->Departement->find('all'));
		$dep = $this->Departement->find('first',array('conditions'=>array('Departement.COD_DEP'=>$etudiant['Etudiant']['departement'])));
		$dep1 = $dep['Departement']['LIB_DEP'];
		$this->set('departement_real',$dep1);
		$this->set('session_id',$session);
		$this->set('session_id',$session);
		$this->set('formation_id',$formation);

		} else {
			$this->Session->setFlash('Les sessions sont fermées pour l\'instant');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
			} else {
			$this->Session->setFlash('Erreur dans l\'url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
			}
		} else {
			$this->Session->setFlash('Vous avez rentrer une fausse url');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
		}
		} else {
				$this->Session->setFlash(__('Vous devez disposer d\'un compte pour déposer une candidature'));
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}



	}

	public function edit(){
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
				if ($this->request->is('post')) {
					$this->Etudiant->id = $verif_id;
					$session = $this->request->data['Etudiant']['sess'];
					$formation = $this->request->data['Etudiant']['form'];
					if ($this->Etudiant->save($this->request->data)) {
					if (!empty($session) AND !empty($formation)) {
						$this->Session->setFlash('Vos informations ont été sauvegardées');
							$this->redirect($url = array('action'=>'info_perso','controller'=>'etudiants',$session,$formation));
					} else {
						$this->Session->setFlash('Vos informations ont été sauvegardées');
							$this->redirect($url = array('action'=>'index','controller'=>'etudiants',$verif_id,$verif_token));
					}
					
					} else {
						$this->Session->setFlash('Erreur');
							$this->redirect($url = array('action'=>'info_perso','controller'=>'etudiants',$session,$formation));
					}
					}
		 else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour éditer votre compte');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}
	}

	}

	public function confirmation($id){
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$id,'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {
					
			$this->Etudiant->Dossieradmission->id = $id;

			if ($this->Etudiant->Dossieradmission->saveField('is_post',1)) {
				$this->set('dossier',$this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('Dossieradmission.id'=>$id))));
			} else {
				$this->Session->setFlash('Une erreur est survenue');
			$this->redirect($url = array('action'=>'download',$id));
			}


			}
			

				else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
						}else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour enregistrer des fichiers');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}

	}

	public function edit_da($id) {
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$id,'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {


			$this->loadModel('Docadmin');
			$this->loadModel('Annee');

			$date = date('Y');
			$real_date = $date.'-';
			$real_date .= $date + 1;
			$this->set('annee',$this->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date))));
			$annee = $this->Docadmin->Annee->find('first',array('conditions'=>array('Annee.date'=>$real_date)));
			$docadmins = $this->Docadmin->find('all',array('conditions'=>array('Docadmin.annee_id'=>$annee['Annee']['id'])));
			$this->set('docadmins',$docadmins);
			$this->set('id',$id);
			$downloads = $this->Etudiant->Docetudiant->find('all',array('conditions'=>array('AND'=>array('Docetudiant.etudiant_id'=>$verif_id,'Docetudiant.dossieradmission_id'=>$id))));
			$this->set('downloads',$downloads);
			
			
			if ($this->request->is('post')) {
				$file=$this->request->data['Etudiant']['doc'];
       			$coucou = $this->sanitize($this->request->data['Etudiant']['doc']['name']);
       			$rand = uniqid();
				$extention = strtolower(pathinfo($this->request->data["Etudiant"]["doc"]["name"], PATHINFO_EXTENSION));
						if (!empty($this->request->data["Etudiant"]["doc"]["tmp_name"]) && in_array($extention,array("jpg","png","pdf"))) {

							if (move_uploaded_file($this->request->data["Etudiant"]["doc"]["tmp_name"], IMAGES . 'etudiant-'. $real_date . DS . $verif_id.'_'.$rand.'_'.$coucou)) {
								$this->request->data['Docetudiant']['file'] = $verif_id.'_'.$rand.'_'.$coucou;
								$this->request->data['Docetudiant']['dossieradmission_id'] = $id;
								$this->request->data['Docetudiant']['etudiant_id'] = $verif_id;
							$this->Etudiant->Docetudiant->create();
							if ($this->Etudiant->Docetudiant->save($this->request->data,true,array('file','etudiant_id','session_id'))) {
								$this->Etudiant->Docetudiant->saveField('dossieradmission_id',$id);
							$this->Session->setFlash(__('Le fichier a bien été téléchargé'));
							$this->redirect($url = array('action'=>'download',$id));
								}	
							}
							
						}
					else {
					$this->Session->setFlash(__('Vous ne pouvez uploader que des pdf ou alors le fichier est trop lourd'));
			$this->redirect($url = array('action'=>'download',$id));
					}
			}

			

			}	else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
						}else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour enregistrer des fichiers');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}
	}

	public function edit_info_da($id,$formation) {
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
		
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$id,'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {

		$this->loadModel('Formation');
		$verif1 = $this->Formation->find('first',array('conditions'=>array('Formation.id'=>$formation)));
				

			$this->set('formation',$verif1);
			$this->set('etudiant',$this->Etudiant->find('first',array('conditions'=>array('Etudiant.id'=>$verif_id))));

			$mmaster2 = $this->Formation->find('all',array('conditions'=>array('Formation.level'=>5)));
			$this->set('master2s',$mmaster2);

			$this->loadModel('Bac');
			$bacs = $this->Bac->find('all');
			$this->set('bacs',$bacs);

			$this->loadModel('Pay');
			$pays = $this->Pay->find('all');
			$this->set('pays',$pays);

			$this->loadModel('Diplome');
			$diplomes = $this->Diplome->find('all');
			$this->set('diplomes',$diplomes);
			$this->set('id',$id);
			$this->set('formation_id',$formation);
			$this->request->data['Etudiant'] = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('Dossieradmission.id'=>$id)))['Dossieradmission'];
			$this->request->data['Etudiant']['pays_etablissement'] = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('Dossieradmission.id'=>$id)))['Dossieradmission']['PAYS_OBT_DIP'];
			}	else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
		} else {
				$this->Session->setFlash(__('Vous devez disposer d\'un compte pour déposer une candidature'));
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}
	
}

	public function edit_da_after() {
		$verif_id = $this->Session->read('Etudiant.user_id');
		$verif_token = $this->Session->read('Etudiant.token');
		
		if (!empty($verif_id) AND !empty($verif_token)) {
				
		$verif_dossier = $this->Etudiant->Dossieradmission->find('first',array('conditions'=>array('AND'=>array('Dossieradmission.id'=>$this->request->data['Etudiant']['id'],'Dossieradmission.etudiant_id'=>$verif_id))));
		
		if (!empty($verif_dossier)) {

			if ($this->request->is('post')) {
				
				$this->Etudiant->Dossieradmission->id = $this->request->data['Etudiant']['id'];
				$this->loadModel('Formation');
				$this->request->data['Dossieradmission']['PAYS_OBT_DIP'] = $this->request->data['Etudiant']['pays_etablissement'];
				$this->request->data['Dossieradmission']['BUR_DIST'] = $this->request->data['Etudiant']['pays_etablissement'];
				$this->request->data['Dossieradmission']['annee_obtention'] = $this->request->data['Etudiant']['annee_obtention'];
				$this->request->data['Dossieradmission']['last_etablissement'] = $this->request->data['Etudiant']['last_etablissement'];
				$this->request->data['Dossieradmission']['annee_frequentation'] = $this->request->data['Etudiant']['annee_frequentation'];
				$this->request->data['Dossieradmission']['adresse_etablissement'] = $this->request->data['Etudiant']['adresse_etablissement'];
				$this->request->data['Dossieradmission']['ville_etablissement'] = $this->request->data['Etudiant']['ville_etablissement'];


				$this->request->data['Dossieradmission']['autres'] = $this->request->data['Etudiant']['autres'];
				$this->request->data['Dossieradmission']['nom_bac_2'] = $this->request->data['Etudiant']['nom_bac_2'];
				if (!empty($this->request->data['Etudiant']['nom_bac_3'])) {
				$this->request->data['Dossieradmission']['nom_bac_3'] = $this->request->data['Etudiant']['nom_bac_3'];

				}
				if (!empty($this->request->data['Etudiant']['nom_bac_4'])) {
				$this->request->data['Dossieradmission']['nom_bac_4'] = $this->request->data['Etudiant']['nom_bac_4'];

				}
				$this->request->data['Dossieradmission']['bac'] = $this->request->data['Etudiant']['bac'];
								if ($this->Etudiant->Dossieradmission->save($this->request->data,true,array('BUR_DIST','PAYS_OBT_DIP','bac_2','bac_3','bac_4','bac','choix_1','choix_2','choix_3','autres','nom_bac_2','nom_bac_3','nom_bac_4','annee_obtention','last_etablissement','annee_frequentation','adresse_etablissement','ville_etablissement'))) {
				

	$this->Etudiant->Dossieradmission->saveField('bac_2',$this->request->data['Etudiant']['bac_2']);
	$this->Etudiant->Dossieradmission->saveField('bac_3',$this->request->data['Etudiant']['bac_3']);
	$this->Etudiant->Dossieradmission->saveField('bac_4',$this->request->data['Etudiant']['bac_4']);

	if (empty($this->request->data['Etudiant']['choix_1'])) {
					$this->Etudiant->Dossieradmission->saveField('choix_1',$this->Formation->find('first',array('conditions'=>array('Formation.id'=>$this->request->data['Etudiant']['formation_id'])))['Formation']['id']);
				} else {
					$this->Etudiant->Dossieradmission->saveField('choix_1',  $this->request->data['Etudiant']['choix_1']);
						$this->Etudiant->Dossieradmission->saveField('choix_2',  $this->request->data['Etudiant']['choix_2']);
						$this->Etudiant->Dossieradmission->saveField('choix_3',  $this->request->data['Etudiant']['choix_3']);
				}
		$this->Session->setFlash('Les informations ont bien été enregistrées');
	$this->redirect($url = array('action'=>'edit_info_da','controller'=>'etudiants',$this->request->data['Etudiant']['id'],$this->request->data['Etudiant']['formation_id']));

				} else {
					$this->Session->setFlash('Erreur');
				}
				
			}
			

			}	else {
					$this->Session->setFlash('Vous n\'êtes pas le propriétaire du compte');
			$this->redirect($url = array('action'=>'index','controller'=>'formations'));
				}
						}else {
			$this->Session->setFlash('Vous devez disposer d\'un compte pour enregistrer des fichiers');
			$this->redirect($url = array('action'=>'signup','controller'=>'etudiants'));
		}
	}


	public function oldetudiant(){

	}

}
