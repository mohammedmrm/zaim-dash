<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_apiAccess.php");
access([1,2,3,5,6]);
require_once("../script/dbconnection.php");
require_once("../config.php");
use Violin\Violin;
require_once('../validator/autoload.php');
$error = [];
$store = $_REQUEST['store'];
$v = new Violin;
$v->addRuleMessage('isPhoneNumber', 'رقم هاتف غير صحيح ');
$v->addRule('isPhoneNumber', function($value, $input, $args) {
  if(preg_match("/^[0-9]{10,15}$/",$value) || empty($value)){
    $x=(bool) 1;
  }
    return $x;
});

$v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

$v->addRule('isPrice', function($value, $input, $args) {
  if(preg_match("/^(0|\d*)(\.\d{2})?$/",$value)){
    $x=(bool) 1;
  }
  return   $x;
});

$v->addRuleMessage('unique', 'رقم الوصل مكرر');

$v->addRule('unique', function($value, $input, $args) {
    $value  = trim($value);
    if($args['0'] == 1){
        $exists = getData($GLOBALS['con'],"SELECT * FROM orders WHERE order_no='".$value."' and orders.confirm <> 99");
      return ! (bool) count($exists);
    }else{
      return (bool) 1;
    }
});
$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'    => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'تم ادخال بيانات اكثر من الحد المسموح',
    'email'    => 'البريد الالكتروني غيز صحيح',
]);

$order_price = str_replace('.','',$order_price);

$Orders = $_REQUEST['orders'];

if(empty($number)){
  $number = "1";
}
$confirm = 5;
$no = 0;
foreach($Orders as $k=>$val){
  if($by == 'store'){
      $v->validate([
          'order_no'      => [$val['order_no'], 'required|int|min(1)|max(100)'],
          'order_type'    => [$val['cat_name'], 'required|min(3)|max(10)'],
          'weight'        => [$val['weight'],   'int'],
          'qty'           => [$val['items'],'int'],
          'order_price'   => [$val['price'],"isPrice"],
          'store'         => [$store,'required|int'],
          'customer_name' => [$val['customer_name'],  'max(200)'],
          'customer_phone'=> [$val['customer_phone'],  'required|isPhoneNumber'],
          'city'          => [$val['city_id'],'required|int'],
          'town'          => [$val['town_id'],'required|int'],
          'order_note'    => [$val['note'],   'max(250)'],
          'order_address' => [$val['address'],'max(250)'],
      ]);

      }
      if(!$v->passes()) {
        break;
      }
}

if($v->passes()) {
   foreach($Orders as $k=>$val){
            $no=$_REQUEST['num'][$k];
            if($money[$k] == 1){
              $val['price'] = '-'.$val['note'];
              $val['note'] = $val['note']. " (تسليم مبلغ)";
            }
            $sql = "select * from driver_towns where town_id = ?";
            $getdriver = getData($con,$sql,[$val['town_id']]);
            if(count($getdriver) > 0){
            $driver = $getdriver[0]['driver_id'];
            }else{
             $driver = 0;
            }
            $sql = "select * from stores inner join clients on clients.id = stores.client_id where stores.id = ?";
            $getbranch = getData($con,$sql,[$store]);
            if(count($getbranch) > 0){
              $mainbranch = $getbranch[0]['branch_id'];
              $client = $getbranch[0]['client_id'];
            }else{
              $mainbranch = 1;
              $client = $getbranch[0]['client_id'];
            }
            //-- get possible to_branch  of the order
            $sql = "select * from branch_towns where town_id = ?";
            $getbranch = getData($con,$sql,[$val['town_id']]);
            if(count($getbranch) > 0){
             $to_branch = $getbranch[0]['branch_id'];
            }else{
                $sql = "select * from branch_cities where city_id = ?";
                $getbranch = getData($con,$sql,[$val['city_id']]);
                if(count($getbranch) > 0){
                 $to_branch = $getbranch[0]['branch_id'];
                }else{
                 $to_branch = 1;
                }
            }
            $with_dev = 1;
            $dev_price = 0;
            if(empty($order_address[$k])){
              $order_address[$k] = "";
            }
            $new_price = $val['price'];
            $sql = 'insert into orders (driver_id,order_no,order_type,weight,qty,
                                    price,dev_price,from_branch,
                                    client_id,store_id,customer_name,
                                    customer_phone,to_city,to_town,to_branch,with_dev,note,new_price,address,company_id,confirm)
                                    VALUES
                                    (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
           $result = setDataWithLastID($con,$sql,
                         [$driver,$val['order_no'],$val['order_type'],$val['weight'],$val['items'],
                          $val['price'],$dev_price,$mainbranch,
                          $client,$store,$val['customer_name'],
                          $val['customer_phone'],$val['city_id'],$val['town_id'],$to_branch,$with_dev,$val['note'],$new_price,$val['addess'],$company,$confirm]);
           if($result > 1){
             $data[] = ['barcode'=>$result,'id'=>$val['id'],'order_no'=>$val['order_no']];
             $success = 1;
           }
      //--- END-- this for add order tracking record
   }
}else{
$error = [
           'no'=>$no,
           'order_no'=>implode($v->errors()->get('order_no')),
           'order_type'=>implode($v->errors()->get('order_type')),
           'weight'=>implode($v->errors()->get('weight')),
           'qty'=>implode($v->errors()->get('qty')),
           'order_price'=>implode($v->errors()->get('order_price')),
           'store'=>implode($v->errors()->get('store')),
           'customer_name'=>implode($v->errors()->get('customer_name')),
           'customer_phone'=>implode($v->errors()->get('customer_phone')),
           'city'=>implode($v->errors()->get('city')),
           'town'=>implode($v->errors()->get('town')),
           'order_note'=>implode($v->errors()->get('order_note')),
           'order_address'=>implode($v->errors()->get('order_address'))
           ];
}
echo json_encode(['success'=>$success,'error'=>$error,'data'=>$data]);
?>