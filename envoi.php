<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 
//afficher les messages

$connect = connectDB();
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
$msg = $connect->prepare('SELECT * FROM messages WHERE id_destinataire = ?');
$msg->execute(array($_SESSION['id']));
$msg_nbr = $msg->rowCount();

// envoyer les messages

if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
   if(isset($_POST['envoi_message'])) {
      if(isset($_POST['destinataire'],$_POST['message']) AND !empty($_POST['destinataire']) AND !empty($_POST['message'])) {
         $destinataire = htmlspecialchars($_POST['destinataire']);
         $message = htmlspecialchars($_POST['message']);
         $id_destinataire = $connect->prepare('SELECT id FROM users WHERE firstname = ?');
         $id_destinataire->execute(array($destinataire));
         $dest_exist = $id_destinataire->rowCount();
         if($dest_exist == 1) {
            $id_destinataire = $id_destinataire->fetch();
            $id_destinataire = $id_destinataire['id'];
            $ins = $connect->prepare('INSERT INTO messages(id_expediteur,id_destinataire,message) VALUES (?,?,?)');
            $ins->execute(array($_SESSION['id'],$id_destinataire,$message));
            $error = "Votre message a bien été envoyé !";
            header('location: envoi.php');
         } else {
            $error = "Cet utilisateur n'existe pas...";
             
         }
      } else {
         $error = "Veuillez compléter tous les champs";
          
      }
   }
   $destinataires = $connect->query('SELECT firstname FROM users ORDER BY firstname');
   

   ?>
   <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Envoi de lessage </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="css/chat.css">
   <script type="text/javascript" href="chat.js"></script>

</head>
<?php require ('menu.php'); ?>
   <body style="
  background-color: #A9A9A9; 
  height: 800px;
   background-image: url('img/chat.jpg'); 
   background-size: cover; 
   background-position: center;
   position: relative;
  
}">
<!-- afficher image de l'utilisateur -->
<?php
       $USER = $connect->prepare('SELECT firstname, avatar, lastname FROM users WHERE id = ?');
        $USER->execute(array($_SESSION['id']));
      $USER = $USER->fetch();
       $USER = $USER['avatar'];      
       ?>
<div class="container">
   <div class="row no-gutters">
        <div class="col-md-4 border-right">
         
              <div class="settings-tray">
                  <img class="profile-image" src="img/<?=$USER?>" alt="Profile img">
                  <span style="padding-left: 205px"class="settings-tray--right">
                      <i class="material-icons">cached</i>
                      <i class="material-icons">message</i>
                      <i class="material-icons">menu</i>
                  </span>
              </div>

              <div class="search-box">
                   
         </select> 
         </div>



<!-- afficher les données de l'éxpediteur et le message -->

         <?php
   if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; } 
            while($m = $msg->fetch()) {
              
       $p_exp = $connect->prepare('SELECT firstname, avatar, lastname FROM users WHERE id = ?');
      $p_exp->execute(array($m['id_expediteur']));
      $p_exp = $p_exp->fetch();
       $user = $p_exp['firstname'];
       $lastname= $p_exp['lastname'];
        $avatar = $p_exp['avatar'];
       ?>


            <div class="friend-drawer friend-drawer--onhover">
                <img class="profile-image" src="img/<?=$avatar?>" alt="">
                <div class="text">
                      <h6><?= $user ?>  <?= $lastname?></h6>
                      <p class="text-muted"> <?= nl2br($m['message']) ?></p>
                </div>
                <span class="time text-muted small"><?= nl2br($m['date_creation']) ?></span>
            </div>
            <hr>

             <a href="lecture.php?id=<?= $m['id'] ?>"> voir </a>


           <?php } ?>
    

    
    </div>
    <div class="col-md-8">
    <div class="settings-tray">
      <div class="friend-drawer no-gutters friend-drawer--grey">
      <div class="text">
        <div class="search-box">
                   <form method="POST"> 
                   <label>Destinataire:</label>
         <select name="destinataire">
            <?php while($d = $destinataires->fetch()) { ?>
            <option> <?= $d['firstname'] ?> </option>
            <?php } ?>
         </select> 
         </div>
      </div>
      <span class="settings-tray--right">

      </span>
      </div>
    </div>
    <div class="chat-panel">
      <div class="row no-gutters">
      <div class="col-md-3"style="height:500px">
        <div class="chat-bubble chat-bubble--left" style="width:300px" >
   <?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; 
 

    } ?>
        </div>
      </div>
      </div>
      
      
      </div>
      <div class="row">
      <div class="col-12">
        <div class="chat-box-tray ">
        <i class="material-icons">sentiment_very_satisfied</i>
        

       <br /><br />

         <textarea style="padding-left:25px;margin-left: 5px; width:550px; border-radius: 10px;" placeholder="Votre message" name="message"></textarea>
         <br /><br />

         <input type="submit" style="margin-right:5px" value="Envoyer" name="envoi_message" />
         <br /><br />
        

 
        </div>
      </div>
      </div>
    </form>
    </div>
    </div>
  </div>
  </div>
 
</body>
</html>



<?php
}
?>   

<?php } ?>    



