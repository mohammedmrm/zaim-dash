<?php
ini_set('max_execution_time', 20000);
ob_start();
session_start();
error_reporting(0);
require("_access.php");
access([1,2,3,5]);
require_once("dbconnection.php");


require("../config.php");

$branch = $_REQUEST['branch'];
$to_branch = $_REQUEST['to_branch'];
$city = $_REQUEST['city'];
$town = $_REQUEST['town'];
$customer = $_REQUEST['customer'];
$order = $_REQUEST['order_no'];
$client= $_REQUEST['client'];
$store= $_REQUEST['store'];
$storageStatus = $_REQUEST['storageStatus'];
$callcenter = $_REQUEST['callcenter'];
$storage = $_REQUEST['storage'];
$driver = $_REQUEST['driver'];
$invoice= $_REQUEST['invoice'];
$status = $_REQUEST['orderStatus'];
$repated = $_REQUEST['repated'];
$confirm = $_REQUEST['confirm'];
$start = trim($_REQUEST['start']);
$end = trim($_REQUEST['end']);

$reportType = $_REQUEST['reportType'];
if($reportType != 1 && $reportType !=2 && $reportType!=3 ){
   $reportType = 1;
}
$pageDir = $_REQUEST['pageDir'];
if($pageDir != 'L' && $pageDir !='P' ){
   $pageDir = 'L';
}
$space = $_REQUEST['space'];
if($space < 0 || $space > 30 || empty($space)){
   $space = 10;
}
$fontSize = $_REQUEST['fontSize'];
if($fontSize < 5 || $fontSize > 100 || empty($fontSize)){
   $fontSize = 12;
}
if($reportType == 2){
  $style='
  <style>
    td,th{
      text-align:center;
      vertical-align: middle;
      white-space: nowrap;
    }
    .head-tr {
     background-color: #FFCCFF;
     color:#111;
    }
  .unc{
    background-color: #FFCC33;
  }
  </style>';
}else if($reportType == 3){
  $style='
  <style>
    td,th{
      text-align:center;
      vertical-align: middle;
      white-space: nowrap;
    }
    .head-tr {
     background-color: #FFFFCC;
     color:#111;
    }
  .unc{
    background-color: #FFCC33;
  }
  </style>';
}else{
  $style='
  <style>
    td,th{
      text-align:center;
      vertical-align: middle;
      white-space: nowrap;
    }
    .head-tr {
     background-color: #ddd;
     color:#111;
    }
    .unc{
      background-color: #FFCC33;
    }
  </style>';
}
$total = [];
$money_status = trim($_REQUEST['money_status']);
if(!empty($end)) {
   $end .=" 23:59:59";
}else{
   $end =date('Y-m-d', strtotime(' + 1 day'));
   $end .=" 23:59:59";
}
if(!empty($start)) {
   $start .=" 00:00:00";
}

