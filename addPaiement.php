<?php
	session_start();

if( count($_POST) == 6 
	&& !empty($_POST["lastname"])
	&& !empty($_POST["name"]) 
	&& !empty($_POST["numcarte"]) 
	&& !empty($_POST["mois"]) 
	&& !empty($_POST["Année"]) 
	&& !empty($_POST["cryptogramme"])) {


	//Nettoyage de tous les champs
	$_POST["lastname"] = strtoupper(trim($_POST["lastname"]));
	$_POST["name"] = ucwords(strtolower(trim($_POST["name"])));
	$_POST["numcarte"] = str_replace([" ", ".", "-"], "", $_POST["numcarte"]);
	$_POST["mois"] = trim($_POST["mois"]);
	$_POST["Année"] = trim($_POST["Année"]);
	$_POST["cryptogramme"] = str_replace([" ", ".", "-"], "", $_POST["cryptogramme"]);


	$error = false;
	$listOfErrors = [];


	//Vérification nom et prénom
	if( strlen($_POST["lastname"])<2 || strlen($_POST["lastname"])>100){
		$error = true;
		$listOfErrors[] = "Error lastname";
	}
	if( strlen($_POST["name"])<2 || strlen($_POST["name"])>50){
		$error = true;
		$listOfErrors[] = "Error name";
	}

	//Verifier num carte
	if( !preg_match("#^[0-9][0-9]{14}$#", $_POST["numcarte"]) ){
		$error = true;
		$listOfErrors[] = "Error Number Card";
	}

	//Verifier mois
	if( !preg_match("#^[2][0][2-3][0-9]$#", $_POST["Année"]) ){
		$error = true;
		$listOfErrors[] = "Error year";
	}

	//Verifier année
	if( !preg_match("#^[0-2][0-9]$#", $_POST["mois"]) ){
		$error = true;
		$listOfErrors[] = "Error month";
	}

	//Vérifier cryptogramme
	if( !preg_match("#^[0-9][0-9][0-9]$#", $_POST["cryptogramme"]) ){
		$error = true;
		$listOfErrors[] = "Error Cryptogramme";
	}


 

	
	if($error == true){
		//Si j'ai des erreurs je vais devoir les stocker dans un cookie
		//Je vais aussi stocker toutes les valeurs saisies sauf les mdps
		//redirige vers le fichier paiement.php

		//print_r($listOfErrors);
		setcookie("errorsRegister", serialize($listOfErrors)); 

		setcookie("dataRegister", serialize($_POST)); 

		header("Location: paiement.php");

	}else{
                
            header("Location: index.php");

	} 

}
