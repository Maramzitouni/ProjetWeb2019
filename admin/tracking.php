


<?php

    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.

    include('../connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("../functions.php");
 
    $connect = connectDB();
  $visitors= $connect->prepare('SELECT * FROM visitor WHERE id_user = ? ORDER BY id DESC');
  $visitors->execute(array($_GET['id'] )); 
  
?>

<!DOCTYPE html>
<html lang="fr">



<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Tracking  </title>

  <meta  name="description" content="Bienvenue sur Go2Events Admin">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  
  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>

<body>

  <!-- header -->
<?php
  require_once ('menu.php');
?>



<br>



























 










<?php

  while($mr = $visitors-> fetch()) {
  	echo "nom d'opérateur utilisé : ";
  
  echo $mr ['browser_name']. "<br>" ; 
  
  echo "version :  ";
  
  echo $mr ['browser_version'] . "<br>" ; 
  
  echo "Type d'appareil :  ";
  
  echo $mr ['type'] ."<br>" ; 
  
  echo "URL visité :  ";
  
  echo $mr ['url'] . "<br>" ; 
   
   


        echo "<br>";
       
   $visitor= $connect->prepare('SELECT * FROM iplocation WHERE id_user = ? ORDER BY id DESC');
  $visitor->execute(array($_GET['id'] ));


  while($m = $visitor-> fetch()) {
    echo " Addresse IP : ";
  
  echo $m ['ipAddress']. "<br>" ; 
  
  echo "pays :  ";
  
  echo $m ['countryName'] . "<br>" ; 
  
  echo "region  :  ";
  
  echo $m ['regionName'] ."<br>" ; 

   echo "Ville :  ";
  
  echo $m ['countryCode'] . "<br>" ; 
   

  
  echo "latitude :  ";
  
  echo $m ['latitude'] . "<br>" ; 
   
   echo "longitude :  ";
  
  echo $m ['longitude'] . "<br>" ; 


        echo "<br>";
       
  }

  }