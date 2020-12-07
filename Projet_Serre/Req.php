<?php
	/* ..............  ................... 
		Gestion des requêtes envoyées par la carte Arduino (ou un navigateur)
			
		http://127.0.0.1/ISN_ArduinoFiche/Req.php?Etat=/L1=1/L2=0/
		http://legt-henin.fr:8080/sti2d.sin/SIN_ArduinoWEB/Req.php?Etat=/L1=1/L2=0/
	*/
	$delimiteur="/";
	$BDD='etatArduino.txt';

	if (isset($_GET["Etat"]) ) { //Pas de traitement si la variable Etat n'est pas définie
		// Lecture du fichier contenant les différents états, pour en extraire les chmaps non passés par la requête 
		$requete=$_GET["Etat"];
		// Zone de traitement des différentes commandes
		traitement($requete,$BDD,'Lux=','/');
	}
	
	function traitement($requete,$Fichier,$occurence,$delimiteur) {
		/* 
			Suppression de la partie correspondant à l'occurence et sa valeur n-1
			Enregistrement en fin de fichier de l'oocurence et de sa valeur
		*/
		$valOccurence=extractionValeur($requete,$occurence,$delimiteur);	// Recherche de la valeur de l'occurence
		if ($valOccurence!='') {	// On ne fait rien si on ne trouve pas l'occurence dans la requete passée	
			$chaine= file_get_contents($Fichier);	// Lecture du contenu du fichier servant de base de données
			// On extrait dans le fichier Base de Donnees l'occurence que l'on veut modifer
			$BDD=extractionBDD($chaine,$occurence,$delimiteur);
			// On rajoute en fin de base la valeur de l'occurence, suivi du délimiteur
			$BDD=$BDD.$occurence.$valOccurence.$delimiteur;
			// On enregistre dans le fichier servant de base de donnée la chaine $BDD
			$fp = fopen($Fichier, "w") or die("Unable to open file!");
			fwrite($fp,$BDD);
			fclose($fp);
		}
	}

	function extractionBDD($bdd,$occurence,$delimiteur) {
		// on supprime le champ correspondant à l'occurence passée et on retoune la nouvelle chaine
		$chaineRetour='';
		// Recherche de la variable dans la chaine passée. Remplacement de sa valeur et renvoi de la chaine modifiée
		$occurence=$delimiteur.$occurence; 			// Le champ doit commencé par /L1=....
		$posR=strpos($bdd,$occurence);			// Recherche de l'occurence (exemple /L1=)
			//echo(' '.$posR.' ');
		if ($posR!== false) {								// L'occurence précédé du délimiteur existe	
			$chaineRetour=substr($bdd, 0,$posR+1);	// on ajoute la partie de la base avant l'occurence
				//echo(' BDD avant : '.$chaineRetour.' .');
			$chaineTempo=substr($bdd,$posR+1,strlen($bdd)); // On extrait la chaine à partir de l'occurence, pas de test du delimiteur avant
				//echo(' Chaine tempo : '.$chaineTempo.' .');
			$posEt=strpos($chaineTempo,$delimiteur);	// Calcule de la position du délimiteur suivant
				//echo(' Position du / : '.$posEt);
			$chaineRetour=$chaineRetour.substr($chaineTempo,$posEt+1,strlen($bdd));
				//echo(' ChaineRetour : '.$chaineRetour);
			return($chaineRetour);
		}	
		else {
			return($bdd);	
		}

	}
	function extractionValeur($chaine,$occurence,$delimiteur) {	
		// Recherche d'une occurence dans la chaine transmise, si l'occurence n'existe pas, on retourne une chaine vide
		$occurence=$delimiteur.$occurence; 			// Le champ doit commencé par /L1=....
		//echo(' '.$chaine.' '.$occurence.' ');
		$posR=strpos($chaine,$occurence);			// Recherche de l'occurence (exemple /L1=)
		//echo($posR.' ');
		if ($posR!== false) {								// L'occurence précédé du délimiteur existe
			$chaineTempo=substr($chaine,$posR+1,strlen($chaine)); // On extrait la chaine à partir de l'occurence, pas de test du delimiteur avant
				//echo(' Chaine tempo : '.$chaineTempo.' .');
			$posEt=strpos($chaineTempo,$delimiteur);	// Calcule de la position du délimiteur suivant
				//echo(' Position du / : '.$posEt);
				//echo(' strLen de occurence : '.strlen($occurence));
			$val=substr($chaineTempo,strlen($occurence)-1,$posEt-strlen($occurence)+1);
				//echo(' valeur de Val : '.$val.'___ ');
			return($val);
		} 
		else {
			return('');
		}	
	}


?>

 
