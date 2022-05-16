
<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();

if (!isset($_SESSION['id'])){
      header('Location: index.php'); 
      exit;}
          
    
$event= $connect->prepare('SELECT * FROM events  INNER JOIN inscription_event ON events.id = inscription_event.id_event  AND inscription_event.id_user = ? ' );


$event->execute(array($_SESSION['id']));
 ?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Page de l'événement</title>
  <meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
  <script src="https://kit.fontawesome.com/275e6ee6a8.js" crossorigin="anonymous"></script>
  <link href="css/event.css" rel="stylesheet" type="text/css">  
</head>

<body>

  <!-- header -->
        <?php        require_once ('menu.php');  ?>
<!-- bdd -->



<br>
<br>
<section class="sections eventspos"  style="margin-top:10px; "> 
    <h2> Les événements inscrits: </h2>  
      

  
     <div class="container shadow"style="background-color: white; padding: 25px">
  
<div class="row ">


 <?php

 $events =$event ->fetchALL();
                    foreach ($events as $event): ?>
       
                  <div class ="col-md-4 col-xs-12">
                      <div class="event shadow">
                        <img src="<?= $event['img_src'] ?>" alt="imgevent" width="300" height="200" class="card-img-top eventImages img-fluid">
                        <h3 class="event-title"> <?= $event['titre'] ?>  </h3>   
                        <p class="event-desc"> <?= $event['date_event'] ?> <br> <?= $event['contenu'] ?> </p>
                        <a href="event.php?id=<?= $event['id']?>" type="button" class="btn btn-info"  role="button" aria-disabled="true"> Afficher Plus  </a>
                   
                   <?php  if(isset($_GET['id2'])AND !empty($_GET['id2'])) {
                         $r6 =(int) $_GET['id2'];

                        $req6= $connect->prepare('DELETE FROM inscription_event WHERE id=?');
                       $req6->execute(array($r6));
                                }

                     ?>

                        <a href="mesevents.php?id2=<?=$event['id']?>" type="button" class="btn btn-info"  role="button" aria-disabled="true">supprimer </a> <br>







                      </div>          
                  </div>
            

            <?php endforeach ?> 
             </div>
      </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>

 