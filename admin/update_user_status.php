<?php
session_start();

  include('../connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD
include("../functions.php");
 
 
   $connect = connectDB(); 
   $uid = $_SESSION['id'];
$timer = time()+10;
$users = $connect->query("UPDATE users SET last_login = $timer WHERE id = $uid");


?>