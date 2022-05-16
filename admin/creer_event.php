<?php
session_start();

require ( "../connexionDB.php"); // Fichier PHP contenant la connexion à notre BDD
    require("../functions.php");



 if (!isset($_SESSION['id'])){
        header('Location: ../index.php');
        exit;
    }
 
    if ($_SESSION['status'] != 1) {
        header('Location: ../index.php');
        exit;
    }

    if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        if (isset($_POST['creer-event'])){

            $titre  = (string) htmlentities(trim($titre)); 
            $contenu = (string) htmlentities(trim($contenu)); 
            $date_event = (string) htmlentities(trim($date_event));
            $img_src= (string) htmlentities(trim($img_src));
            $prix=(float)(trim($prix));
            $lieu=(string) htmlentities(trim($lieu));
            $details = (string) htmlentities(trim($details));
            $qty=(float)(trim($qty));
           
            if(empty($titre)){
                $valid = false;
                $er_titre = ("Il faut mettre un titre");
            }       

            if(empty($contenu)){
                $valid = false;
                $er_contenu = ("Il faut mettre une description");
            }       

            if(empty($date_event)){ 
                $valid = false;
                $er_date = "Le date ne peut pas être vide";
            }
           
             if(empty($img_src)){
             	$valid=false;
             	$er_img= "Il faute mettre une image";
              } 

           if(empty($prix)){
                $valid=false;
                $er_img= "Il faute indiquer le prix";
              } 


              if(empty($lieu)){
                $valid=false;
                $er_img= "Il faute préciser le lieu";
              } 

            
            if(empty($details)){
                $valid=false;
                $er_img= "Il faute ajouter la description";
              }

             if(empty($qty)){
                $valid=false;
                $er_img= "Il faute ajouter le nombre de place";
              }



               }


            if($valid){

             $connect = connectDB();
           
              $req= $connect-> prepare('INSERT INTO events (titre, contenu, date_event, img_src, prix, lieu, details) VALUES (:titre, :contenu, :date_event, :img_src, :prix, :lieu, :details , :qty)'); 
                    
              $req->execute(
              	['titre' => $_POST['titre'],
             'date_event' => $_POST['date_event'],
             'contenu' => $_POST['contenu'],
             'img_src'=> $_POST['img_src'],
             'prix' => $_POST['prix'],
             'lieu'=> $_POST['lieu'],
             'details'=> $_POST['details'],
             'qty'=> $_POST['qty'],

              ]); 

                header('Location:../index.php');
                exit;
            
     }    
  }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Creation d'événement</title>
    <meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>

<body>

   
        <?php
            require('menu.php');    
        ?>

        <div class="container">
            <div class="row">   

                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="cdr-ins">
                
                        <h1>Créer l'évènement</h1>
                        <form method="post">
                           
                            <?php
                                if (isset($er_titre)){
                                ?>
                                    <div class="er-msg"><?= $er_titre ?></div>
                                <?php   
                                }
                            ?>
                           
                            <div class="form-group">
                             <input class="form-control" type="text" placeholder="Votre titre" name="titre" value="<?php if(isset($titre)){ echo $titre; }?>">   
                            </div>
                           


                            <?php
                                if (isset($er_contenu)){
                                ?>
                                    <div class="er-msg"><?= $er_contenu ?></div>
                                <?php   
                                }
                            ?>
                             <div class="form-group">
                             <input class="form-control" type="text" placeholder="Bref description" name="contenu" value="<?php if(isset($contenu)){ echo $contenu; }?>">   
                            </div>
                            

                            <?php
                                if (isset($er_date)){
                                ?>
                                    <div class="er-msg"><?= $er_date ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                             <input class="form-control" type="text" placeholder="le date" name="date_event" value="<?php if(isset($date_event)){ echo $date_event; }?>">   
                            </div>


                              <?php
                                if (isset($er_img)){
                                ?>
                                    <div class="er-msg"><?= $er_img ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                             <input class="form-control" type="text" placeholder="Source de l'image" name="img_src" value="<?php if(isset($img_src)){ echo $img_src; }?>">
                         </div>


                         <?php
                                if (isset($er_prix)){
                                ?>
                                    <div class="er-msg"><?= $er_prix ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                             <input class="form-control" type="number" placeholder="Le prix" name="prix" value="<?php if(isset($prix)){ echo $prix; }?>">   
                            </div>



                            <?php
                                if (isset($er_lieu)){
                                ?>
                                    <div class="er-msg"><?= $er_lieu ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                             <input class="form-control" type="text" placeholder="Le lieu" name="lieu" value="<?php if(isset($lieu)){ echo $lieu; }?>">   
                            </div>

                           

                            <?php
                                if (isset($er_details)){
                                ?>
                                    <div class="er-msg"><?= $er_details ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Décrivez votre événements" name="details"><?php if(isset($details)){ echo $details; }?></textarea>
                            </div>
                           
                             <?php
                             if (isset($er_qty)){
                                ?>
                                    <div class="er-msg"><?= $er_qty ?></div>
                                <?php   
                                }
                            ?>
                            <div class="form-group">
                             <input class="form-control" type="number" placeholder="Nombre de place" name="qty" value="<?php if(isset($qty)){ echo $qty; }?>">   
                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="creer_event">Envoyer</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>






<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        
    </body>
</html>