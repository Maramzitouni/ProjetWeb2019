<?php
  session_start();

  include('../connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD
include("../functions.php");
 
 
   $connect = connectDB();
$uid=$_SESSION['id'];
$timer=time();
$users=$connect->query('SELECT * from users');
$m=1;

	$m++;

?>













 




















