<?php
    session_start(); // Permet de savoir s'il y a une session. C'est à dire si un utilisateur c'est connecté à votre site.
    include('connexionDB.php'); // Fichier PHP contenant la connexion à notre BDD
    require("functions.php");
 

$connect = connectDB();
 

if(isset($_POST['query'])){
$inpText=$_POST['query'];
   

$query=" SELECT  * FROM users WHERE (firstname LIKE '%$inpText%' OR   firstname LIKE '%$inpText%')";
$result =$connect->query($query);

                   




if($result->rowCount() > 0) {
	while($row=$result->fetch()){
		echo $row['firstname'].$row['lastname'] ;
	}
}else{
	echo"<p>Pas de résultat</p>";
}
}






?>




