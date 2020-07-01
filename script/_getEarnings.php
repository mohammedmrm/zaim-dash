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
  $end = date('Y-m-d 00:00:00', strtotime($end. ' + 1 day'));
}else{
   $end =date('Y-m-d', strtotime($end. ' + 1 day'));
   $end .=" 00:00:00";
}
if(empty($start)) {
  $start = date('Y-m-d 00:00:00',strtotime($start. ' - 7 day'));
}else{
   $start .=" 00:00:00";
}
if($_SESSION['user_details']['role_id'] == 1){
  $sql = 'select
            sum(
               if(order_status_id = 4,
                if(to_city = 1,
                 if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount))),
                 if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount)))
                ),0)
             ) as earnings,
             sum(
                 if(order_status_id = 4,
                   new_price -
                   (
                       if(to_city = 1,
                         if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount))),
                         if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount)))
                        )
                   ),0
                )
             ) as client_price,
             sum(if(order_status_id = 4,new_price,0)) as income,
             sum(if(order_status_id=9,0,discount)) as discount,
             count(orders.id) as orders,
            max(clients.name) as name,
            max(clients.phone) as phone,
            max(branches.name) as branch_name
            from orders
            left join clients on clients.id = orders.client_id
            left join branches on  branches.id = clients.branch_id
            left JOIN client_dev_price
            on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
            where date between "'.$start.'" and "'.$end.'"
             and orders.confirm = 1 ';

}else{
  $sql = 'select
            sum(
                 if(order_status_id = 4,
                     if(to_city = 1,
                           if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount))),
                           if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount)))
                      ),0
                  )
             ) as earnings,
             sum(
                if(order_status_id = 4,
                 new_price -
                 (
                     if(to_city = 1,
                           if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_b'].' - discount),(client_dev_price.price - discount))),
                           if(order_status_id=9,0,if(client_dev_price.price is null,('.$config['dev_o'].' - discount),(client_dev_price.price - discount)))
                      )
                ),0)
             ) as client_price,
            sum(if(order_status_id = 4,new_price,0)) as income,
            sum(if(order_status_id=9,0,discount)) as discount,
            count(orders.id) as orders,
            max(clients.name) as name,
            max(clients.phone) as phone,
            max(branches.name) as branch_name
            from orders
            left join clients on clients.id = orders.client_id
            left join branches on  branches.id = clients.branch_id
            left JOIN client_dev_price
            on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
            where branch_id ="'.$_SESSION['user_details']['branch_id'].'" and orders.confirm = 1 and date between "'.$start.'" and "'.$end.'"
            ';

}
$sql1 = $sql."  GROUP by  orders.client_id";
$data =  getData($con,$sql1);
$total=getData($con,$sql);

$total[0]['start'] = date('Y-m-d', strtotime($start));
$total[0]['end'] = date('Y-m-d', strtotime($end." -1 day"));
echo json_encode([$sql1,'data'=>$data,"total"=>$total]);
?>