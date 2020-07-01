<?php
if(!isset($_SESSION)){
session_start();
}
try{
$con2 = new PDO('mysql:host=localhost;dbname=nahar', "root",
"", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
$con2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException  $e ){
}
function getData2($db,$query,$parm = []) {
  $stmt = $db->prepare($query);
  $stmt->execute($parm);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;
}

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
     $link = "https";
}else{
    $link = "http";
}
// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

function access($access_roles = []){
  if(!empty($_COOKIE['username_d']) && !empty($_COOKIE['password_d'])){
    $sql = "select staff.*,role.home as home from staff inner join role on role.id = staff.role_id where phone = ? and password =? and status=1";
    $result = getData2($GLOBALS['con2'],$sql,[$_COOKIE['username_d'],$_COOKIE['password_d']]);
  }
  if(count($result)> 0){
    $_SESSION['login']=1;
    $_SESSION['username']=$result[0]['phone'];
    $_SESSION['userid']=$result[0]['id'];
    $_SESSION['role']=$result[0]['role_id'];
    $_SESSION['user_details']=$result[0];
  }
  if(!in_array($_SESSION['user_details']['role_id'],$access_roles) || !isset($_SESSION['userid'])){
    header("location: login.php?redirect=".$GLOBALS['link']);
    die("<h1>لاتمتلك صلاحيات الوصول لهذه الصفحة  (<a href='login.php'>سجل الدخول</a>)</h1>");
  }
}
?>