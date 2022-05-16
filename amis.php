<?php
  session_start();

  include('connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD
include("functions.php");
 
 
   $connect = connectDB();


  if (!isset($_SESSION['id'])){
      header('Location: index.php'); 
      exit;
  }





$follow=$connect->prepare('SELECT * FROM follow WHERE id_follower = ? or id_followed = ?');

$follow->execute(array($_SESSION['id'],$_SESSION['id']));


$ld = $follow->rowCount();







$follows=$connect->prepare('SELECT * FROM follow WHERE id_follower = ? or id_followed = ?');

$follows->execute(array($_SESSION['id'],$_SESSION['id']));










   $users= $connect->query('SELECT * FROM users  ');
    
  
?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Page d'amis</title>

  <meta  name="description" content="Bienvenue sur Go2Events, vous vous trouvez sur la page d'accueil de vos meilleurs sorties">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 
  
</head>
<body style="
  background-color: #A9A9A9; 
  height: 800px;
   background-image: url('img/amis.jpg'); 
   background-size: cover; 
   background-position: center;
   position: relative;
  
}">
<!-- header -->
<?php require ('menu.php'); ?> 




<div class="container" style="padding-top: 100px; margin-left:450px;">
      <form action="details.php" method="post">

        <input type="text" name="search" id="search" style="width:420px;height: 40px;" placeholder="utilisateur..">  
         
        <button type="submit" name="submit" value="Search" class="btn btn-info"
        style=" margin-top: 3px;  margin-left: 2px ;"
         > rechercher</button>

             </form>
             <br>
    
</div>

     <div style=";" id="show-list"> </div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#search").keyup(function(){
      var searchText = $(this).val();
      if(searchText!=''){
        $.ajax({
          url:'actionamis.php',
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




<ul class="list-group">
  <li class="list-group-item active" style="background-color: #FF8C00; border-color:orange"> Liste d'abonnements : </li>
  

  

      <?php 

              while ($i=$follow->fetch() AND  $ld       ) {
                   

                   if( $i['id_follower'] == $_SESSION['id'] ){

                      $user=$connect->prepare('SELECT * FROM users WHERE id = ?');


                        $user->execute(array($i['id_followed']));
                        $username=$user->fetch(); 
             
                echo "<li class='list-group-item'>".$username['firstname'] ; 
                          
                        echo "<br>".$username['lastname'] .''  ;





                    }  ?>
              </li>
                 </ul>   

<?php } ?>


  


<!-- home -->

  <ul class="list-group">
  <li class="list-group-item active" style="background-color: #FF8C00; border-color:orange"> Liste d'abonnés : </li>
  






      <?php 

              while ($r=$follows->fetch()) {
                   

                   if( $r['id_followed'] == $_SESSION['id'] ) {

                     $user1=$connect->prepare('SELECT * FROM users WHERE id = ?');


                        $user1->execute(array($r['id_follower']));
                        $username1=$user1->fetch();

                        echo "<li class='list-group-item'>". $username1['firstname'] . '';
                          
                        echo "<br>".$username1['lastname']  ;
                      

                  
     





                      } ?>
              
                
 </li>
                 </ul>



<?php } ?>

 </body>
</html>


<!--
<ul class="list-group">
  <li class="list-group-item active" style="background-color: #FF8C00; border-color:orange"> Demande de groupes : </li>
  -->

<?php 
/*
$_SESSION['id']=$id;
$mes_demandes=$connect->query('SELECT groupe.* , users.lastname, users.firstname
 
 FROM groupe  
  LEFT JOIN users  ON users.id = groupe.id_demandeur 
  WHERE groupe.id_receveur = $id AND groupe.statut = 1');
$mes_demandes = $mes_demandes->fetchAll();


?>


<table>
  <tr>
    <th>Nom prénom</th>
    <th></th>
    <th></th>
  </tr>
  <?php
    foreach($mes_demandes as $md){ 
  ?>  
  <tr>
    <form method="post">
      <td>
        <?= $md['lastname'] . ' ' . $md['firstname']?> 
        <input type="hidden" name="id_demande" value=""/>
      </td>
      <td>
        <input type="submit" name="accepter" value="Accepter"/>
      </td>
      <td>
        <input type="submit" name="refuser" value="Refuser"/>
      </td>
    </form>
  </tr>   
  <?php
    }
  ?>
</table>



<?php

if(isset($_POST['accepter'])){
  $id_demande = (int) $id_demande;
 
  $verifier_demande = $connect->query("SELECT *
    FROM groupe  
    WHERE id = ?",
    array($id_demande));
 
  $verifier_demande = $verifier_demande->fetch();
 
  if(isset($verifier_demande['id'])){
    $connect->insert('UPDATE groupe  SET statut = ? WHERE id = ?',
      array(2, $verifier_demande['id']));
 
    header('Location: /amis.php'); 
    exit;
  }
}





if(isset($_POST['refuser'])){
 
  $id_demande = (int) $id_demande;
 
  $connect->insert('DELETE FROM groupe  WHERE id = ?',
    array($id_demande));
 
  header('Location: /amis.php'); 
  exit;
}
?>











</ul>

*/

?>



 