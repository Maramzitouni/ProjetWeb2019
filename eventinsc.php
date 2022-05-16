<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require('functions.php');
 

$connect = connectDB();



 
if(isset($_POST['forminscription'])) {
   $lastname = htmlspecialchars($_POST['lastname']);
     $firstname = htmlspecialchars($_POST['firstname']);
   $mail = htmlspecialchars($_POST['mail']);
   $adress = htmlspecialchars($_POST['adress']);
   $order_number= $_POST['order_number'];
  
   if(!empty($_POST['firstname']) AND !empty($_POST['mail']) AND !empty($_POST['lastname']) AND !empty($_POST['adress']) AND !empty($_POST['order_number'])) ;{
  
               
                     $id_user = $_SESSION['id'];
                     $id_event = $_GET['id'];
                     $insertmbr = $connect->prepare("INSERT INTO inscription_event (lastname,firstname, email, adress ,id_user , id_event ,order_number) VALUES(?, ?, ?,? ,?,?,?)");
                     $insertmbr->execute(array($firstname ,$lastname, $mail, $adress ,$id_user , $id_event , $order_number  ));
                     $erreur = "Votre Inscription a été prise en compte ! ";
                 
             
          } }
       
    else {
      $erreur = "Tous les champs doivent être complétés !";
   }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>S'inscrire</title>
  <meta name="description" content="page d'inscription">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/register.css" />
  
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


</head>
  
  


<body>
  
 <!-- header -->
<?php
  require_once ('menu.php');
?>
   
      <div align="center">
         <h2>Inscription</h2>
         <br /><br />
         <form method="POST" action="">
            <table>
               
               <tr>
                  <td align="right">
                     <label for="lastname">Nom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre nom" id="lastname" name="lastname" value="<?php if(isset($lastname)) { echo $lastname; } ?>" />
                  </td>
               </tr>
               

               <tr>
                  <td align="right">
                     <label for="firstname">Prénom :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre prénom" id="firstname" name="firstname" value="<?php if(isset($firstname)) { echo $firstname; } ?>" />
                  </td>
               </tr>




               <tr>
                  <td align="right">
                     <label for="mail">Mail :</label>
                  </td>
                  <td>
                     <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                  </td>
               </tr>
               
               <tr>
                  <td align="right">
                     <label for="adress">adress :</label>
                  </td>
                  <td>
                     <input type="text" placeholder="Votre adress" id="adress" name="adress" value="<?php if(isset($adress)) { echo $adress; } ?>" />
                  </td>
               </tr>
               

               <tr>
                  <td align="right">
                     <label for="$order_number">Quantité :</label>
                  </td>
                  <td>
                     <input type="number" placeholder="Quantité" id="order_number" name="order_number" value="<?php if(isset($order_number)) { echo $order_number; } ?>" />
                  </td>
               </tr>







               <tr>
                  <td></td>
                  <td align="center">
                     <br />
                     <input type="submit" name="forminscription" value="Je m'inscris" />
                  </td>
               </tr>
            </table>
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>