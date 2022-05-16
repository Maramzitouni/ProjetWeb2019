<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.

    include('../connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("../functions.php");
 
    $connect = connectDB();
    $timer =time();



if( (!isset($_SESSION['status']))  || (!isset($_SESSION['id'])) || ($_SESSION['status'] != 1)) {exit();
}


if(isset($_GET['status']) AND !empty($_GET['status']))
{
$status=(int) $_GET['status'];

$req=$connect->prepare('UPDATE users SET status =1 WHERE id=?');
$req->execute(array($status));

}


if(isset($_GET['statu']) AND !empty($_GET['statu']))
{
$statu=(int) $_GET['statu'];

$req=$connect->prepare('UPDATE users SET status =0 WHERE id=?');
$req->execute(array($statu));

}




if(isset($_GET['token']) AND !empty($_GET['token']))
{
$token=(int) $_GET['token'];

$req=$connect->prepare('UPDATE users SET token =1 WHERE id=?');
$req->execute(array($token));

}








if(isset($_GET['supprime'])AND !empty($_GET['supprime'])) {
$supprime =(int) $_GET['supprime'];

$req= $connect->prepare('DELETE FROM users WHERE id=?');
$req->execute(array($supprime));
}
   
    $users= $connect->query('SELECT * FROM users ORDER BY id DESC');


?> 

<!DOCTYPE html>
<html lang="fr">



<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Liste d'utilisateurs</title>

	<meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>


<body>



  <!-- header -->
<?php
	require_once ('menu.php');
?>
  <!-- header -->
  <center>
<h4> Liste d'utilisateurs</h4>
<section > 
  	



<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Nom</th>
      <th scope="col">Prénom</th>
      <th scope="col">Email</th>
      <th scope="col">tracking</th>
      <th scope="col">Stauts</th>
      <th scope="col">action </th>
      <th scope="col">Confirmation</th>
    </tr>
  </thead>
  <tbody id="user_grid">
 
      
  <?php 
  $m=1;
  while($m = $users-> fetch()) { 
   
$status='Offline';
         $class="btn-danger";
if($m['last_login']> $timer){
         $status='Online';
          $class="btn-success";
         }


   ?>
</tbody>

<tr>
<th scope="row"> <?= $m['id'] ?> </th>

      <td><?= $m['lastname'] ?></td>
      <td><?= $m['firstname'] ?></td>
      <td><?= $m['email'] ?></td>
      <td>

<a class="btn btn-dark" href="tracking.php?id=<?= $m['id'] ?>">Voir l'historique de visite </a> <br> 
      
</td>




      <td> <?php if($m['status'] != 1) { ?>
        
    <a class="btn btn-info" href="listusers.php?status=<?= $m['id'] ?>">Mettre Comme Admin </a> <br> 
       

<?php }else if ($m['status'] = 1) { ?>
        
    <a class="btn btn-info" href="listusers.php?statu=<?= $m['id'] ?>">Mettre comme user  </a> <br> 
       <?php
   }
       ?>

  
<br>

<!-- 3000 7000-->




    <a class="btn btn-dark" href="listusers.php?supprime=<?= $m['id'] ?>">Supprimer le compte </a></li>
    
                    </td>
 <td> <button type="button" class="btn <?php echo $class ?>"><?php echo $status?></button></td>

    
<td>

<?php if($m['token'] != 1) { ?>
        
    <a class="btn btn-success" href="listusers.php?token=<?= $m['id'] ?>">Confirmer l'utilisateur </a> <br> 
       <?php
   }else if  ($m['token'] = 1)         { 
    ?> 
    <h4>utilisateur vérifié </h4>
    <?php

   }
       ?>


</td>












    </tr>
     <?php 
         $m++;
         } ?>

  
         









  
</table>
</section>
</center>
 
























 <script>
    function updateUserStatus(){
      jQuery.ajax({
        url:'update_user_status.php',
        success:function(){
          
        }
      });
    }
    
    function getUserStatus(){
      jQuery.ajax({
        url:'get_user_status.php',
        success:function(result){
          jQuery('#user_grid').html(result);
        }
      });
    }
    
    setInterval(function(){
      updateUserStatus();
    },3000);
    
    setInterval(function(){
      getUserStatus();
    },7000);
    </script>










</body>
</html>
