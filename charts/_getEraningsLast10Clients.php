<?php
session_start();
//error_reporting(0);
header('Content-Type: application/json');
require("../script/_access.php");
access([1,2,5,3]);
require("../script/dbconnection.php");
require_once("../config.php");
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
if(empty($end)) {
  $end = date('Y-m-d h:i:s', strtotime($end. ' + 1 day'));
}else{
   $end =date('Y-m-d', strtotime($end. ' + 1 day'));
   $end .=" 00:00:00";
}
if(empty($start)) {
  $start = date('Y-m-d h:i:s',strtotime($start. ' - 7 day'));
}else{
   $start .=" 00:00:00";
}
if($_SESSION['user_details']['role_id'] == 1){
  $sql = 'select sum(new_price) as income, count(*) as orders_no ,
          clients.name as client_name, max(branches.name) as branch_name,
          max(DATE_FORMAT(date, "%Y-%m-%d")) as date,sum(discount) as discount,
          sum(
               if(order_status_id = 9,
                   0,
                   if(to_city = 1,
                         if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount)),
                         if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount))
                    )
                )
          ) as earnings
          from orders
          inner join clients on clients.id = orders.client_id
          inner join branches on branches.id = orders.from_branch
          left JOIN client_dev_price
            on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where date between "'.$start.'" and "'.$end.'"
          GROUP by  orders.client_id limit 10';

}else{
  $sql = 'select sum(new_price) as income, count(*) as orders_no ,
          clients.name as client_name, max(branches.name) as branch_name,
          max(DATE_FORMAT(date, "%Y-%m-%d")) as date,sum(discount) as discount,
          sum(
               if(order_status_id = 9,
                   0,
                   if(to_city = 1,
                         if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount)),
                         if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount))
                    )
                )
          ) as earnings
          from orders
          inner join clients on clients.id = orders.client_id
          inner join branches on branches.id = orders.from_branch
          left JOIN client_dev_price
            on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where date between "'.$start.'" and "'.$end.'" and from_branch = "'.$_SESSION['user_details']['branch_id'].'"
          GROUP by  orders.client_id limit 10';

}
$data =  getData($con,$sql);
echo json_encode(['data'=>$data]);
?>