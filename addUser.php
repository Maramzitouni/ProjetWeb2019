<?php
	session_start();

	//include("database.php");
	require("connexionDB.php");
	require("functions.php");
  


if( count($_POST) == 10 
	&& !empty($_POST["email"])
	&& !empty($_POST["pwd"]) 
	&& !empty($_POST["pwdConfirm"]) 
	&& !empty($_POST["lastname"]) 
	&& !empty($_POST["firstname"]) 
	&& !empty($_POST["adress"]) 
	&& !empty($_POST["birthday"]) 
	&& !empty($_POST["phone"])
	&& !empty($_POST["cgu"]) 
	&& !empty($_POST["captcha"])){


	//Me connecter à la BDD
		$connect = connectDB();


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
	}else if( emailExist($connect, $_POST["email"])) {
		$error = true;
		$listOfErrors[] = "Error Email, déjà existant";
	}

	//Vérification du pwd
	if( strlen($_POST["pwd"])<6 
		|| strlen($_POST["pwd"])>30 
		|| !preg_match("#[A-Z]#", $_POST["pwd"])
		|| !preg_match("#[a-z]#", $_POST["pwd"])
		|| !preg_match("#[0-9]#", $_POST["pwd"])){
		$error = true;
		$listOfErrors[] = "Error PWD";
	}

	if( $_POST["pwdConfirm"] != $_POST["pwd"] ){
		$error = true;
		$listOfErrors[] = "Error PWD confirm";
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


	//Est ce que le captcha est bon 
	if( $_POST["captcha"] != $_SESSION["captcha"]){
		$error = true;
		$listOfErrors[] = "ERROR captcha";
	}

	
	if($error == true){
		//Si j'ai des erreurs je vais devoir les stocker dans un cookie
		//Je vais aussi stocker toutes les valeurs saisies sauf les mdps
		//redirige vers le fichier register.php

		//print_r($listOfErrors);
		setcookie("errorsRegister", serialize($listOfErrors)); 

		unset($_POST["pwd"]);
		unset($_POST["pwdConfirm"]);

		setcookie("dataRegister", serialize($_POST)); 

		header("Location:register.php");

	}else{
		   //inscription de user dans la base de données
 

		   //Une requéte préparéé
        $queryPrepared = $connect->prepare ( 
		"INSERT INTO users  (email, pwd, lastname, firstname, adress, birthday, phone ,token) 
		VALUES 
		(:email, :password , :lastname, :firstname, :adress, :birthday, :phone , :token );" );

		   // éxecuter la requete
		   $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT) ;
            $email = $_POST["email"];

             $longueurKey = 15;
                 $key= "";
                for($i=1;$i<$longueurKey;$i++){
                $key .= mt_rand(0,9);

               }


        $arrayWithValues = [
        	"email"=>$_POST["email"],
            "password"=> $pwd,
            "lastname"=> $_POST["lastname"],
            "firstname"=>$_POST["firstname"],
            "adress"=> $_POST["adress"],
            "birthday"=>$_POST["birthday"],
            "phone"=>$_POST["phone"],
             "token"=>$key
        	];

          
             $queryPrepared->execute($arrayWithValues);
             


                     $header="MIME-Version: 1.0\r\n";
                     $header.='From:"go2events.store"<go2events.store@gmail.com>'."\n";
                     $header.='Content-Type:text/html; charset="uft-8"'."\n";
                     $header.='Content-Transfer-Encoding: 8bit';
                     $message='
                     <html>
                        <body>
                           <div align="center">
                              <a href="https://Go2events.store/confEmail.php?email='.urlencode($email).'&key='.$key.'">Confirmez votre compte !</a>
                           </div>
                        </body>
                     </html>
                     ';
                     mail($email, "Confirmation de compte", $message, $header); 


                           
                  header('Location:login.php');















                }
                
           

	}else{

	die("Tentative de hack !!!");

}

