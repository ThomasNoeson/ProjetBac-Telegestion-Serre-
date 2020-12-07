<?php
	/* ..............  ................... 
		Lecture du contenu du fichier servant de base de données.
		Envoi de ce contenu au Javascript			
		http://127.0.0.1/ISN_ArduinoFiche/Req.php?Etat=/L1=1/L2=0/
		http://legt-henin.fr:8080/sti2d.sin/SIN_ArduinoWEB/Req.php?Etat=/L1=1/L2=0/
	*/

	$BDD='etatArduino.txt';
	//$fp = fopen("etatArduino.txt", "r") or die("Unable to open file!");
	$chaine= file_get_contents($BDD);	// Lecture du contenu du fichier servant de base de données
	//$chaine= fread($myfile,filesize("etatArduino.txt"));
	echo $chaine;	
?>

 
