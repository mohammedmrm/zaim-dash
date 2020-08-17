<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);
require("_access.php");
access([1,2,5]);
$storage = $_REQUEST['storage'];
$id = $_REQUEST['id'];
$start = $_REQUEST['start'];
$end = $_REQUEST['end'];
if(empty($end)) {
   $end = date('Y-m-d', strtotime(' + 1 day'));
}else{
   $end = date('Y-m-d', strtotime($end.' + 1 day'));
}

require("dbconnection.php");
try{
  $query = "select storage_invoice.*,date_format(storage_invoice.date,'%Y-%m-%d') as in_date,storage.name as storage_name
           from storage_invoice
           left join storage on storage.id = storage_invoice.storage_id
           ";

    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    if(validateDate($start) && validateDate($end)){
      $filter = "where storage_invoice.date between '".$start."' AND '".$end."'";
    }


    if($storage >= 1){
       $filter .= " and storage_invoice.storage_id =".$storage;
    }
    if($id >= 1){
       $filter .= " and storage_invoice.id =".$id;
    }
    $query .=  $filter;
    $query .=  " order by storage_invoice.date DESC limit 100";
    $data = getData($con,$query);
    $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
print_r(json_encode(array($query,"success"=>$success,"data"=>$data)));
?>