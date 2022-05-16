<?php
session_start();
require ('../connexionDB.php') ;
require("../functions.php");

if (!isset($_SESSION['id'])){
        header('Location: ../index.php');
        exit;
    }
 
    if ($_SESSION['status'] != 1) {
        header('Location: ../index.php');
        exit;
    }


$connect =connectDB();




$req2= $connect->prepare('DELETE FROM commentaire WHERE id=?');
$req2->execute(array($_GET['id']));



  









?>