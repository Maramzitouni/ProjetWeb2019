<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
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
  
     <div class="container shadow"style="background-color: white; padding: 25px">
  
<div class="row ">
               
                  <?php  
                    $connect = connectDB();
                    $req = $connect ->query('SELECT * FROM events WHERE titre LIKE "Restaurant%"');
                    $event =$req ->fetchALL();
                    foreach ($event as $events): ?>
       
                  <div class ="col-md-4 col-xs-12">
                      <div class="event shadow">
                        <img src="<?= $events['img_src'] ?>" alt="imgevent" width="300" height="200" class="card-img-top eventImages img-fluid">
                        <h3 class="event-title"> <?= $events['titre'] ?>  </h3>   
                        <p class="event-desc"> <?= $events['date_event'] ?> <br> <?= $events['contenu'] ?> </p>
                        <a href="event.php?id=<?= $events['id']?>" type="button" class="btn btn-info"  role="button" aria-disabled="true"> Afficher Plus  </a>
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