try{
  $count = "select count(*) as count,
               SUM(IF (to_city = 1,1,0)) as  b_orders,
               SUM(IF (to_city > 1,1,0)) as  o_orders
            from orders
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
           ";
  $query = "select orders.*,date_format(orders.date,'%Y-%m-%d') as dat, order_status.status as status_name,
            clients.name as client_name,clients.phone as client_phone,stores.name as store_name,
            cites.name as city,towns.name as town,to_branch.name as to_branch_name, branches.name as branch_name,staff.name as driver_name
            from orders left join
            clients on clients.id = orders.client_id
            left join cites on  cites.id = orders.to_city
            left join towns on  towns.id = orders.to_town
            left join stores on  stores.id = orders.store_id
            left join order_status on  orders.order_status_id = order_status.id
            left join branches on  branches.id = orders.from_branch
            left join branches as to_branch on  to_branch.id = orders.to_branch
            left join staff on  staff.id = orders.driver_id
            left join (
             select order_no,count(*) as rep from orders
              GROUP BY order_no
              HAVING COUNT(orders.id) > 1
            ) b on b.order_no = orders.order_no
            ";
    if($_SESSION['role'] == 1 || $_SESSION['role'] == 5 || $_SESSION['role'] == 9){
       $where = "where";
    }else{
       $where = "where (from_branch = '".$_SESSION['user_details']['branch_id']."' or to_branch = '".$_SESSION['user_details']['branch_id']."') and ";
    }
   if($confirm == 1 || $confirm == 4){
    $filter .= " and orders.confirm ='".$confirm."'";
   }else{
    $filter .= " and (orders.confirm =1 or orders.confirm =4)";
   }
  if($branch >= 1){
   $filter .= " and from_branch =".$branch;
  }
  if($to_branch >= 1){
   $filter .= " and to_branch =".$to_branch;
  }
  if($driver >= 1){
   $filter .= " and driver_id =".$driver;
  }

  if($repated == 1){
   $filter .= " and b.rep >= 2";
   $sort = " order by orders.order_no,orders.date ";
  }else if($repated == 2){
   $filter .= " and b.rep == null";
   $sort = " order by orders.order_no,orders.date ";
  }

  if($invoice == 1){
    $filter .= " and (orders.invoice_id ='' or orders.invoice_id =0)";
  }else if($invoice == 2){
    $filter .= " and (orders.invoice_id !='' and orders.invoice_id != 0)";
  }
  if($city >= 1){
    $filter .= " and to_city=".$city;
  }
  if($town >= 1){
    $filter .= " and to_town=".$town;
  }
  if(($money_status == 1 || $money_status == 0) && $money_status !=""){
    $filter .= " and money_status='".$money_status."'";
  }
  if($client >= 1){
    $filter .= " and client_id=".$client;
  }
  if($store>= 1){
    $filter .= " and store_id=".$store;
  }
  if($storageStatus == 1){
   $filter .= " and orders.invoice_id = 0";
  }else if($storageStatus == 2){
   $filter .= " and orders.invoice_id <> 0 and invoice.invoice_status = 0";
  }else if($storageStatus == 3){
   $filter .= " and orders.invoice_id <> 0 and invoice.invoice_status = 1";
  }

  if($callcenter == 1){
   $filter .= " and orders.callcenter_id <> 0";
  }else if($callcenter == 2){
    $filter .= " and orders.callcenter_id = 0";
  }


  if($storage > 0){
   $filter .= " and orders.storage_id =".$storage;
  }
  
  if(!empty($customer)){
    $filter .= " and (customer_name like '%".$customer."%' or
                      customer_phone like '%".$customer."%')";
  }
  if(!empty($order)){
    $filter .= " and orders.order_no = '".$order."'";
  }

  ///-----------------status
  $s = "";
  if(count($status) > 0){
    foreach($status as $stat){
      if($stat > 0){
        $s .= " or order_status_id=".$stat;
      }
    }
  }
  $s = preg_replace('/^ or/', '', $s);
   if($s != ""){
    $s = " and (".$s." )";
    $filter .= $s;
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
  if($filter != ""){
    $filter = preg_replace('/^ and/', '', $filter);
    $filter = $where." ".$filter;
    $count .= " ".$filter;
    $query .= " ".$filter." order by to_city,to_town,orders.id";
  }else{
    $query .=" order by to_city,to_town,orders.id";
  }
  $count = getData($con,$count);
  $orders = $count[0]['count'];
  $total['b_orders'] = $count[0]['b_orders'];
  $total['o_orders'] = $count[0]['o_orders'];
  $data = getData($con,$query);
  $success="1";

} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}

