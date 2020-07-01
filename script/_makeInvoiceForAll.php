<?php
//-- create invoce fo recived orders only
ini_set('max_execution_time', 60000);
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require("_access.php");
access([1,2]);
require_once("dbconnection.php");

$style='
<style>
 td,th{
    padding:3px;
    text-align:center;
  }
  .re {
    background-color: #FFA07A;
  }
  .ch {
    background-color: #FFFACD;
  }
  .repated {
    background-color:#E0FFFF;
  }
  .head-tr {
   background-color: #33CC00;
   color:#111;
  }
  .price_bg {
    background-color: #9966FF;
  }
  </style>
';
require("../config.php");

$status = 4;
$store = $_REQUEST['store'];
$dev_price_b = $_REQUEST['dev_price_b'];
$dev_price_o = $_REQUEST['dev_price_o'];
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);
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

try{
if($store >= 1 && $dev_price_b > 999 && $dev_price_o > 999){
    $sql= "select * from stores where id= ?";
    $client =getData($con,$sql,[$store]);
    if(count($client) > 0){
    $sql= "delete from client_dev_price where client_id= ?";
    $delete_dev_price = setData($con,$sql,[$client[0]['client_id']]);
    $sql = "select * from cites";
    $cities = getData($con,$sql);
            foreach($cities as $city){
                 $sql = "insert into client_dev_price (price,city_id,client_id) value(?,?,?)";
                 if($city['id'] == 1){
                  $update_price = setData($con,$sql,[$dev_price_b,$city['id'],$client[0]['client_id']]);
                 }else{
                  $update_price = setData($con,$sql,[$dev_price_o,$city['id'],$client[0]['client_id']]);
                 }
            }
   }

}
}catch(PDOException $ex) {

}
$total = [];

