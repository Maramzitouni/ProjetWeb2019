<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();

if (!isset($_SESSION['id'])){
      header('Location: index.php'); 
      exit;}




?>

<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Google Maps JavaScript API with Places Library Autocomplete Address Field</title> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
 

  <script src="https://kit.fontawesome.com/275e6ee6a8.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
<!-- Google Maps JavaScript library -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl6OTcvR-AWxG3fmeIS90_t7zlVxCWmfU&callback=initMap">
  </script>
  <link href="css/event.css" rel="stylesheet" type="text/css">  


  
<body style="
  background-color: #A9A9A9; 
  height: 800px;
   background-image: url('img/event3.jpg'); 
   background-size: cover; 
   background-position: center;
   position: relative;
  
}">
    <?php        require_once ('menu.php');  ?>
    




  <div class="container" style="padding-top: 100px; margin-left:450px;">
      <form action="details.php" method="post">

        <input type="text" name="search" id="search" style="width:420px;height: 40px;" placeholder="Lieu..">  
         
        <button type="submit" name="submit" value="Search" class="btn btn-info"
        style=" margin-top: 3px;  margin-left: 2px ;"
         > rechercher</button>

             </form>
    
</div>




     <div style=";" id="show-list">
      

     </div>





  
   


<script type="text/javascript">
  $(document).ready(function(){
    $("#search").keyup(function(){
      var searchText = $(this).val();
      if(searchText!=''){
        $.ajax({
          url:'actionlocation.php',
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






</body>
</html>


