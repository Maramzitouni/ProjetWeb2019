

<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();





if(isset($_GET['id']) AND !empty($_GET['id']))  { 

$getid=htmlspecialchars($_GET['id']);

$events =$connect->prepare('SELECT * FROM events WHERE id =?');
$events->execute(array($getid));
$events= $events->fetch();

$likes=$connect->prepare('SELECT id from likes WHERE id_event =?');
$likes->execute(array($getid));
$likes=$likes->rowCount();


$dislikes=$connect->prepare('SELECT id from dislikes WHERE id_event =?');
$dislikes->execute(array($getid));
$dislikes=$dislikes->rowCount();



$commentaires =$connect->prepare('SELECT * FROM commentaire WHERE id_event =?');
$commentaires->execute(array($getid));




// changer le com







   if(isset($_POST['newcom']) AND !empty($_POST['newcom']))  {
      $newcom = htmlspecialchars($_POST['newmail']);
      $insertcom = $connect->prepare("UPDATE commentaire SET text = ? WHERE id_user= ?");
      $insertcom->execute(array($newcom, $_SESSION['id']));

   }


//supprimer com




if(isset($_POST['submit_commentaire'])) {
  
  if(isset($_POST['commentaire'])  AND

      !empty($_POST['commentaire']))
  {
         $users=getUser($connect,1,$_SESSION['id']);
         $commentaire=htmlspecialchars($_POST['commentaire']);
         
          if(strlen($commentaire)>2){ 
             $date_creation = date('Y-m-d H:i:s');
             
              $ins = $connect->prepare('INSERT INTO commentaire (text,id_event ,id_user ,date_creation) VALUES (?,?,?,?) ');
              $ins->execute(array($commentaire ,$getid, $_SESSION['id'], $date_creation)); 
              header('location:event.php?id='.$getid);
              
  

  }else{
    $c_msg ="le commentaire doit faire plus de 3 caractères";
  }
  }else{
    $c_msg="Champs vide";
  }
}



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
        <?php  $connect = connectDB(); $events=getEvent($connect,1,$_GET['id']); ?>
<br>
<br>

<section class="Event" >
    <center>
        <div class="container shadow" style="background-color: white;" >

              <div class="row"  >
                  <div class="col-lg-8">  
                    
                      <img src= "<?= $events->img_src ?>" class="img-fluid" id="imgPrincipale" alt="imagevent"   >
                  </div> 
                  <div class="col-lg-4">
                      <h4 class="titre"><?= $events->titre ?></h4>
                       <p class="text-center"><i class="far fa-calendar-times "> </i> <?= 
                       $events->date_event ?> </p>  
                       <p class="text-center"> PRIX :  <?= $events->prix ?> € </p>  
                       <p> <i class="material-icons">room </i><?=$events->lieu ?> </p>   
                       <p class="text-center">  
  </p>   
                  </div>
                </div>
                      


<div class="text-left" style="margin-right:600px;
padding: 15px;" >
 
 <?php if ( (isset($_SESSION['id']) &&  ($_SESSION['status'] != 1)) ) { // Si on ne détecte  de session mais pas admin on verra les liens ci-dessous
                ?>
          
 <a  class="btn btn-primary" href="action.php?t=1&id=<?= $getid ?>">J'aime </a> (<?= $likes ?>)

 <a  class="btn btn-primary" href="action.php?t=2&id=<?= $getid ?>">J'aime pas </a> (<?= $dislikes?>)
  <a class="btn btn-primary payer" href ="eventinsc.php?id=<?= $events->id?>">s'inscrire </a> 
<?php } ?> 
  
 <?php if( (!isset($_SESSION['status']))  || (!isset($_SESSION['id'])) || ($_SESSION['status'] != 1)) {  ?>
                                 

 

  <?php }else{ ?>
                      <a class="btn btn-danger ad" href ="admin/delete_event.php?id=<?= $events->id ?>">Supprimer cet event</a>
                    
                      <a class="btn btn-danger ad" href ="admin/modify_event.php?id=<?= $events->id ?>">Modifier cet event</a> 
 
                        
  </div>               



                   
                               

    <?php } ?> 
        
       <!--    <section>  -->
              
               <div class="contentevent" style="width: 1100px ; padding-left:1px;">
                  <div class="row">
                      
                      <div class="col-lg-7">
                           <h5 class=" desc text-justify"><?= $events->contenu ?></h5>
                            <h5 class=" propos text-justify"> A Propos de l'événement : </h5>
                                <p class="details text-justify"> <?= $events->details ?></p>
                       </div>
                       
                       <div class="col-lg-5" style="background: #ededed; margin-top: 30px;">


<?php  if ( (isset($_SESSION['id']) &&  ($_SESSION['status'] != 1)) )  { ?>
<form class="form-inline" method="POST" style="padding-right: 5px">
  
   <div class="form-group mx-sm-3 mb-2">
    <label for="inputPassword2" class="sr-only">Votre Commentaire</label>
    <button  class="btn btn-primary mb-2" type="submit" value="Poster mon commentaire" name="submit_commentaire" style="margin-top:25px;">Publier</button>

  <textarea style="margin-top:25px; margin-left: 25px ; width: 280px;" name="commentaire" placeholder="votre commentaire ..">  </textarea>
   </div>
 

</form>


<?php } ?>


<?php if (isset($c_msg)){echo "Erreur:".$c_msg; } ?>

<br>

   <div class="shadow"  >
          <div style="background: #e4eff2; border-radius: 10px; margin-top: 20px ; ">
              <h5 style="padding-left: 150px;">  Commentaires</h5>      
                 <div class="table-responsive">
                      <table  class="table table-striped">  
                        
                              <?php while($c = $commentaires->fetch()) {
$user=$connect->prepare('SELECT * FROM users WHERE id= ? ');
$user->execute(array($c['id_user']));
$user=$user->fetch();





               ?>
                                <tr>
                                <td>
                               <?= $user['firstname']?>
               
                 <?=$user['lastname']?> 
                                  </td>
                                  <td>
                                  <?= $c['text']?>
                                </td>
                                <td>
                                <?=$c['date_creation']?>
                                
                              </td>
                               <a href="delete_com.php?id1=<?=$c['id']?>&id=<?=$_GET['id']?>">Supprimer </a></li>
                               </tr>  
                                   <?php } ?>      




    

                                         
                            </table>          
                          </div>
                        </div>
    
                           

<?php }
?>

    </center>
<!-- </section> -->






                       </div>

                   </div>
                </div>      
            
           </section>






<!--------------- COMMENTAIRES --------------------------------------->



<!--------------- COMMENTAIRES --------------------------------------->





<!--------------- SIMILAIRES--------------------------------------->

<section class="sections eventspos"  style="margin-top:10px; "> 
  
     <div class="container shadow"style="background-color: white; padding: 25px">
      <h3 style="padding:15px; "> Autres:</h3>   
<div class="row ">
               
                  <?php  
                    $connect = connectDB();
                    $req = $connect ->prepare('SELECT * FROM events WHERE id !=?');
                    $req->execute(array($_GET['id']));
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
