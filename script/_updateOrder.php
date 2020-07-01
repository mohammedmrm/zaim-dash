<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1,2,3,5]);
require_once("dbconnection.php");
require_once("../config.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

$v->addRuleMessage('isPhoneNumber', 'رقم هاتف غير صحيح ');

$v->addRule('isPhoneNumber', function($value, $input, $args) {
  if(preg_match("/^[0-9]{10,15}$/",$value) || empty($value)){
    $x=(bool) 1;
  }
    return $x;
});

$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|\-\d*|\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});

$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function($value, $input, $args) {
    $value  = trim($value);
    $exists = getData($GLOBALS['con'],"SELECT * FROM orders WHERE order_no ='".$value."' and id <> '".$GLOBALS['id']."'");
    return ! (bool) count($exists);
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'تم ادخال بيانات اكثر من الحد المسموح',
    'email'      => 'البريد الالكتروني غيز صحيح',
]);
$error = [];
$success = 0;
$manger = $_SESSION['userid'];

$id = $_REQUEST['e_Orderid'];
$number = $_REQUEST['e_order_no'];
$order_type = 'multi';//$_REQUEST['e_order_type'];
$weight = $_REQUEST['e_weight'];
$qty = $_REQUEST['e_qty'];
$order_price = $_REQUEST['e_price'];
$order_iprice= $_REQUEST['e_iprice'];

$branch = $_REQUEST['e_branch'];
$client = $_REQUEST['e_client'];
$store = $_REQUEST['e_store'];
$client_phone = $_REQUEST['e_client_phone'];

$customer_name = $_REQUEST['e_customer_name'];
$customer_phone = $_REQUEST['e_customer_phone'];
$city_to = $_REQUEST['e_city'];
$town_to = $_REQUEST['e_town'];
$branch_to = $_REQUEST['e_branch_to'];
$order_note= $_REQUEST['e_order_note'];
$date= $_REQUEST['e_date'];
if(!validateDate($date)){
  $date_err = "تاريخ غير صالح";
}else{
  $date_err = "";
}
if(empty($number)){
  $number = "1";
}
$v->validate([
    'manger'        => [$manger,    'required|int'],
    'id'            => [$id,    'required|int'],
    'order_no'      => [$number,    'required|min(1)|max(100)'],
    'weight'        => [$weight,   'int'],
    'qty'           => [$qty,'int'],
    'order_price'   => [$order_price,   "isPrice"],
    'order_iprice'  => [$order_iprice,   "isPrice"],
    'branch_from'   => [$branch,  'int'],
    'client'        => [$client,  'int'],
    'store'         => [$store,  'int'],
    'client_phone'  => [$client_phone,  'isPhoneNumber'],
    'customer_phone'=> [$customer_phone,'required|isPhoneNumber'],
    'city'          => [$city_to,  'int'],
    'town'          => [$town_to,  'int'],
    'branch_to'     => [$branch_to,'int'],
    'order_note'    => [$order_note,'max(250)'],
    'customer_name' => [$customer_name,'max(200)'],
]);


$sql ="select * from orders where id = ?";
$res = setData($con,$sql,[$id]);
if($_SESSION['user_details']['role_id'] == 1 ||
   $_SESSION['user_details']['role_id'] == 5 ||
  ($_SESSION['user_details']['role_id'] == 2 && $res[0]['from_branch'] == $_SESSION['user_details']['branch_id']) ||
   $_SESSION['userid'] == $res[0]['manager_id']){
  $premission = 1;
}else{
 $premission = 0;
}


if($v->passes() && $date_err =="" && $premission) {

  $sql = 'update orders set order_no="'.$number.'"';
  $up = "";
  if(!empty($weight) && $weight > 0){
    $up .= ' , weight='.$weight;
  }
  if(!empty($qty) && $qty > 0){
    $up .= ' , qty='.$qty;
  }
  if(!empty($branch_to)  && $branch_to > 0){
    $up .= ' , to_branch='.$branch_to;
  }
  if(!empty($branch)  && $branch > 0){
    $up .= ' , from_branch='.$branch;
  }
  if(!empty($city_to) && $city_to > 0){
    $up .= ' , to_city='.$city_to;
  }
  if(!empty($town_to) && $town_to > 0){
    $up .= ' , to_town='.$town_to;
  }
  if(!empty($order_price)){
    $up .= ' , price="'.$order_price.'"';
  }
  if(!empty($order_iprice)){
    $up .= ' , new_price="'.$order_iprice.'"';
  }
  if(!empty($store) && $store > 0){
    $up .= ' , store_id="'.$store.'"';
  }
  if(!empty($client) && $client > 0){
    $up .= ' , client_id="'.$client.'"';
  }
  if(!empty($customer_phone)){
    $up .= ' , customer_phone="'.$customer_phone.'"';
  }
  if(!empty($customer_name)){
    $up .= ' , customer_name="'.$customer_name.'"';
  }
  if(!empty($order_note)){
    $up .= ' , note="'.$order_note.'"';
  }
  if(!empty($date)){
    $up .= ' , date="'.$date.'"';
  }
  $where = " where id =".$id."  and invoice_id=0 and driver_invoice_id=0";
  $sql .= $up.$where;
 $result = setData($con,$sql);
if($result > 0){
  $success = 1;
}
}else{
$error = [
           'manger'=> implode($v->errors()->get('manger')),
           'id'=> implode($v->errors()->get('id')),
           'order_no'=>implode($v->errors()->get('order_no')),
           'order_type'=>implode($v->errors()->get('order_type')),
           'weight'=>implode($v->errors()->get('weight')),
           'qty'=>implode($v->errors()->get('qty')),
           'order_price'=>implode($v->errors()->get('order_price')),
           'order_iprice'=>implode($v->errors()->get('order_iprice')),
           'branch_from'=>implode($v->errors()->get('branch_from')),
           'store'=>implode($v->errors()->get('store')),
           'client'=>implode($v->errors()->get('client')),
           'client_phone'=>implode($v->errors()->get('client_phone')),
           'customer_name'=>implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'branch_to'=>implode($v->errors()->get('branch_to')),
           'order_note'=>implode($v->errors()->get('order_note')),
           'date'=>$date_err,
           'premission'=>$premission
           ];
}
echo json_encode([$sql,'success'=>$success, 'error'=>$error,$_POST]);
?>