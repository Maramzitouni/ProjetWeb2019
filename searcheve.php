<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>search box</title>
  <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">
		
			<h4> </h4>
			<form action="details.php" method="post">
				<input type="text" name="search" id="search">
				<input type="submit" name="submit" value="Search">
             </form>
  
		 <div class="list-group" id="show-list">
		 	
		 	

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



</body>
