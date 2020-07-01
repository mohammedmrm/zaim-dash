<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require_once("_access.php");
access([1,2,5]);
require_once("dbconnection.php");
require_once("../config.php");
$id = $_REQUEST['store'];
$data = [];
$success =0;
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
$filter = "";
if(!empty($end)) {
   $end .=" 23:59:59";
}else{
  $end =date('Y-m-d H:i:s');
}
if(!empty($start)) {
   $start .=" 00:00:00";
}
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
if(validateDate($start) && validateDate($end)){
  $filter .= " and orders.date between '".$start."' AND '".$end."'";
}
$query = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat,  order_status.status as status_name,
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
          left join order_status on orders.order_status_id = order_status.id
          left join cites on orders.to_city = cites.id
          left join towns on orders.to_town = towns.id
          left JOIN client_dev_price on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where store_id = ?  and orders.confirm=1
                     and invoice_id = 0 and (order_status_id =4 or order_status_id = 6 or order_status_id = 5)
          ";
      if($filter != ""){
        $query .= $filter;
      }
      $query .= " order by order_no";
  $res3= getData($con,$query,[$id]);
  $data[] = $res3;
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
          count(order_no) as orders
          from orders
          left JOIN client_dev_price on client_dev_price.client_id = orders.client_id AND client_dev_price.city_id = orders.to_city
          where store_id = ? and orders.confirm=1 and (
                 (invoice_id = 0) or
                 ((order_status_id=6 or order_status_id=5) and (orders.invoice_id2=0))
                ) and (order_status_id =4 or order_status_id = 6 or order_status_id = 5)
          ";
          if($filter != ""){
            $sql .= $filter;
          }
          if(count($data) > 0){
            $success = 1;
          }
          $res4= getData($con,$sql,[$id]);
          $res4= $res4[0];
echo json_encode(array($query,"success"=>$success,"data"=>$data,'pay'=>$res4));
?>