<?php
class Config_Model extends Model {
	var $validateConfiguration = array(
		'website_name' => array(
					array('rule' => 'notEmpty','message' => 'Veuillez entrez un nom d\'utilisateur')
				),
		'website_email' => array(
					array('rule' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$','message' => 'Votre email n\'est pas valide'),
					array('rule' => 'notEmpty','message' => "L'email du site ne peut pas être vide")
				),
	);
	var $validateVar = array(
		'content' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez renseigner ce champ.')
			),
	);

	var $validateSmtp = array(
		'smtp_user' => array(
					array('rule' => 'notEmpty','message' => 'Veuillez entrez un utilisateur smtp')
				),
		'smtp_host' => array(
					array('rule' => 'notEmpty','message' => "Veuillez entrez l'hote smtp")
				),
		'smtp_secure' => array(
					array('rule' => 'notEmpty','message' => "Veuillez entrez le type de securité du smtp")
				),
	);

	var $validateSeo = array(
		'website_description' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez renseigner ce champ.')
			),
		'website_keywords' => array(
				array('rule' => 'notEmpty','message' => 'Veuillez renseigner ce champ.')
			),
	);
	var $validateServer = array(
		'website_name' => array(
					array('rule' => 'notEmpty','message' => 'Votre email ne peut pas être vide')
				),
		'website_email' => array(
					array('rule' => '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$','message' => 'Votre email n\'est pas valide'),
					array('rule' => 'notEmpty','message' => "L'email du site ne peut pas être vide")
				),
		'website_report' => array(
					array('rule' => 'notEmpty','message' => 'Email ne peut pas être vide'),
				),
	);
}
