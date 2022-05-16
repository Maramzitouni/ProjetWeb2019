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

$req=$connect->query('DELETE FROM events WHERE id= ' .$_GET['id']);

header('location:../index.php');