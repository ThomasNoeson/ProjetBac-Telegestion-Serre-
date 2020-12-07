/*
	Fichier de définition des JavaScripts
	Lycée Louis Pasteur Hénin-Beaumont
	Modifié le 12 Avril 2015 par Pascal LUCAS
*/
	// Déclaration des variables Globales
	var L1=0;													// Etat de la lampe N°1
	var L2=0;													// Etat de la lampe N°2
	var ipArduino='172.16.167.114'; 
 var delimiteur='/';

	// Fonctions d'initialisations diverses
	var init = function() {         // Javascript exécuté à l'ouverture de la page	
		// positionne('Conteneur','L1_1', 305, 55);
		// positionne('Conteneur','L1_0', 355, 55);
		affichageContexte();
	}
		
	// Fonction de mise en place des abonnements
	// var declarationAbonnements = function() {
			// document.getElementById('L1_0').addEventListener("click",function() {cdeLED('L1',1);} );   // Declaration de l'abonnement
			// document.getElementById('L1_1').addEventListener("click",function() {cdeLED('L1',0);} );
	// }
	// On ne provoque l'appel à la fonction declarationAbonnements() qu'après le chargement complet de la page
	// Le chargement de la page provoque un événement "load"
	// En attendant la fin du chargement on est certain que tous les éléments ont été créés avant de mettre en place les abonnements
	// window.addEventListener("load", declarationAbonnements);
	window.addEventListener("load", init);

	// Définition des fonctions appelées lors des événements
	var cdeLED = function(numLed,etatLed) {
		var requeteArduino= 'http://'+ipArduino+'/'+numLed+'='+etatLed+'/';
		$.get(requeteArduino,function(data) {		} );
	} 
	
	// Définition des autres fonctions 
	var traitementRequetes = function (requete) {
		// Lecture dans la base de données (fichier) des différents éléments programmées sur la page WEB
		// Traitement de la lampe L1
		Lux=extractionVariable(extractionChamp(requete,'Lux=',delimiteur),'Lux=');
		affichageEtatObjet("lux", Lux);
	}

 	var affichageContexte = function() {
		// Place dans les variables globales les états des objets L1,etc... lus dans le fichier etatArduino.txt
		$requete='Etat.php';
		$.ajax( {
			type: 'GET',
			url:$requete,
			crossDomain:true,
			datatype:'text',
			timeout:3000,
			success: function(text) {	
				traitementRequetes(text);
			}
		} );
		setTimeout( "affichageContexte()" ,1000);
	}

	var affichageEtatObjet = function(objet, valeur) {
		// if(objet == "temp"){
			// document.getElementById("temp").innerHTML = valeur;
		// } else if (objet == "chauffage"){
			// if(valeur == "Oui"){
				// document.getElementById("chauffage").innerHTML = "Le chauffage est allumé";
			// } else {
				// document.getElementById("chauffage").innerHTML = "Le chauffage est éteinds";
			// }
		// }
		document.getElementById("lux").innerHTML ="La valeur du capteur est de : " + valeur + " lux";
	}

	var positionne = function (divConteneur,idDiv, posX, pos_Y) {
		// Positionne dans l'Id dans le contenueur sélectionné
		document.getElementById(idDiv).style.left = document.getElementById(divConteneur).offsetLeft+posX+'px';
		document.getElementById(idDiv).style.top = document.getElementById(divConteneur).offsetTop+pos_Y+'px';
 	}



	var extractionVariable = function (chaine,occurence) {	
		// Retourne la valeur de l'occurence si elle est présente dans la chaine transmise sinon une chaine vide
		var posR=chaine.indexOf(occurence);	
		if (posR!=-1) {
			return(chaine.substring(posR+occurence.length,chaine.length));
		} else {
			return(0);
		}
	}	

	var extractionChamp = function(chaine,occurence, delimiteur) {
		// Extraction de la chaine délimitée par le delimiteur (/)
		var posDebOcc=chaine.indexOf(occurence);
		if (posDebOcc!== false) {  
			chaine=chaine.substring(posDebOcc,chaine.length); 
			posDelimiteur=chaine.indexOf(delimiteur);
			chaine=chaine.substring(0,posDelimiteur); 
			return(chaine); // occurence trouvée, on retourne le champ complet
		} else {
			return false;  // Occurence non trouvée, on rentourne faux
		}   
	}

	var positionneElements = function () {
		// Positionne tous les éléments définis dans la page
		positionne('Conteneur','L1_1', 30, 5);
		positionne('Conteneur','L1_1', 30, 5);   
	}