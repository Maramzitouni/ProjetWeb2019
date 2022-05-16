
<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    include("functions.php");
     $connect = connectDB();
 ?>




<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Page d'accueil</title>

  <meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
  <link href="css/accueil.css" rel="stylesheet" type="text/css">
  <script src="https://kit.fontawesome.com/275e6ee6a8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <link rel="stylesheet" href="style.css">
</head>

<body>
<!-- header -->
<?php require ('menu.php'); ?>

<!-- home -->

  <section class="sections home text-center" >
 
    <div class="overlay" style="position: absolute;
     top:0;
     bottom:0;
     left:0;
     right:0;
     background: rgba(0,0,0,0.15);">
    <div class="container">
      <div class="lead home-content">
         

<?php if (isset($_SESSION['id'])) { ?> 
         <h3 class="home-title"> <i class="material-icons"> room </i> Vous êtes à

          <?php  $_SESSION['id'] = $id;  
            $visitor= $connect->prepare('SELECT * FROM iplocation WHERE id_user = ? ORDER BY id DESC LIMIT 1');

            $visitor->execute(array($id));
           $visitor= $visitor->fetch();
             echo $visitor['countryCode'];
          
           
            
 } ?> 
         </h3>
         <p class="home-desc">
            Découvrez nos meilleurs événements du moment et réservez vos billets <br> de concerts , musées et autres en ligne.
         </p>

<?php if (isset($_SESSION['id'])) { ?> 
          <button type="button" class="btn btn-info">

          <a href="presdemoi.php">  choisir un autre lieu </a> 



          </button>
         

  <?php  
 } ?> 
<?php if (!isset($_SESSION['id'])) { ?> 
   <a href="login.php" class="btn btn-info"> Veuillez se connecter </a>
   
        <?php  
 } ?>  

          </div>
      </div>
    </div>
 </section> 
 <!-- home -->

<div  class="wrapper">
  <nav  id="sidebar">
      <ul class="nav flex-column">

            <li>
       
            <div class="container">
      <form action="details.php" method="post">

        <input type="text" name="search" id="search" style=" ">  <button type="submit" name="submit" value="Search" class="btn btn-info"
        style=" margin-top: 3px ;"
         > rechercher</button>

             </form>
     <div style="background-color:#343a40; " id="show-list">
      
      

     </div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#search").keyup(function(){
      var searchText = $(this).val();
      if(searchText!=''){
        $.ajax({
          url:'actioneven.php',
          method:'post',
          data:{query:searchText},
          success: function(response){
            $("#show-list").html(response);
          }
        });
      }else{
        $("#show-list").html('');
      }
    });
    $(document).on('click','a',function(){
      $("#search").val($(this).text());
      $("#show-list").html('');
    });
  });


</script>


            </li>

            <li class="active nav-item">
              <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="nav-link">Tous</a>
            </li>
     
            <li class="nav-item">
              <a class="nav-link" href="concert.php">Concert</a>
            </li>
    
            <li class="nav-item">
              <a class="nav-link" href="bar.php">Bar</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="expo.php">Exposition</a>
            </li>

            <li class="nav-item">
              <a class="nav-link"href="randonnee.php">Randonnée</a>
            </li>
  
      </ul>
  </nav>


<div id="content">
  

 <!-- Evenements -->

  <section class="sections eventspos">    
     <div class="container">
        
        <div class="section-header">
           <h2 class ="section-title">Événements populaires :  </h2>
        </div>   

      <!-- section header-->

       <div id="carouselExampleInterval" class="carousel slide" data-ride="carousel">  
          <div class="row">
   
            <?php  
                $connect = connectDB();
                $req = $connect ->query('SELECT * FROM events');
                $event =$req ->fetchALL();
                foreach ($event as $events): ?>
              
                <div class ="col-md-4 col-xs-12">
                    <div class="event shadow">
                      <img src="<?= $events['img_src'] ?>" alt="imgevent" width="300" height="200" class="card-img-top eventImages">
                      <h3 class="event-title"> <?= $events['titre'] ?>  </h3>   
                      <p class="event-desc"> <?= $events['date_event'] ?> <br> <?= $events['contenu'] ?> </p>
                      <a href="event.php?id=<?= $events['id']?>" type="button" class="btn btn-info"  role="button" aria-disabled="true"> Afficher Plus  </a>
                    </div>
                 <br>
                </div>
            <?php endforeach ?> 
        </div>

       </div>
      
      </div> 
   </section>   
 


    <!--formulaire newsletter --->      

    <section> 
        <div class="inscription_boite">
            <h3>Abonnez-vous à notre liste de diffusion</h3>
              <form class="inscription">
                <input type="email" placeholder="exemple@exemple.com" required autocomplete="off">
                <button type="submit">Inscription</button>
              </form>
        </div>
    </section>
 <!-- home -->


<!-- ------ A propos ------ -->


<section class="sections about" style="background-color:#e4eff2;">
  <div class="container">
    <div class="section-header text-center" >
    <h2 class ="section-title">À Propos de Nous </h2>
    <div class="line"><span> </span></div>
    <p>Nous avons créée ce site web pour un projet annuel à l'ESGI. Nous sommes 2 étudiantes assez fétarde qui avait envie de réaliser un site web spécialement pour les events de type randonnée, bar, concert.... J'espere que celui ci vous plaira, mais il n'y a pas de raison ;) <a href="bonus/index.html">Amusez vous </a> bien surtout !! </p>

  </div>

</div>
</section>
 




      










</div>
<!-- Footer -->

 
  </body>
</body>
</html>
