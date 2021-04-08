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