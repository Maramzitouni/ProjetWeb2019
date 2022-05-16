<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.

    include('../connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("../functions.php");
 
    $connect = connectDB();



if( (!isset($_SESSION['status']))  || (!isset($_SESSION['id'])) || ($_SESSION['status'] != 1)) {exit();
}
if(isset($_GET['supprime'])AND !empty($_GET['supprime'])) {
$supprime =(int) $_GET['supprime'];

$req= $connect->prepare('DELETE FROM events WHERE id=?');
$req->execute(array($supprime));
}
   
    $users= $connect->query('SELECT * FROM events ORDER BY id DESC');
 










?> 


<!DOCTYPE html>
<html lang="fr">



<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Liste d'events</title>

	<meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">

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



 <center>
<h4> Liste d'events</h4>
<section > 
  	



<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Titre</th>
      <th scope="col">Date</th>
       <th scope="col">Nombre de place </th>
      <th scope="col">Action</th>
<th scope="col">Commentaires </th>
<th scope="col">Les inscrits </th>
    </tr>
  </thead>
  <tbody>
 
      
  <?php 

  while($m = $users-> fetch()) { 
   ?>


<tr>
<th scope="row"> <?= $m['id'] ?> </th>

      <td><?= $m['titre'] ?></td>
      <td><?= $m['date_event'] ?></td>      
       <td> total : <?= $m['qty'] ?>  <br> 
        reste : 
<?php 

$pid = $m['id'] ;
        $sql= $connect->query( "SELECT SUM(order_number)  from inscription_event where id_event =" .$pid );
 $qtySold = $sql->fetch() ;

  
 
   echo $m['qty'] - $qtySold['SUM(order_number)']  ; 




   ?>

       </td>


  
   <td>
   
    <a class="btn btn-info" href="modify_event.php?id=<?= $m['id'] ?>">Modifier l'event</a> <br> 
    <br>
    <a class="btn btn-danger" href="delete_event.php?id=<?= $m['id'] ?>">Supprimer l'event</a><br>
    <br>

    
   </td>
   
 
 
   <td>

<?php
$connect =connectDB();

$req=$connect->query('SELECT * FROM commentaire WHERE id_event = ' .$m['id']);
  



  while ($r=$req->fetch() ) {


$req1=$connect->query('SELECT * FROM users WHERE id= ' .$r['id_user']);


while ($r1=$req1->fetch()) { ?>




<?php

echo $r1['firstname'].' ';
echo $r1['lastname'];
echo $r['text'].' ';
echo $r['date_creation'];
echo '</br>';


if(isset($_GET['id'])AND !empty($_GET['id'])) {
$r3 =(int) $_GET['id'];

$req3= $connect->prepare('DELETE FROM commentaire WHERE id=?');
$req3->execute(array($r3));
}

?>

 <a href="toutEvents.php?id=<?=$r['id']?>">supprimer </a> <br>







<?php
}
}
?>

   <td>            



<td>


<?php

$req4=$connect->query('SELECT * FROM inscription_event WHERE id_event = ' .$m['id']);
  
  while ($r4=$req4->fetch() ) {


$req5=$connect->query('SELECT * FROM users WHERE id= ' .$r4['id_user']);


while ($r5=$req5->fetch()) {

echo $r5['firstname'];
echo $r5['lastname'];


if(isset($_GET['id2'])AND !empty($_GET['id2'])) {
$r6 =(int) $_GET['id2'];

$req6= $connect->prepare('DELETE FROM inscription_event WHERE id=?');
$req6->execute(array($r6));
}

?>

 <a href="toutEvents.php?id2=<?=$r4['id']?>">supprimer </a> <br>

<?php

}
}
?>





</td>



























</tr>
                 <?php
     } 

    ?>
  </tbody>
</table>
</section>
<center>



































<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>