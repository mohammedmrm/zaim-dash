<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,3,4,5,6,7,8,9,10,11,12]);
$client = $_REQUEST['client'];

require("dbconnection.php");
try{
  if($_SESSION['role'] == 1 || $_SESSION['role'] == 5 || $_SESSION['role'] == 7 || $_SESSION['role'] == 9){
       $branch ="";
  }else{
   $branch = " and clients.branch_id=".$_SESSION['user_details']['branch_id'];
  }
  if(empty($client)){
   $query = "select stores.*, clients.name as client_name , clients.phone as client_phone,
             if(date_format(a.old_date,'%Y-%m-%d') is not null,date_format(a.old_date,'%Y-%m-%d'),'9999-12-31') as old_date,a.orders as orders
             from stores
             left join clients on clients.id = stores.client_id
             left join (
                 select SUM(IF (invoice_id = 0,1,0)) as orders,
                        min(date) as old_date,
                        max(store_id) as store_id
                 from orders where orders.confirm=1
                 group by orders.store_id
             ) a on a.store_id = stores.id ".$branch." order by  old_date ASC,orders DESC
             ";
    $data = getData($con,$query);

  }else {
   $query = "select stores.*, clients.name as client_name , clients.phone as client_phone,
             if(date_format(a.old_date,'%Y-%m-%d') is not null,date_format(a.old_date,'%Y-%m-%d'),'9999-12-31') as old_date,a.orders as orders
             from stores
             left join clients on clients.id = stores.client_id
             left join (
                 select SUM(IF (invoice_id = 0,1,0)) as orders,
                        min(date) as old_date,
                        max(store_id) as store_id
                 from orders where orders.confirm=1
                 group by orders.store_id
             ) a on a.store_id = stores.id
             ";
   $query .= " where stores.client_id=? ".$branch." order by  old_date ASC,orders DESC";
   $data = getData($con,$query,[$client]);
  }
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array("success"=>$success,"data"=>$data)));
?>