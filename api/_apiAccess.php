<?php
if(!isset($_SESSION)){
 session_start();
}
header('Content-Type: application/json');
$access = (bool) 0;
require_once("../script/dbconnection.php");
if(!(empty($_REQUEST['token']))){
  $token = $_REQUEST['token'];
}else{
  $token = "";
}
$sql = 'select * from clients where api_token=?';
$res  = getData($con,$sql,[$token]);
if(count($res) == 1){
  $access = (bool) 1;
}
function access(){
  if(!$GLOBALS['access']){
     die(json_encode(['message'=>'refused']));
  }
}
?>