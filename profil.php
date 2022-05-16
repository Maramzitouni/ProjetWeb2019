<?php
    session_start(); 
    include('connexionDB.php'); 
      include("functions.php");


    
   $connect = connectDB(); 

//supprimer le compte
  if(isset($_GET['supprime'])AND !empty($_GET['supprime'])) {
$supprime =(int) $_GET['supprime'];

$req= $connect->prepare('DELETE FROM users WHERE id=?');
$req->execute(array($supprime));
header('location:login.php');
}

if(isset($_GET['id']) AND $_GET['id']>0){
   
   $getid=($_GET['id']);
   $requser = $connect->prepare("SELECT * FROM users WHERE id = ?");

   $requser->execute(array($getid));
   $users = $requser->fetch();
   
// changer l'email
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['email']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $connect->prepare("UPDATE users SET email = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   // chnager le mdp
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $connect->prepare("UPDATE users SET pwd = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
    }
   
// ajouter/modifier photo de profil

if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 20097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "img/".$_SESSION['id'].".".$extensionUpload;
         $resultat = copy($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $connect->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
            $updateavatar->execute(array(
               'avatar' => $_SESSION['id'].".".$extensionUpload,
               'id' => $_SESSION['id']
               ));
            header('Location: profil.php?id='.$_SESSION['id']);
         } else {
            $msg = "Erreur durant l'importation de votre photo de profil";
         }
      } else {
         $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   } else {
      $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
   }
} 


  ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Page de profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="css/profil.css" rel="stylesheet" type="text/css">
  <script src="https://kit.fontawesome.com/275e6ee6a8.js" crossorigin="anonymous"></script>   
</head>
<body>
<!-- header -->
<?php require ('menu.php'); ?>
  <div class="container" >
      <div class="profile-header">
                
                <div class="profile-img">
                    <img src="img/<?= $users['avatar'] ?>" alt="" width="200">
                </div>
           <div class="profile-nav-info">
                <h3 class="user-name"><?= $users['firstname'] ?>
                 <?=$users['lastname'] ?> </h3>
              <div class="address">
                    <p class="state"><?= $users['adress']?> </p>
                    <span class="country"></span>
              </div>
           
               

           </div>
           <div class="profile-option">
              <div class="notification">
                  <i class="fa fa-bell"> </i>
                  <span class="alert-message">1</span>
              </div>         
          </div>
      
      </div>

     <div class="main-bd">
         <div class="left-side">
              <div class="profile-side">
                          <p class="mobile-no"><i class="fa fa-phone"></i><?= $users['phone']?></p>
                          <p class="user-mail"><i class="fa fa-envelope"></i><?= $users['email']?> </p>
                    <div class="user-bio">
                          <p class="bio"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>             
                    </div>
                <div class="profile-btn">
                    <a href="envoi.php">
                     <button class="chatbtn">
                     <i class="fa fa-comment"></i> Chat
                     </button>
                   </a>
           <?php

if(isset($_SESSION['id']) AND $_SESSION['id'] != $getid) { $FollowingOrNot =$connect->prepare('SELECT * FROM
  follow WHERE id_follower = ? AND id_followed = ?');
$FollowingOrNot->execute (array($_SESSION['id'],$getid));
$FollowingOrNot= $FollowingOrNot->rowCount();
if($FollowingOrNot==1){ ?> 

<a href="follow.php?followedid=<?php echo $getid?>"> 
                      <button class="createbtn" >
                     <i class="fa fa-plus"></i>Désabonner
                     </button>
                     </a>
<?php }else{ ?>
                     <a href="follow.php?followedid=<?php echo $getid?>"> 
                      <button class="createbtn" >
                     <i class="fa fa-plus"></i>Suivre
                     </button>
                     </a>            
  <?php  } }?>

                </div>
              </div>
          </div>

          <div class="right-side"> 
              <div class="nav">
   
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item" role="presentation">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Publications</a>
                          </li>
                          <li class="nav-item" role="presentation">
                              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Commentaires</a>
                          </li>
                         
           <?php if(isset($_SESSION['id']) AND $_SESSION['id'] == $getid) { ?>

                          <li class="nav-item" role="presentation">
                              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Paramètres du compte </a>
                          </li>
                     <?php } ?>
                      </ul>
                  <div class="tab-content" id="myTabContent"> 
                      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                          
                          <P> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo </P>

                      </div> 
                      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  
                          <P> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo </P>
                      </div>
                      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                         
                         <div align="center" style="padding: 15px; padding-right: 30px">
         <h4>Edition de mon profil</h4>
         <div align="left">
            <form method="POST" action="" enctype="multipart/form-data">
          
               <label>Email :</label>
               <input style="width:200px"type="text" name="newmail" placeholder="Mail" value="<?php echo $users['email']; ?>" /><br /><br />
               <label>Mot de passe :</label>
               <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
               <label>Confirmation </label>
               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe"><br><br>
               <label> Photo de profil: </label>
               <input type="file" name="avatar">
                 <br><br>
               
                  <input type="submit" value="Mettre à jour mon profil !" >



            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
         </div>
      </div>

<?php   
}
else {
   header("Location: login.php");
}
?>
                          
                         
                      </div>
                  </div>

              </div>
          </div>
      </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</body>
</html>

<?php 

?>
