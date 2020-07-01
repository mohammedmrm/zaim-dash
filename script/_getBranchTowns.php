<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("dbconnection.php");
require("../config.php");
$id= $_REQUEST['id'];
$success=0;
$i=0;
try{
  $query = "select branch_towns.*,towns.name as town_name, cites.name as city_name
            from branch_towns
            left join towns on towns.id = branch_towns.town_id
            left join cites on cites.id = towns.city_id
            where branch_id =?";
  $data = getData($con,$query,[$id]);

  $sql = "select * from branches where id=?";
  $res = getData($con,$sql,[$id]);
  $res =$res[0];
  $success = 1;
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
echo json_encode(array($id,"success"=>$success,"data"=>$data,'Branch_info'=>$res));
?>