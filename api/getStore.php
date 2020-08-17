<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_apiAccess.php");
access();
$token = $_REQUEST['token'];
require_once("../script/dbconnection.php");
try{
  $query = "select stores.*, clients.name as client_name , clients.phone as client_phone
  from stores inner join clients on clients.id = stores.client_id
  where clients.api_token=?";
  $data = getData($con,$query,[$token]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo json_encode(["success"=>$success,"data"=>$data,'messgae'=>""]);
?>