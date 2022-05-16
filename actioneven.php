<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
 

if(isset($_POST['query'])){
$inpText=$_POST['query'];
   

$query=" SELECT  id,titre FROM events WHERE titre LIKE '%$inpText%' ";
$result =$connect->query($query);

                   




if($result->rowCount() > 0) {
	while($row=$result->fetch()){
		echo"<a href='#' class='list-group-item list' style='background-color:#343a40;'    >".$row['titre']. "<a>";
	}
}else{
	echo"<p>Pas de résultat</p>";
}
}






?>




