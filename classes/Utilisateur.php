<?php
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
			$this->_email = $newEmail;
		}
		public function setPassword($newPassword) {
			$this->_password = $newPassword;
		}

		// Methodes
		public function register() {

			require('src/connexion.php');
			$inscription = $bdd->prepare('INSERT INTO utilisateurs (pseudo, email, password) VALUES (?, ?, ?)');
			$inscription->execute([
				$this->getPseudo(), 
				$this->getEmail(), 
				$this->getPassword()
			]);

		}

		public function createSessions() {

			$_SESSION['connect'] 	= 1;
			$_SESSION['pseudo'] 	= $this->getPseudo();
			$_SESSION['email']		= $this->getEmail(); 

		}
		
	}