<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2,5]);
require("dbconnection.php");

$ids = $_REQUEST['ids'];
$statues = $_REQUEST['status'];
$success="0";
if(isset($_REQUEST['ids'])){
      try{
         $query = "update orders set order_status_id=? where id=? and invoice_id=0 and driver_invoice_id=0 and storage_id=0";
         $query2 = "insert into tracking (order_id,order_status_id,date,staff_id) values(?,?,?,?)";
         $updateRecord = "update driver_records INNER join orders on orders.id = driver_records.order_id set driver_records.order_status_id = ? where driver_records.driver_id = orders.driver_id and driver_records.order_id = ?";
         $price = "update orders set new_price=? where id=?";
         $i = 0;
         foreach($ids as $v){
           if($statues[$i] >= 1){
             $data = setData($con,$query,[$statues[$i],$v]);
             if($data > 0){
               setData($con,$query2,[$v,$statues[$i],date('Y-m-d H:i:s'),$_SESSION['userid']]);
               setData($con,$updateRecord,[$statues[$i],$v]);
               if($statues[$i] == 9){
                 setData($con,$price,[0,$v]);
               }
             }
             $success="1";
           }
           $i++;
         }
      } catch(PDOException $ex) {
          $data=["error"=>$ex];
          $success="0";
      }
 }else{
  $success="2";
}

echo json_encode([$_REQUEST,"success"=>$success,"data"=>$data]);
?>