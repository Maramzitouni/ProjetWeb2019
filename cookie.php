<?php

session_start();

//setcookie("login", 0);
//echo $_COOKIE['login'];


//$_SESSION["auth"] = true;



if($_SESSION["auth"] == true){
	echo "Vous êtes connecté";
}