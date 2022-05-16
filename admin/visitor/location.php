<?php

session_start();
    require ( "../../connexionDB.php");
        require("../../functions.php");
    $connect = connectDB();
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
$result=curl_exec($ch);
$result=json_decode($result);


if($result->status=='success'){ 

	echo "Country:".$result->country.'<br/>';
	$country=$result->country;
	echo "Region:".$result->regionName.'<br/>';
	$region=$result->regionName;
	echo "City:".$result->city.'<br/>'; 
	$city=$result->city;
	
	if(isset($result->lat) && isset($result->lon)){
		echo "Lat:".$result->lat.'<br/>';
		$lat=$result->lat;
		echo "Lon:".$result->lon.'<br/>';
		$lon=$result->lon;

	}
	echo "IP:".$result->query.'<br/>';
$ip=$result->query;


$id=$_SESSION['id'];

$sql= $connect->query("INSERT INTO iplocation (id_user, ipAddress,countryName,regionName ,latitude ,longitude) VALUES ( $id,'$ip','$country' ,'$region','$lat','$lon')");

	
}

