

<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.

    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
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
<!-- header -->
   
   
<?php




  if( isset($_COOKIE['errorsRegister']) ){

    $listOfErrors = unserialize($_COOKIE['errorsRegister']);
    foreach ($listOfErrors as $error) {
      echo "<li>".$error;
    }

    setcookie('errorsRegister',false);
    
  }

  ?>

  <?php
    if(isset($_COOKIE["dataRegister"])){
      $data = unserialize($_COOKIE["dataRegister"]);
      
    }
  ?>
  <section class="register"> 
  
       <form action="addUser.php" method="POST">
          <div class="container-form" >
              
              <div  style="padding: 1.5px; " class="form-group col-md-12">
                    <label for="inputEmail4">Email :</label>
                    <input type="email" name="email" class="form-control" id="inputEmail4" placeholder="Adresse email" required="required">
              </div>

              <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="inputPassword4">Mot de passe :</label>
                     <input type="password" name="pwd" class="form-control" id="inputPassword4" placeholder="Mot de passe" required="required">
                    </div>

              <div class="form-group col-md-6">
        <label for="inputPassword4">Confirmation :</label>
        
        <input type="password" name="pwdConfirm" class="form-control" id="inputPassword" placeholder="Mot de passe" required="required">
      </div>

    </div>
  
   

    <div class="form-row">

      <div class="form-group col-md-6">
        <label for="inputAddress"> Nom :</label>
        <input type="text" name="lastname" class="form-control" id="inputName" placeholder="Nom" required="required" value="<?php echo (isset($data["lastname"]))?$data["lastname"]:"";?>">
      </div>
      
      <div class="form-group col-md-6">
        <label for="inputAddress"> Prénom :</label>
       <input type="text" name="firstname" class="form-control" id="inputLName" placeholder="Prénom" required="required" value="<?php echo (isset($data["firstname"]))?$data["firstname"]:"";?>">
      </div>

    </div>



  <div style="padding: 1.5px;" class="form-group col-md-12">
    <label for="inputAddress2">Adresse :</label>
    <input type="text" name="adress" class="form-control" id="inputAddress" placeholder="Adresse complète"required="required">
  </div>

  
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Date de naissance :</label>
      <input type="date" class="form-control" id="inputCity" name="birthday" placeholder="Date de naissance" required="required">
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip"> Téléphone : </label>
      <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Téléphone" required="required">
    </div>
<div class="form-group col-md-12">
<label> Captcha </label> : 
    <img src="captcha.php" width="180px" style="margin: 15px;"> 

    <input type="text" name="captcha" placeholder="Captcha en minuscule" required="required" > 
    <label style="margin-left: 20px;">J'accepte les CGUs  <input type="checkbox" name="cgu" required="required"></label>
    <button type="submit" herf="index.php" class="btn btn-info" id="register">S'inscrire</button>

</div>

</form>
</section>


</body>
</html>