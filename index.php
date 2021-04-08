<?php

	class Verifier {

		public static function syntaxeEmail($email) {	
			
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return true;
			} else {
				return false;
			}
		}

		public static function doublonEmail($email) {

			require('src/connexion.php');

			$requete = $bdd->prepare('SELECT COUNT(*) AS emailNumber FROM utilisateurs WHERE email = ?');
			$requete->execute([$email]);

			while($emailVerification = $requete->fetch()) {
				
				if($emailVerification['emailNumber'] != 0) {
					return true;
				} else {
					return false;
				}
			}
		}
	}

	class Securite {

		public static function encrypt($password) {
			$password = "aq1".sha1($password."123")."25";
		}
	}

	class Utilisateur {

		// Attributs
		private $_pseudo;
		private $_email;
		private $_password;

		// Constructeur
		public function __construct($pseudo, $email, $password) {

			$this->setPseudo($pseudo);
			$this->setEmail($email);
			$this->setPassword($password);

		}

		// Getters
		public function getPseudo() {
			return $this->_pseudo;
		}
		public function getEmail() {
			return $this->_email;
		}
		public function getPassword() {
			return $this->_password;
		}

		// Setters
		public function setPseudo($newPseudo) {
			$this->_pseudo = $newPseudo;
		}
		public function setEmail($newEmail) {
			$this->_pseudo = $newEmail;
		}
		public function setPassword($newPassword) {
			$this->_pseudo = $newPassword;
		}

		// Methodes
		public static function register($pseudo, $email, $password) {

			$bdd = new PDO ('mysql:host=localhost;dbname=poo;charset=utf8','root','');
			$inscription = $bdd->prepare('INSERT INTO utilisateurs (pseudo, email, password) VALUES (?, ?, ?)');
			$inscription->execute([$pseudo, $email, $password]);

			header('location: index.php?success=1');
			exit();
		}

		public function createSessions() {
			session_start();

		}
		

	}

	// Verification envoi du formulaire
	if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		// Variables
		$pseudo 	= htmlspecialchars($_POST['pseudo']);
		$email 		= htmlspecialchars($_POST['email']);
		$password 	= htmlspecialchars($_POST['password']);

		// Vérifier la syntaxe de l'email
		if(!Verifier::syntaxeEmail($email)) {
			header('location: index.php?error=true&message=Veuillez vérifier le format de votre adresse email.');
			exit();
		}

		// Vérifier si doublon de l'email
		if(Verifier::doublonEmail($email)) {
			header('location: index.php?error=true&message=Cette adresse email est déjà utilisée.');
			exit();
		}

		// Chiffrement de mot de passe
		Securite::encrypt($password);

		// Enregistrement de l'utilisateur
		$bdd = new PDO ('mysql:host=localhost;dbname=poo;charset=utf8','root','');

		Utilisateur::register($pseudo, $email, $password);
		
	}



?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/default.css">
	<title>Mon Site PHP</title>
</head>
<body>

	<section class="container">
		
		<form method="post" action="index.php">

			<p>Incription</p>

			<?php if(isset($_GET['success'])) {
				echo '<p class="alert success">Inscription réalisée avec succès.</p>';
			}
			else if(isset($_GET['error']) && !empty($_GET['message'])) {
				echo '<p class="alert error">'.htmlspecialchars($_GET['message']).'</p>';
			} ?>

			<input type="text" name="pseudo" id="pseudo" placeholder="Pseudo"><br>
			<input type="email" name="email" id="email" placeholder="Email"><br>
			<input type="password" name="password" id="password" placeholder="Mot de passe"><br>
			<input type="submit" value="Inscription">
		
		</form>

		<div class="drop drop-1"></div>
		<div class="drop drop-2"></div>
		<div class="drop drop-3"></div>
		<div class="drop drop-4"></div>
		<div class="drop drop-5"></div>
	</section>

</body>
</html>