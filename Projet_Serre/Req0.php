<?php
	/* ..............  ................... 
		http://127.0.0.1/ISN_ArduinoFiche/Req.php?Etat=/L1=1/L2=0/
		http://legt-henin.fr:8080/sti2d.sin/SIN_ArduinoWEB/Req.php?Etat=/L1=1/L2=0/
	*/
majBDD('etatArduino1.txt','Z=1','/');
echo("La suite......");

	if (isset($_GET["Etat"]) ) { //Pas de traitement si la variable Etat n'est pas définie
		// Lecture du fichier contenant les différents états, pour en extraire les chmaps non passés par la requête 
		$fichierEtat = fopen("etatArduino.txt", "r") or die("Unable to open file!");
		$chaine= fread($fichierEtat,filesize("etatArduino.txt"));
		fclose($fichierEtat);
		// On extrait dans le fichier Base de Donnees l'occurence que l'on veut modifer
		$BDD=extractionBDD($chaine,'Temp=','/');
		//echo($BDD);

		//echo('    Test occurence');
		$chaineRecue=$_GET["Etat"];
		$valCherchee=extractionValeur($chaineRecue,'Temp=','/');
		//echo('-'.$valCherchee.'-');
		if ($valCherchee!='') {
			$BDD=$BDD.'Temp='.$valCherchee.'/';		// On place en fin de base la valeur cherchée
		}
		$file = fopen("etatArduino.txt","w");
		fwrite($file,$BDD);
		fclose($file);	

		echo('Ok...');

	}
	
	function majBDD($Fichier,$occurence,$delimiteur) {
		$fp = fopen($Fichier,'w+');	// Ouvre le fichier ou le crée s'il n'existe pas sur le serveur
		if (filesize($Fichier)==0) {
			$chaine="";
		} else {
			$chaine= fread($fp,filesize($Fichier));
		}
		
		fclose($fp);
		echo($chaine.'    ');
	}

	function extractionValeur($chaine,$occurence,$delimiteur) {	
		// Recherche d'une occurence dans la chaine transmise, si l'occurence n'existe pas, on retourne une chaine vide
		$occurence=$delimiteur.$occurence; 			// Le champ doit commencé par /L1=....
		$posR=strpos($chaine,$occurence);			// Recherche de l'occurence (exemple /L1=)
		if ($posR) {								// L'occurence précédé du délimiteur existe
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

	function extractionBDD($bdd,$occurence,$delimiteur) {
		// on supprime le champ correspondant à l'occurence passée
		$chaineRetour='';
		// Recherche de la variable dans la chaine passée. Remplacement de sa valeur et renvoi de la chaine modifiée
		$occurence=$delimiteur.$occurence; 			// Le champ doit commencé par /L1=....
		$posR=strpos($bdd,$occurence);			// Recherche de l'occurence (exemple /L1=)
		if ($posR) {								// L'occurence précédé du délimiteur existe	
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
?>

 
