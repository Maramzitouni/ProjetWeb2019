	<?php

    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 
//afficher les messages

$connect = connectDB();
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
   if(isset($_GET['id']) AND !empty($_GET['id'])) {
     
      $id_message = intval($_GET['id']);
      
      $msg = $connect->prepare('SELECT * FROM messages WHERE id = ? AND id_destinataire = ? OR ( id_expediteur = ? AND id = ?                )    ');
      $msg->execute(array($_GET['id'],$_SESSION['id'], $_SESSION['id'],  $_GET['id']  ));
      $msg_nbr = $msg->rowCount();
      $m = $msg->fetch();
     
     $p_exp = $connect->prepare('SELECT firstname FROM users WHERE id = ?');
      $p_exp->execute(array($m['id_expediteur']));
      $p_exp = $p_exp->fetch();
      $p_exp = $p_exp['firstname'];
//envoyer





     


//envoyer

      if (isset($_POST['message']) AND !empty ($_POST['message']) )
      {

      $message = htmlspecialchars ($_POST['message']);
      $insertmsg=$connect->prepare('INSERT INTO messages(id_expediteur,id_destinataire,message) VALUES (?,?,?)');
            $insertmsg->execute(array($_SESSION['id'],$m['id_expediteur'],$message)); 






      }








?>
<!DOCTYPE html>
<html>
<head>
   <title>Lecture du message #<?= $id_message ?></title>
   <meta charset="utf-8" />
</head>
<body>
   <a href="envoi.php">Boîte de réception</a>    <a href="envoi.php?r=<?= $p_exp ?>&o=<?= urlencode($m['objet']) ?>">Répondre</a>    <a href="supprimer.php?id=<?= $m['id'] ?>">Supprimer</a><br /><br /><br />
   <h3 align="center">Lecture du message #<?= $id_message ?></h3>
   <div align="center">
       <?= $p_exp ?> <?php  
       if($msg_nbr == 0) { echo "Erreur"; } else { ?>
      <b>  :  <br />
      <br /><br />
      <?= nl2br($m['message']) ?><br />
      <?php } ?>
   
     


<form method="post" action="">
   
   <textarea type="text" placeholder="MESSAGE" name= "message"> </textarea> <br>
   <input type ="submit" value = "ENVOYER">
 </form>






















</body>
</html>






















<?php
     
   }
} 
?>