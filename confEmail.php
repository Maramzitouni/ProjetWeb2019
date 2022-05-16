<?php

    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    require('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    include("functions.php");
$connect = connectDB();

 
if(isset($_GET['email'], $_GET['key']) AND !empty($_GET['email']) AND !empty($_GET['key'])) {
   $email = htmlspecialchars(urldecode($_GET['email']));
   $key = htmlspecialchars($_GET['key']);
   $requser = $connect->prepare("SELECT * FROM users WHERE email = ? AND token = ?");
   $requser->execute(array($email, $key));
   $userexist = $requser->rowCount();
   if($userexist == 1) {
      $user = $requser->fetch();
      if($user['confirmation_token'] == 0) {
         $updateuser = $connect->prepare("UPDATE users SET confirmation_token = 1 WHERE email = ? AND confirmation_token = ?");
         $updateuser->execute(array($email,$key));
         echo "Votre compte a bien été confirmé !";
      } else {
         echo "Votre compte a déjà été confirmé !";
      }
   } else {
      echo "L'utilisateur n'existe pas !";
   }
}
?>