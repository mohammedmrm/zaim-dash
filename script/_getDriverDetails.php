<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("../config.php");
$id = $_REQUEST['driver'];
$data = [];
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];
$statues = $_REQUEST['status'];
$success =0;
if(!empty($end)) {
   $end .=' 23:59:59';
}
if(!empty($start)) {
  $start .=" 00:00:00";
}

if($_REQUEST['price'] > 0){
  $driver_price = $_REQUEST['price'];
}else {
  $driver_price = $config['driver_price'];
}
use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
$v->validate([
    'id' => [$id,'required|int'],
]);
function validateDate($date, $format = 'Y-m-d H:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
if($v->passes()) {
  $sql = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat,  order_status.status as status_name,
          cites.name as city_name,
          towns.name as town_name,
            if(to_city = 1,
                 if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                 if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
            ) as dev_price,
            new_price -
              (if(to_city = 1,
                  if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                  if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
                 )
             ) as client_price,
             if(orders.order_status_id=4 or order_status_id = 6 or order_status_id = 5,'".$driver_price."',0) as driver_price
          from orders
          left join order_status on orders.order_status_id = order_status.id
          left join cites on orders.to_city = cites.id
          left join towns on orders.to_town = towns.id
          left JOIN client_dev_price on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where driver_id = '".$id."' and driver_invoice_id = 0  and orders.confirm =1
          ";
  $filter = "";
    if(validateDate($start) && validateDate($end)){
      $sql .= " and orders.date between '".$start."' AND '".$end."' ";
    }
  if(count($statues) > 0){
    foreach($statues as $status){
      if($status > 0){
        $filter .= " or order_status_id=".$status;
      }
    }
  }
  $filter = preg_replace('/^ or/', '', $filter);
  if($filter != ""){
    $filter = " and (".$filter." )";
    $sql .= $filter;
  }
  $res3= getData($con,$sql,[]);
  if(count($res3) > 0){
    $success = 1;
  }
  $sql = "select
          sum(new_price) as income,

          sum(
                 if(order_status_id = 9,
                     0,
                     if(to_city = 1,
                           if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                           if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
                      )
                  )
          ) as dev,
          sum(if(order_status_id = 4 or order_status_id = 6 or order_status_id = 5,".$driver_price.",0)) as driver_price,
          sum(new_price -
              (
                 if(order_status_id = 9,
                     0,
                     if(to_city = 1,
                           if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                           if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
                      )
                  )
              )
          ) as client_price,
          sum(discount) as discount,
          count(*) as orders
          from orders
          left JOIN client_dev_price on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where driver_id = ?  and driver_invoice_id = 0 and orders.confirm =1
          ";
        if(validateDate($start) && validateDate($end)){
          $sql .= " and date between '".$start."' AND '".$end."' ";
         }
        if($filter != ""){
          $sql .= $filter;
        }
          $res4= getData($con,$sql,[$id]);
          $res4= $res4[0];
$sql2 = "select driver_invoice.*,date_format(driver_invoice.date,'%Y-%m-%d') as in_date,
           staff.name as driver_name, staff.phone as driver_phone
           from driver_invoice
           left join  staff on staff.id = driver_invoice.driver_id
           where driver_id='".$id."'";
        if(validateDate($start) && validateDate($end)){
          $sql2 .= " order by driver_invoice.date DESC limit 25";
         }
         $res2 = getData($con,$sql2);
if(count($res2) > 0){
    $success = 1;
}
}else{
 $success = 0;
 $error = [
           'id'=>  implode($v->errors()->get('id')),
];
}
echo json_encode(array($sql,"success"=>$success,"data"=>$res3,"invoice"=>$res2,'pay'=>$res4));
?>