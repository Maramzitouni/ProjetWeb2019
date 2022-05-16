<?php
	session_start();

	//include("database.php");
	require("connexionDB.php");
	require("functions.php");
  


if( count($_POST) == 6
	&& !empty($_POST["email"])
	&& !empty($_POST["lastname"]) 
	&& !empty($_POST["firstname"]) 
	&& !empty($_POST["adress"]) 
	&& !empty($_POST["birthday"]) 
	&& !empty($_POST["phone"])){

	

	//Me connecter à la BDD
		$connect = connectDB();
	$events=getEvent($connect,1,$_GET['id']);


	//Nettoyage de tous les champs
	$_POST["email"] = strtolower(trim($_POST["email"]));
	$_POST["lastname"] = strtoupper(trim($_POST["lastname"]));
	$_POST["firstname"] = ucwords(strtolower(trim($_POST["firstname"])));
	$_POST["adress"] = strtolower(trim($_POST["adress"]));
	$_POST["birthday"] = trim($_POST["birthday"]);
	$_POST["phone"] = str_replace([" ", ".", "-"], "", $_POST["phone"]);


	$error = false;
	$listOfErrors = [];

	//Vérification de l'email
	if ( !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$error = true;
		$listOfErrors[] = "Error email";

	
	}

	//Vérification nom et prénom
	if( strlen($_POST["lastname"])<2 || strlen($_POST["lastname"])>100){
		$error = true;
		$listOfErrors[] = "Error lastname";
	}
	if( strlen($_POST["firstname"])<2 || strlen($_POST["firstname"])>50){
		$error = true;
		$listOfErrors[] = "Error firstname";
	}

	//Vérification adresse
	if( strlen($_POST["adress"])<2 || strlen($_POST["adress"])>50){
		$error = true;
		$listOfErrors[] = "Error adress";
	}

	//Vérification du birthday entre 18 et 100

	$birthdayExploded = explode("/", $_POST["birthday"]);
	if( count($birthdayExploded) == 3 ){
		$_POST["birthday"] = $birthdayExploded[2]."-".$birthdayExploded[1]."-".$birthdayExploded[0];
	}

	//J'ai forcément une date anglaise
	$birthdayExploded = explode("-", $_POST["birthday"]);

	if( !checkdate($birthdayExploded[1], $birthdayExploded[2], $birthdayExploded[0]) ){
		$error = true;
		$listOfErrors[] = "ERROR Birthday";
	}

	//La date est bonne, vérification de l'age
	$ageEnSeconde = time() - strtotime($_POST["birthday"]);
	$seconde18 = 18 * 365.25 * 24 * 3600;
	$seconde100 = 100 * 365.25 * 24 * 3600;

	if( $ageEnSeconde < $seconde18 || $ageEnSeconde > $seconde100){
		$error = true;
		$listOfErrors[] = "ERROR Birthday";
	}


	//Vérification du phone = regex
	//^0[1-9][0-9]{8}$
	if( !preg_match("#^0[1-9][0-9]{8}$#", $_POST["phone"]) ){
		$error = true;
		$listOfErrors[] = "Error Phone";
	}




	
	if($error == true){
		//Si j'ai des erreurs je vais devoir les stocker dans un cookie
		//Je vais aussi stocker toutes les valeurs saisies sauf les mdps
		//redirige vers le fichier register.php

		//print_r($listOfErrors);
		setcookie("errorsRegister", serialize($listOfErrors)); 

	

		setcookie("dataRegister", serialize($_POST)); 

		header("Location:inscription-event.php");

	}else{
		   //inscription de user dans la base de données
 

		   //Une requéte préparéé
        $queryPrepared = $connect->prepare ( 
		"INSERT INTO insription_event  (email, lastname, firstname, adress, birthday, phone ,id_user, id_event) 
		VALUES 
		(:email, :lastname, :firstname, :adress, :birthday, :phone , :id_user, :id_event );" );

		   // éxecuter la requete
		
            $email = $_POST["email"];
            $_GET['id'] = $id_event ;
            $id_user= $_SESSION['id'];

               


        $arrayWithValues = [
        	"email"=>$_POST["email"],
            "lastname"=> $_POST["lastname"],
            "firstname"=>$_POST["firstname"],
            "adress"=> $_POST["adress"],
            "birthday"=>$_POST["birthday"],
            "phone"=>$_POST["phone"],
             "id_user"=>$id_user,
             "id_event"=> $_GET['id']
        	];

          
             $queryPrepared->execute($arrayWithValues);
             







}






                
                
           

	}else{

	die("Tentative de hack !!!");

}
