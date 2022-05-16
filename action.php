<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();

if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']) AND isset($_SESSION['id'])) {
   $getid = (int) $_GET['id'];
   $gett = (int) $_GET['t'];
   $sessionid = $_SESSION['id'];
   $check = $connect->prepare('SELECT id FROM events WHERE id = ?');
   $check->execute(array($getid));
   if($check->rowCount() == 1) {
      if($gett == 1) {
         $check_like = $connect->prepare('SELECT id FROM likes WHERE id_event = ? AND id_membre = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $connect->prepare('DELETE FROM dislikes WHERE id_event = ? AND id_membre = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $connect->prepare('DELETE FROM likes WHERE id_event = ? AND id_membre = ?');
            $del->execute(array($getid,$sessionid));
         } else {
            $ins = $connect->prepare('INSERT INTO likes (id_event, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
         }
         
      } elseif($gett == 2) {
         $check_like = $connect->prepare('SELECT id FROM dislikes WHERE id_event = ? AND id_membre = ?');
         $check_like->execute(array($getid,$sessionid));
         $del = $connect->prepare('DELETE FROM likes WHERE id_event = ? AND id_membre = ?');
         $del->execute(array($getid,$sessionid));
         if($check_like->rowCount() == 1) {
            $del = $connect->prepare('DELETE FROM dislikes WHERE id_event = ? AND id_membre = ?');
            $del->execute(array($getid,$sessionid));
         } else {
            $ins = $connect->prepare('INSERT INTO dislikes (id_event, id_membre) VALUES (?, ?)');
            $ins->execute(array($getid, $sessionid));
            }
      }
      header('Location: event.php?id='.$getid);
   } else {
      exit('Erreur fatale. <a href="event.php" >Revenir à l\'accueil</a>');
   }
} else {
   exit('Erreur fatale. <a href="index.php">Revenir à l\'accueil</a>');
}