try{
  $i = 0;
  $content = "";
  if($reportType ==  2){
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
            $data[$i]['dev_price'] = $dev_p;
            $data[$i]['client_price'] = ($data[$i]['new_price'] -  $dev_p) + $data[$i]['discount'];
            $bg = "";
            if($data[$i]['confirm'] > 1){
                 $bg = "unc";
            }
    $hcontent .=
     '<tr class="'.$bg.'">
       <td align="center" width="'.(48+$fontSize).'">'.($i+1).'</td>
       <td align="center">'.$data[$i]['order_no'].'</td>
       <td align="center">'.$data[$i]['dat'].'</td>
       <td align="center">'.$data[$i]['store_name'].'</td>
       <td align="center" style="white-space: nowrap;">'.phone_number_format($data[$i]['customer_phone']).'</td>
       <td align="center">'.$data[$i]['city'].'-'.$data[$i]['town'].' - '.$data[$i]['address'].'</td>
       <td align="center" style="white-space: nowrap;">'.number_format($data[$i]['price']).'</td>
       <td align="center">'.$data[$i]['note'].'</td>
     </tr>';

      $total['discount'] += $data[$i]['discount'];
      $total['dev_price'] += $data[$i]['dev_price'];
      $total['client_price'] += $data[$i]['client_price'];
      $i++;
    }
      $total['orders'] = $orders;
      if($to_branch >=1){
       $total['to'] ='المحافظه : '.  $data[0]['city'];
      }else{
       $total['to'] = 'المحافظه : '. 'لم يتم تحديد محافظه';
      }
  }else if($reportType == 3){
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
            $data[$i]['dev_price'] = $dev_p;
            $data[$i]['client_price'] = ($data[$i]['new_price'] -  $dev_p) + $data[$i]['discount'];
            $bg = "";
            if($data[$i]['confirm'] > 1){
                 $bg = "unc";
            }
    $hcontent .=
     '<tr class="'.$bg.'">
       <td align="center" width="'.(48+$fontSize).'">'.($i+1).'</td>
       <td align="center">'.$data[$i]['order_no'].'</td>
       <td align="center">'.$data[$i]['dat'].'</td>
       <td align="center">'.$data[$i]['store_name'].'</td>
       <td align="center">'.phone_number_format($data[$i]['customer_phone']).'</td>
       <td align="center">'.$data[$i]['city'].' - '.$data[$i]['town'].' - '.$data[$i]['address'].'</td>
       <td align="center">'.number_format($data[$i]['price']).'</td>
       <td align="center">'.$data[$i]['status_name'].'</td>
       <td align="center">'.$data[$i]['note'].'</td>
     </tr>';

      $total['discount'] += $data[$i]['discount'];
      $total['dev_price'] += $data[$i]['dev_price'];
      $total['client_price'] += $data[$i]['client_price'];
      $i++;
    }
      $total['orders'] = $orders;
      if($city >=1){
       $total['to'] ='الفرع: '.  $data[0]['to_branch_name'];
      }else{
       $total['to'] = 'الفرع: '. 'لم يتم تحديد فرع';
      }
  }else{
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
            $data[$i]['dev_price'] = $dev_p;
            $data[$i]['client_price'] = ($data[$i]['new_price'] -  $dev_p) + $data[$i]['discount'];
            $bg = "";
            if($data[$i]['confirm'] > 1){
                $bg = "unc";
            }
    $hcontent .=
     '<tr class="'.$bg.'">
       <td width="60"  align="center">'.($i+1).'</td>
       <td align="center">'.$data[$i]['order_no'].'</td>
       <td width="110" align="center">'.$data[$i]['dat'].'</td>
       <td align="center" width="110">'.$data[$i]['store_name'].'</td>

       <td width="130" align="center">'.phone_number_format($data[$i]['customer_phone']).'</td>
       <td align="center">'.$data[$i]['city'].' - '.$data[$i]['town'].' - '.$data[$i]['address'].'</td>
       <td width="80" align="center">'.number_format($data[$i]['price']).'</td>
       <td width="130" align="center">'.$data[$i]['note'].'</td>
     </tr>';
      //<td align="center" width="130">'.phone_number_format($data[$i]['client_phone']).'</td>
      $total['discount'] += $data[$i]['discount'];
      $total['dev_price'] += $data[$i]['dev_price'];
      $total['client_price'] += $data[$i]['client_price'];
      $i++;
    }
      $total['orders'] = $orders;
      if($driver >=1){
       $total['to'] ='المندوب : '.  $data[0]['driver_name'];
      }else{
       $total['to'] = 'المندوب : '. 'لم يتم تحديد مندوب';
      }
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
        $reportType = $GLOBALS['reportType'];
        $this->SetFont('aealarabiya', 'B', 12);
        // Title
        if($reportType ==  2){
            $header=
            '
             <table >
             <tr>
              <td width="180" rowspan="2">
                <span align="center" style="color:#DC143C;">التسليمات المطلوبه</span><br />
                <img src="../img/logos/logo.png" height="80px"/>
              </td>
              <td ></td>
              <td ></td>
             </tr>
             <tr>
              <td style="text-align:right;" width="200">'.$t['to'].'</td>
              <td  width="180">'.
                'عدد الطلبيات  الكلي: '.$t['orders'].'<br />'.
                'عدد طلبيات بغداد : '.$t['b_orders'].'<br />'.
                'عدد طلبيات المحافظات : '.$t['o_orders'].'<br />'.
              '</td>
              <td  width="150">التاريخ:'.date('Y-m-d').'</td>
             </tr>
            </table>
            ';

        }else if($reportType ==  3){
            $header=
            '
             <table >
             <tr>
              <td width="180" rowspan="2">
                <span align="center" style="color:#DC143C;">التسليمات المطلوبه</span><br />
                <img src="../img/logos/logo.png" height="80px"/>
              </td>
              <td ></td>
              <td ></td>
             </tr>
             <tr>
              <td style="text-align:right;" width="200">'.$t['to'].'</td>
              <td  width="180">'.
                'عدد الطلبيات  الكلي: '.$t['orders'].'<br />'.
                'عدد طلبيات بغداد : '.$t['b_orders'].'<br />'.
                'عدد طلبيات المحافظات : '.$t['o_orders'].'<br />'.
              '</td>
              <td  width="150">التاريخ:'.date('Y-m-d').'</td>
             </tr>
            </table>
            ';
        }else{
            $header=
            '
             <table >
             <tr>
              <td width="180" rowspan="2">
                <span align="center" style="color:#DC143C;">التسليمات المطلوبه</span><br />
                <img src="../img/logos/logo.png" height="80px"/>
              </td>
              <td ></td>
              <td ></td>
             </tr>
             <tr>
              <td style="text-align:right;" width="180">'.$t['to'].'</td>
              <td  width="150">'.
                'عدد الطلبيات  الكلي: '.$t['orders'].'<br />'.
              '</td>
              <td  width="150">التاريخ:'.date('Y-m-d').'</td>
              <td  width="180">
                <span style="display:inline-block;width:80px;">الواصل :     &nbsp;&nbsp;&nbsp;</span><span style="color:#A9A9A9">........................</span><br />
                <span style="display:inline-block;width:80px;">الراجع :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style="color:#A9A9A9">........................</span><br />
                <span style="display:inline-block;width:80px;">المؤجل : &nbsp;&nbsp;&nbsp;</span><span style="color:#A9A9A9">........................</span>
              </td>
             </tr>
            </table>
            ';
        }
        $this->writeHTML($header);
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
$pdf->SetFont('aealarabiya', '', $fontSize);

