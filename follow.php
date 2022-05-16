
<?php



session_start(); 
    include('connexionDB.php');  
    include("functions.php");
     $connect = connectDB(); 
 
 if(isset($_GET['followedid']) AND !empty($_GET['followedid'])){



$getfollowedid= intval($_GET['followedid']);
if ($getfollowedid != $_SESSION['id']) {

      $dejafollowed=$connect->prepare('SELECT * FROM follow WHERE 	id_follower = ? AND id_followed = ?');



$dejafollowed->execute(array($_SESSION['id'],$getfollowedid));
$dejafollowed = $dejafollowed->rowCount();





if($dejafollowed==0){

$addfollow = $connect->prepare('INSERT INTO follow(id_follower,id_followed) VALUES (?,?)');

$addfollow->execute(array($_SESSION['id'],$getfollowedid));

}elseif ($dejafollowed==1) {
	$deletefollow = $connect->prepare('DELETE FROM follow WHERE id_follower = ? AND id_followed = ?');
	$deletefollow->execute(array($_SESSION['id'],$getfollowedid));
}




}

}
header('location:'.$_SERVER['HTTP_REFERER']);

  









?>