<?php
session_start();
header('Content-Type: application/json');
require("_access.php");
access([1,2,3,4,5,6,7,8,9,10,11,12]);
require("dbconnection.php");
try{
  $query = "SELECT * FROM `auto_update` INNER join cites on city_id = cites.id";
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo (json_encode(["success"=>$success,"data"=>$data]));
?>