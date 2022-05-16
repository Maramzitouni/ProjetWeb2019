<?php
  session_start();  
  require "functions.php";
  include('admin/visitor/Mobile_Detect.php');
include('admin/visitor/BrowserDetection.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="description" content="page de connexion ">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/connect.css" type="text/css" />
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>


  <!-- header -->
<?php
  require_once ('menu.php');
?>
<!-- header -->



<?php


 

    //Vérifier les idenfiants
    if( !empty($_POST) ){
      $connect = connectDB();
    

      $_POST["email"] = trim(strtolower($_POST["email"]));

      $queryPrepared = $connect->prepare("SELECT  pwd, id ,status ,firstname   FROM users WHERE email=:email");

      $queryPrepared->execute(["email"=>$_POST["email"]]);

      $result = $queryPrepared->fetch();

      $pwdHashed = $result["pwd"];

      if(password_verify($_POST["pwd"], $pwdHashed)){
        //Créer une session
        $_SESSION["token"] = createToken($_POST["email"], $result["id"]);
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["id"] = $result["id"];
        $_SESSION["status"]= $result["status"];
        $_SESSION["user"]= $result["firstname"];
         


  $res=$connect->prepare("SELECT * from users where email=:email");
  $res->execute(["email"=>$_POST["email"]]);

$count=$res->rowCount();

  if($count>0){
    $row= $res->fetch();
    $_SESSION['id']=$row['id'];
    $timer =time()+10;
    $res=$connect->query("UPDATE users set last_login = $timer where id=".$_SESSION['id']); }
   








      }else{
        echo "Identifiants incorrects";
      }
    }

  ?>

  <?php

if(isConnected()){

$browser=new Wolfcast\BrowserDetection;

$browser_name=$browser->getName();
$browser_version=$browser->getVersion();

$detect=new Mobile_Detect();

if($detect->isMobile()){
  $type='Mobile';
}elseif($detect->isTablet()){
  $type='Tablet';
}else{
  $type='PC';
}

if($detect->isiOS()){
  $os='IOS';
}elseif($detect->isAndroidOS()){
  $os='Android';
}else{
  $os='Window';
}

$url=(isset($_SERVER['HTTPS'])) ? "https":"http";
$url.="//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$ref='';
if(isset($_SERVER['HTTP_REFERER'])){
  $ref=$_SERVER['HTTP_REFERER'];
}
$id=$_SESSION['id'];
$sql= $connect->query("insert into visitor (id_user ,browser_name,browser_version,type,os,url,ref) values($id,'$browser_name','$browser_version','$type','$os','$url','$ref')");

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

$sql= $connect->query("INSERT INTO iplocation (id_user, ipAddress,countryName,regionName ,latitude ,longitude ,countryCode) VALUES ( $id,'$ip','$country' ,'$region','$lat','$lon','$city')");

  
}




























  header("Location: index.php");





}else{

?>
  

 <section class="login"> 
  <div class="container"> 
  <form  method="POST">
    <div class="form-group">
      <label for="exampleInputEmail1">Adresse mail :</label>
      <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

      <br>

      <label for="exampleInputPassword1">Mot de passe :</label>
      <input type="password" name="pwd" class="form-control" id="exampleInputPassword1">
      <br>
      
    <button  type="submit" herf="index.php" class="btn btn-info" id="connect">connexion</button>
    </div>
  </form>
  </div>

 </section>

<?php

}

?>







</body> 
</html> 
