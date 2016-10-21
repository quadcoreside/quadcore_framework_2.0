<?php
class Admin_Model extends Model
{
	var $validateLogin = array(
		'email' => array(
			array('rule' => 'notEmpty','message' => 'Votre email ne peut pas être vide')
		),
		'password' => array(
			array('rule' => 'notEmpty', 'message' => "Le mot de passe ne peut pas être vide")
		)
	);

	var $validateAccount = array(
		'username' => array(
			array('rule' => 'notDuplicate', 'model' => 'Admin','message' => 'Ce nom\'utilisateur est dêja utilisé'),
			array('rule' => '^[A-Za-z][A-Za-z0-9]{3,31}$','message' => 'Votre nom d\'utilisateur n\'est pas valide (min 4 - max 30 caractères)'),
			array('rule' => 'notEmpty','message' => 'Veuillez entrez un nom d\'utilisateur')
		),
	);

	var $validateAdminRegister = array(
		'username' => array(
			array('rule' => 'notDuplicate', 'model' => 'Admin','message' => 'Ce nom\'utilisateur est dêja utilisé'),
			array('rule' => '^[A-Za-z][A-Za-z0-9]{3,31}$','message' => 'Votre nom d\'utilisateur n\'est pas valide (min 4 - max 30 caractères)'),
			array('rule' => 'notEmpty','message' => 'Veuillez entrez un nom d\'utilisateur')
		),
	);

	var $validatePassword = array(
		'password_confirm' => array(
			array('rule' => 'notEmpty','message' => "Veuillez entrez le mot de passe de confirmation")
		),
		'password' => array(
			array('rule' => 'comparer','comparant' => 'password_confirm','message' => 'Le mot de passe n\'est identique au mot de passe de confirmation'),
			array('rule' => 'notEmpty','message' => 'Veuillez entrez un mot de passe')
		),
	);

}