<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
 

if(isset($_POST['query'])){
$inpText=$_POST['query'];
   



$query=" SELECT  * FROM users WHERE firstname LIKE '%$inpText%' ";
$result =$connect->query($query);

                   
?>
<link href="css/accueil.css" rel="stylesheet" type="text/css">  
               <body>
<section class="sections eventspos"  style="margin-top:10px; "> 
  
     <div class="container shadow"style="background-color: white; padding: 25px">
  
<div class="row ">




              
<br>
<br>
<br>
<section > 
    



<table class="table">
  <thead class="thead-dark">
    <tr>
   
      <th scope="col">Nom</th>
      <th scope="col">Prénom</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
 
      
  <?php 

  if($result->rowCount() > 0) {
  while($row=$result->fetch()){

//invitation groupe
if(isset($_POST['demander'])){
  
    $groupe=$connect->prepare('INSERT INTO groupe(id_demandeur,id_receveur,statut) VALUES (?, ?, ?)');
    $groupe->execute(array($_SESSION['id'],$row['id'],1)); 

     header('Location: profil.php?id=' . $row['id']);
  exit; }
   ?>


<tr>






      <td><?= $row['lastname'] ?></td>
      <td><?= $row['firstname'] ?></td>
      <td> 


  
   
    <a href="profil.php?id=<?= $row['id'] ?>"> Voir le profil </a> <br> 
     
    <form method="post">
  <input type="submit" name="demander" value="Ajouter au groupe "/>
</form>
    
   
    
    <?php
     } 
}
}else{
  echo"<p>Pas de résultat</p>";
}







?>


    



                    </td>
    </tr>
    

  </tbody>
</table>
</section>


