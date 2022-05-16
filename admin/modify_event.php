 <?php
session_start();
?>

<?php
require_once '../connexionDB.php'; // Fichier PHP contenant la connexion à notre BDD
    require_once'../functions.php';

if (!isset($_SESSION['id'])){
        header('Location: ../index.php');
        exit;
    }
 
    if ($_SESSION['status'] != 1){
        header('Location: index.php');
        exit; 
    } 

$connect = connectDB();
   $events=getEvent($connect,1,$_GET['id']);


if (isset($_POST) AND !empty($_POST)) {
	if(!empty ($_POST['titre']) AND !empty($_POST['date_event']) AND !empty($_POST ['contenu']) AND !empty($_POST['img_src']) AND !empty($_POST['prix'])  AND !empty($_POST['lieu'])  AND !empty($_POST['details'])  AND !empty($_POST['qty'])   ) { 
     
		$req = $connect->prepare('UPDATE events SET titre = :titre , date_event = :date_event, contenu = :contenu, img_src = :img_src, prix = :prix, lieu= :lieu, details=:details, qty=:qty WHERE id = :id ');
	     $req->execute([
             'titre'=>$_POST['titre'],
             'contenu'=>$_POST['contenu'],
             'date_event'=>$_POST['date_event'],
             'img_src'=>$_POST['img_src'],
             'prix'=>$_POST['prix'],
              'lieu'=>$_POST['lieu'],
              'details'=>$_POST['details'],
             'qty'=>$_POST['qty'],
             'id'=>$_GET['id']
	            ]);
	          $_SESSION['flash']['success'] = '';


	          header('location: ../index.php');

	 }else{
	 	$_SESSION['flash']['error'] ='Champs manquants';
          }
}
?>


<!DOCTYPE html>
<html lang="fr">



<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Modifier l'evenement </title>

	<meta  name="description" content="Bienvenue sur Go2Events Admin">

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



<br>

 
                
   
        

<form style="margin-left: 200px; margin-right: 240px; border-radius: 10px; background-color:#e4eff2; padding-left: 110px" method="POST" >

  
 <h4 style="margin-left: 290px;">Modifier l'événement : <?= $events->titre?></h4>
         <br> <br>

        

        <?php
           if (isset($_SESSION['flash']['success'])) {
				echo "<div class='success'>".$_SESSION['flash']['success'].'</div>';
			}
			elseif (isset($_SESSION['flash']['error'])){
				echo "<div class='error'>".$_SESSION['flash']['error'].'</div>';
			}
		?>



  

 <div class="form-row">
    <div class="col-md-5 mb-3">
			<h5>Changer le nom:</h5>
			<input type="text" class="form-control" name="titre" value="<?= $events->titre ?>"/>
		</div> 

		<div class="col-md-5 mb-3">
    		<h5> Modifier la date:</h5>
			<input class="form-control"type="text" name="date_event" value="<?= $events->date_event ?>"/>
		</div>
	</div>

		<div class="form-row">
			<div class="col-md-5 mb-3">
    		<label for="validationTextarea"> <b>La description: </b></label>
			<textarea class="form-control " id="validationTextarea"  name="contenu"><?= $events->contenu ?> </textarea>
		</div>

		<div class="col-md-5 mb-3">
			<h5> Choisir l'image:</h5>
             <input class="form-control" type="text" placeholder="Source de l'image" name="img_src" value="<?= $events->img_src?>"/>
         </div>
         </div>

    <div class="form-row">
     <div class="col-md-5 mb-3">
			<h5>Modifier le lieu:</h5>
             <input class="form-control" type="text" placeholder="le lieu" name="lieu" value="<?= $events->lieu ?>"/>
         </div>
	
	<div class="col-md-5 mb-3">
			<h5>Changer le Prix:</h5>
             <input class="form-control" type="number" placeholder="le prix" name="prix" value="<?= $events->prix ?>"/>
         </div>
     </div>



    <div class="form-row">
     <div class="col-md-5 mb-3">
			<h5>Détailer l'événements:</h5>
             <textarea  class="form-control" id="validationTextarea "name="details" > <?= $events->details ?> </textarea>
         </div> 

        <div class="col-md-5 mb-3">
			<h5>Changer le nombre de place :</h5>
			<input type="number" class="form-control" name="qty" value="<?= $events->qty?>"/>
		</div> 
  </div>
	 	<button style="width: 300px; margin-left:100px; " class="btn btn-primary" type="submit"> Modifier </button>
  		

        
</form>










	
<!-- ------ Footer ------ -->




		<footer class="container-fluide footer">
      <div></div>
		</footer>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
