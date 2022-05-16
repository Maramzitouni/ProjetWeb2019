<?php
session_start();
require ('connexionDB.php') ;
require("functions.php");

if (!isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }
 
   

$connect =connectDB();

$req=$connect->query('DELETE FROM commentaire WHERE id = ' .$_GET['id1'] );
$id=$_GET['id'];
?>
<script>
 history.back();
</script>