try{
  $count = "select count(*) as count,
               SUM(IF (to_city = 1,1,0)) as  b_orders,
               SUM(IF (to_city > 1,1,0)) as  o_orders
            from orders ";
  $query = "select orders.*, date_format(orders.date,'%Y-%m-%d') as dat,
            clients.name as client_name,clients.phone as client_phone,
            cites.name as city,towns.name as town,branches.name as branch_name,
            stores.name as store_name
            from orders
            left join clients on clients.id = orders.client_id
            left join cites on  cites.id = orders.to_city
            left join stores on  stores.id = orders.store_id
            left join towns on  towns.id = orders.to_town
            left join branches on  branches.id = orders.to_branch
            ";
  $where = "where orders.confirm=1  and invoice_id = 0 and ";
  $filter = "";

  ///-----------------status
  $filter .= " and (order_status_id =4 or order_status_id = 6 or order_status_id = 5)";

  //---------------------end of status
  if($store >= 1){
    $filter .= " and store_id=".$store;
  }
  if(validateDate($start) && validateDate($end)){
    $filter .= " and orders.date between '".$start."' AND '".$end."'";
  }
  if($filter != ""){
     $filter = preg_replace('/^ and/', '', $filter);
     $filter = $where." ".$filter;
     $count .= " ".$filter;
     $query .= " ".$filter." order by orders.order_no,to_city";
  }else{
    $query .=" order by orders.date";
  }

  $count1 = getData($con,$count);
  $orders = $count1[0]['count'];
  $total['b_orders'] = $count1[0]['b_orders'];
  $total['o_orders'] = $count1[0]['o_orders'];
  $data = getData($con,$query);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
// set default header data
$status_name = "مستلمة";


if($orders > 0){
    try{
        $i = 0;
        $content = "";
        $success = 0;
        $pdf_name = date('Y-m-d')."_".uniqid().".pdf";
        $sql = "insert into invoice (path,store_id,orders_status) values(?,?,?)";
        $res = setData($con,$sql,[$pdf_name,$store,$status]);
    if($res > 0){
      $success = 1;
      $sql = "select * from invoice where path=? and store_id =? order by date DESC limit 1";
      $res = getdata($con,$sql,[$pdf_name,$store]);
      $invoice = $res[0]['id'];

        foreach($data as $k=>$v){
          $total['income'] += $data[$i]['new_price'];
                $sql = "select * from client_dev_price where client_id=? and city_id=?";
                $dev_price  = getData($con,$sql,[$v['client_id'],$v['to_city']]);
                if(count($dev_price) > 0){
                  $dev_p = $dev_price[0]['price'];
                }else{
                  if($v['to_city'] == 1){
                   $dev_p = $config['dev_b'];
                  }else{
                   $dev_p = $config['dev_o'];
                  }
                }
                if($v['to_city'] == 1 && $dev_price_b > 999){
                 $dev_p = $dev_price_b;
                }
                if($v['to_city'] != 1 && $dev_price_o > 999){
                 $dev_p = $dev_price_o;
                }
                $data[$i]['dev_price'] = $dev_p;
                if($data[$i]['order_status_id'] == 9){
                  $data[$i]['dev_price'] = 0;
                  $dev_p = 0;
                  $data[$i]['dicount']=0;
                }
                $data[$i]['client_price'] = ($data[$i]['new_price'] -  $dev_p) + $data[$i]['discount'];
                $note =  $data[$i]['note'];
                $bg = "";
                if($data[$i]['order_status_id'] == 6){
                 $bg = "re";
                 $note = "راجع جزئي";
                }
               if($data[$i]['order_status_id'] == 5){
                 $bg = "ch";
                 $note = "استبدال";
               }
               if($data[$i]['repated'] > 1){
                 $bg = "repated";
               }
               $price_bg ="";
               if($data[$i]['new_price'] !== $data[$i]['price']){
                 $price_bg = "price_bg";
               }
                $sql = "update orders set invoice_id =? where id=?";
                $res = setData($con,$sql,[$invoice,$v['id']]);

        $hcontent .=
         '<tr class="'.$bg.'">
           <td width="60"  align="center">'.($i+1).'</td>
           <td width="100" align="center">'.$data[$i]['dat'].'</td>
           <td width="80"  align="center">'.$data[$i]['order_no'].'</td>
           <td width="120" align="center">'.phone_number_format($data[$i]['customer_phone']).'</td>
           <td width="160" align="center" >'.$data[$i]['city'].' - '.$data[$i]['town'].' - '.$data[$i]['address'].'</td>
           <td width="80" align="center">'.number_format($data[$i]['price']).'</td>
           <td width="80" class="'.$price_bg.'" align="center">'.number_format($data[$i]['new_price']).'</td>
           <td width="80" align="center">'.number_format($data[$i]['dev_price']).'</td>
           <td align="center">'.number_format($data[$i]['client_price']).'</td>
           <td align="center">'.$note.'</td>
         </tr>';
          $total['discount'] += $data[$i]['discount'];
          $total['dev_price'] += $data[$i]['dev_price'];
          $total['client_price'] += $data[$i]['client_price'];

           $i++;
       }
       $total['invoice'] = $invoice;
       $total['status'] = $status_name;
       $total['date'] = $res[0]['date'];
    }



          $total['orders'] = $orders;
          if($store >=1){
           $total['client'] = $data[0]['client_name'];
           $total['store'] = $data[0]['store_name'];
          }else{
           $total['client'] = '/';
           $total['store'] = '/';
          }

    } catch(PDOException $ex) {
       $data=["error"=>$ex];
       $success="0";
    }

require_once("../tcpdf/tcpdf.php");
class MYPDF extends TCPDF {
    public function Header() {
        // Set font
        $t = $GLOBALS['total'];
        $this->SetFont('aealarabiya', 'B', 12);
        // Title
        $this->writeHTML('

         <table>
         <tr>
          <td rowspan="4"><img src="../img/logos/logo.png" height="90px"/></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
         </tr>
         <tr>
          <td width="350px">اسم العميل او الصفحه : ('.$t['client'].')'.$t['store'].'</td>
          <td width="300px" style="color:#FF0000;text-align:center;display:block;">كشف حساب العميل</td>
          <td >التاريخ:'.date('Y-m-d').'</td>
         </tr>
         <tr>
          <td width="350px">الصافي للعميل:'.number_format($t['client_price']).'</td>
          <td width="300px" style="text-align:center;display:block;">'.
                'عدد الطلبيات  الكلي: '.$t['orders'].'<br />'.
                'عدد طلبيات بغداد : '.$t['b_orders'].'<br />'.
                'عدد طلبيات المحافظات : '.$t['o_orders'].'<br />'.
          '</td>
          <td >رقم الكشف:'.$t['invoice'].'</td>
         </tr>
        </table>
        ');
    }
}
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('07822816693');
$pdf->SetTitle('تقرير الطلبيات');
$pdf->SetSubject($start."-".$end);
// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'ar';
$lg['w_page'] = 'page';

// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
// set font
$pdf->SetFont('aealarabiya', '', 12);


//$pdf->SetHeaderData("../../../".$config['Company_logo'],30, ' اسم الصفحه او البيح: '.$total['store']."               "." الفترة الزمنية: ".date("Y-m-d",strtotime($start))." || ".date("Y-m-d",strtotime($end))," حالة الطلبات : ".$status_name."\n"."السعر الصافي للعميل: ".number_format($total['client_price'])."                "."\n"."عدد الطلبيات: ".$total['orders']." ");

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', '', 12));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 32, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------


// add a page
$pdf->AddPage('L', 'A4');

// Persian and English content

$htmlpersian = '		<table border="1" class="table" cellpadding="5">
			       <thead>
	  						<tr  class="head-tr">
                                        <th width="60">#</th>
                                        <th width="100">تاريخ الادخال</th>
										<th width="80">رقم الوصل</th>
										<th width="120">هاتف المستلم</th>
										<th width="160">عنوان المستلم</th>
                                        <th width="80">مبلغ الوصل</th>
										<th width="80">المبلغ المستلم</th>
										<th width="80">مبلغ التوصيل</th>
										<th> المبلغ الصافي للعميل </th>
										<th>الملاحظات</th>
							</tr>
      	            </thead>
                            <tbody id="ordersTable">'
                            .$hcontent.
                            '</tbody>
		</table>
        ';
$pdf->WriteHTML($style.$htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);
// print newline
$pdf->Ln();
//Close and output PDF document
ob_end_clean();
//print_r($hcontent);

$pdf->Output(dirname(__FILE__).'/../invoice/'.$pdf_name, 'F');
}else{
  $success = 2;
}
echo json_encode([$cities,$update_price,'num'=>$count,'success'=>$success,'invoice'=>$pdf_name]);
?>