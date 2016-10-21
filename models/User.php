<?php
class User_Model extends Model {
	//Ne pas mettre de constructeur !! => dêja parent
	var $validateLogin = array(
		'email' => array(
					array('rule' => 'email', 'message' => "Votre email n'est pas valide"),
					array('rule' => 'notEmpty', 'message' => 'Votre email ne peut pas être vide')
				),
		'password' => array(
						array('rule' => 'notEmpty','message' => "Le mot de passe ne peut pas être vide")
				)
	);

	var $validateForgot = array(
		'email' => array(
			array('rule' => 'email', 'message' => "Veillez entré une adresse email correcte"),
			array('rule' => 'notEmpty', 'message' => 'Veillez entré votre adresse email')
		),
	);

	var $validateRegister = array(
		'last_name' => array(
					array('rule' => '^[\w\d]{3,40}$', 'message' => "Votre nom n'est pas valide"),
					array('rule' => 'notEmpty', 'message' => 'Votre nom ne peut pas être vide')
				),
		'name' => array(
					array('rule' => '^[\w\d]{3,40}$', 'message' => "Votre prenom n\'est pas valide"),
					array('rule' => 'notEmpty', 'message' => 'Votre prenom ne peut pas être vide')
				),
		'username' => array(
					array('rule' => 'notDuplicate', 'model' => 'users', 'message' => "Ce nom d'utilisateur est dêja utilisé"),
					array('rule' => 'limit-length', 'min' => 4, 'max' => 30, 'message' => "Votre nom d'utilisateur n'est pas valide (min 4 - max 30 caractères)"),
					array('rule' => 'notEmpty', 'message' => 'Veuillez entrez un nom d\'utilisateur')
				),
		'date_birth' => array(
					array('rule' => '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$', 'message' => "Votre date de naissance n'est pas valide"),
					array('rule' => 'notEmpty', 'message' => 'Veuillez entrez votre date de naissance')
				),
		'country' => array(
					array('rule' => 'notEmpty', 'message' => 'Veuillez selectionner votre pays')
				),
		'email' => array(
					array('rule' => 'email', 'message' => "Votre email n'est pas valide"),
					array('rule' => 'notDuplicate', 'model' => 'users', 'message' => 'Cette adresse email est dêja utilisé'),
					array('rule' => 'notEmpty', 'message' => 'Votre email ne peut pas être vide')
				),
		'password' => array(
					array('rule' => 'comparer', 'comparant' => 'password_confirm', 'message' => 'Le mot de passe n\'est pas identique au mot de passe de confirmation'),
					array('rule' => 'limit-length', 'min' => 6, 'max' => 30, 'message' => 'Mot de Passe non valide: (min 6 - max 30 caractères)'),
					array('rule' => 'notEmpty', 'message' => 'Veuillez entrez un mot de passe'),
				),
		'password_confirm' => array(
					array('rule' => 'notEmpty', 'message' => 'Veuillez entrez un mot de passe'),
					array('rule' => 'notEmpty', 'message' => "Veuillez entrez le mot de passe de confirmation"),
				),
	);

	var $validateAccount = array(
		'last_name' => array(
					array('rule' => '^[\w\d]{3,40}$','message' => 'Votre nom n\'est pas valide'),
					array('rule' => 'notEmpty', 'message' => 'Veuillez entrez votres prenom')
				),
		'name' => array(
					array('rule' => 'notEmpty','message' => 'Veuillez entrez votres nom'),
					array('rule' => '^[\w\d]{3,40}$','message' => 'Votre prenom n\'est pas valide')
				),
		'pseudo' => array(
					array('rule' => 'limit-length', 'min' => 3, 'max' => 40, 'message' => 'Votre Pseudo n\'est pas valide (min 3 - max 40 caractères)'),
					array('rule' => 'notEmpty','message' => 'Veuillez entrez un Pseudo')
				),
	);

	var $validatePassword = array(
		'password' => array(
					array('rule' => 'comparer','comparant' => 'password_confirm','message' => 'Le mot de passe n\'est pas identique au mot de passe de confirmation'),
					array('rule' => 'limit-length', 'min' => 6, 'max' => 30, 'message' => 'Mot de Passe non valide: (min 6 - max 30 caractères)'),
					array('rule' => 'notEmpty','message' => 'Veuillez entrez un mot de passe')
				),
		'password_confirm' => array(
					array('rule' => 'notEmpty','message' => "Veuillez entrez le mot de passe de confirmation")
				),
	);

	var $validateContact = array(
		'email' => array(
					array('rule' => 'email', 'message' => "Votre email n'est pas valide"),
					array('rule' => 'notEmpty', 'message' => 'Votre email ne peut pas être vide')
				),
		'name' => array(
						array('rule' => 'notEmpty','message' => "Le nom ne peut pas être vide")
				),
		'subject' => array(
						array('rule' => 'notEmpty','message' => "Le sujet ne peut pas être vide")
				),
		'message' => array(
					array('rule' => 'notEmpty','message' => "Veuillez entrez un message"),
					array('rule' => 'limit-length', 'min' => 4, 'message' => "Votre message n'est pas valide (minimum 50 caractères) svp"),
				),
	);
}