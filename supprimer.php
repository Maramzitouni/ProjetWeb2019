

	<<?php

    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 
//afficher les messages

$connect = connectDB();
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
   if(isset($_GET['id']) AND !empty($_GET['id'])) {
      $id_message = intval($_GET['id']);
      $msg = $bdd->prepare('DELETE FROM messages WHERE id = ? AND id_destinataire = ?');
      $msg->execute(array($_GET['id'],$_SESSION['id']));
      header('Location:reception.php');
   }
} 
?>