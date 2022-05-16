<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
 

if(isset($_POST['query'])){
$inpText=$_POST['query'];
   

$query=" SELECT  * FROM events WHERE lieu LIKE '%$inpText%' ";
$result =$connect->query($query);

                   
?>
<link href="css/accueil.css" rel="stylesheet" type="text/css">  
               <body>
<section class="sections eventspos"  style="margin-top:10px; "> 
  
     <div class="container shadow"style="background-color: white; padding: 25px">
  
<div class="row ">




               <?php



if($result->rowCount() > 0) {
	while($row=$result->fetch()){
		?>
 
                  <div class ="col-md-4 col-xs-12" style="background-color: white; padding: 15px; color: black;">
                      <div class="event shadow">
                        <img src="<?= $row['img_src'] ?>" alt="imgevent" width="300" height="200" class="card-img-top eventImages img-fluid">
                        <h3 class="event-title"> <?= $row['titre'] ?>  </h3>   
                        <p class="event-desc"> <?= $row['date_event'] ?> <br> <?= $row['contenu'] ?> </p>
                        <a href="event.php?id=<?= $row['id']?>" type="button" class="btn btn-info"  role="button" aria-disabled="true"> Afficher Plus  </a>
                      </div>          
                  </div>


	<?php }










}else{
	echo"<p>Pas de résultat</p>";
}
}






?>
