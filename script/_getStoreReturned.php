<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,3,5]);
require_once("dbconnection.php");
require_once("../config.php");
$id = $_REQUEST['store'];
$statues = $_REQUEST['status'];

$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
if(!empty($end)) {
   $end .=" 23:59:59";
}else{
   $end =date('Y-m-d', strtotime(' + 1 day'));
   $end .=" 23:59:59";
}
if(!empty($start)) {
   $start .=" 00:00:00";
}
$data = [];
$success =0;
$sql = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat,  order_status.status as status_name,
          cites.name as city_name,
          towns.name as town_name,
            if(to_city = 1,
                 if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                 if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
            )as dev_price,
            new_price -
              (if(to_city = 1,
                  if(client_dev_price.price is null,(".$config['dev_b']." - discount),(client_dev_price.price - discount)),
                  if(client_dev_price.price is null,(".$config['dev_o']." - discount),(client_dev_price.price - discount))
                 )
             ) as client_price
          from orders
          inner join order_status on orders.order_status_id = order_status.id
          inner join cites on orders.to_city = cites.id
          inner join towns on orders.to_town = towns.id
          left JOIN client_dev_price on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where store_id = ?  and storage_id  = 1 and
                               (
                                 ((order_status_id<>6 and order_status_id<>5) and orders.invoice_id = 0) or
                                 ((order_status_id=6 or order_status_id=5) and (orders.invoice_id2=0))
                                )
          ";

    ///-----------------status
    $filter = "";
    $s = "";
    if(count($statues) > 0){
        foreach($statues as $status){
          if($status == 9 || $status == 6 || $status == 5){
            $s .= " or order_status_id=".$status;
          }
        }
    }else{
      $filter .= " and (order_status_id = 6 or order_status_id = 9 or order_status_id = 5)";
    }
     $s = preg_replace('/^ or/', '', $s);
     if($s != ""){
      $filter = " and (".$s." )";
     }
  //---------------------end of status
    function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    if(validateDate($start) && validateDate($end)){
      $filter .= " and orders.date between '".$start."' AND '".$end."'";
     }
$data= getData($con,$sql.$filter,[$id]);
if(count($data)>0){
  $success =1;
}
echo json_encode(array($sql,"success"=>$success,"data"=>$data));
?>