// set default header data
//$pdf->SetHeaderData("../../../".$config['Company_logo'],35, "التقرير الشامل", "اسم");
// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', '', 12));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));


// set margins
$pdf->SetMargins(2, 30,10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// ---------------------------------------------------------


// add a page
$pdf->AddPage($pageDir, 'A4');

// Persian and English content
if($reportType ==  2){
$htmlpersian = '<table border="1" class="table" cellpadding="'.$space.'">
			       <thead>
	  						<tr  class="head-tr">
                                        <th width="'.(48+$fontSize).'">#</th>
                                        <th>رقم الوصل</th>
										<th style="white-space: nowrap;">تاريخ الادخال</th>
										<th >اسم البيح</th>

										<th style="white-space: nowrap;">هاتف   المستلم</th>
										<th>عنوان المستلم</th>
                                        <th >مبلغ الوصل</th>
										<th >حالة الطلب</th>
						   </tr>
      	            </thead>
                    <tbody id="ordersTable">'
                            .$hcontent.
                    '</tbody>
             </table>';
}else if($reportType ==  3){
$htmlpersian = '<table border="1" class="table" cellpadding="'.$space.'">
			       <thead>
	  						<tr  class="head-tr">
                                        <th width="'.(48+$fontSize).'" >#</th>
                                        <th>رقم الوصل</th>
										<th >تاريخ الادخال</th>
										<th >اسم البيح</th>
										<th >هاتف   المستلم</th>
										<th>عنوان المستلم</th>
                                        <th >مبلغ الوصل</th>
										<th >حالة الطلب</th>
										<th >ملاحظة</th>
						   </tr>
      	            </thead>
                    <tbody id="ordersTable">'
                            .$hcontent.
                    '</tbody>
             </table>';
}else{
$htmlpersian = '<table border="1" class="table" cellpadding="'.$space.'">
			       <thead>
	  						<tr  class="head-tr">
                                        <th width="60">#</th>
                                        <th>رقم الوصل</th>
										<th width="110">تاريخ الادخال</th>
										<th width="110">اسم البيح</th>
                                        <th width="130">هاتف   المستلم</th>
										<th>عنوان المستلم</th>
                                        <th width="80">مبلغ الوصل</th>
										<th width="130">ملاحظه</th>
						   </tr>
      	            </thead>
                    <tbody id="ordersTable">'
                            .$hcontent.
                    '</tbody>
             </table>';
             //<th width="130">هاتف العميل</th>
										
}
$pdf->WriteHTML($style.$htmlpersian, true, false, true, false, 'J');

// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);
// print newline
$pdf->Ln();  
//Close and output PDF document
ob_end_clean();

$pdf->Output('order'.date('Y-m-d h:i:s').'.pdf', 'I');
?>