<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,3,5]);
}
?>
<style>
fieldset {
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px !important;
		width:100%;
}
legend
{
	font-size:14px;
	font-weight:bold;
	margin-bottom: 0px;
	width: 55%;
	border: 1px solid #ddd;
	border-radius: 4px;
	padding: 5px 5px 5px 10px;
	background-color: #ffffff;
}
</style>

<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">

    </div>
</div>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h1 class="text-danger kt-portlet__head-title">
			  <b>الادخال والاخراج المخزني</b>
			</h1>
		</div>
	</div>

	<div class="kt-portlet__body">
		<!--begin: Datatable -->
        <form id="ordertabledata" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>فلتر</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الفرع:</label>
            	<select onchange="getclient();getAllDrivers($('#driver'),$(this).val())" class="form-control selectpicker" id="branch" name="branch" data-live-search="true" data-col-index="6">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الفرع المرسل له:</label>
            	<select id="to_branch" name="to_branch" onchange="getclient()" class="form-control selectpicker" data-live-search="true" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
           <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>العميل:</label>
            	<select onchange="getorders();getStores($('#store'),$(this).val());" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="client" name="client" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الصفحة (البيج):</label>
            	<select onchange="getorders()" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input onchange="getorders()" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input onchange="getorders()" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
          </div>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>رقم الوصل:</label>
            	<input id="order_no" name="order_no" onkeyup="getorders()" type="text" class="form-control kt-input" placeholder="" data-col-index="0">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الحالة:</label>
            	<select onchange="getorders()" title="اختر الحالة" class="form-control selectpicker" id="orderStatus" name="orderStatus[]" multiple data-col-index="7">
            		<option value="9">راجع كلي</option>
            		<option value="6">راجع جزئي</option>
            		<option value="5">استبدال</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المحافظة المرسل لها:</label>
            	<select id="city" name="city" onchange="getorders()" class="form-control kt-input" data-live-search="true" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المندوب</label>
                <select id="driver" name="driver" onchange="getorders()" class="border-success form-control selectpicker" data-live-search="true" data-col-index="2">

                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المخزن</label>
                <select id="storage" name="storage" onchange="getorders()" class="border-success form-control selectpicker" data-col-index="2">
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة الطلبات من الكشف</label>
                <select id="invoice" name="invoice" onchange="getorders()" class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="">... اختر...</option>
            		<option value="1">طلبات بدون كشف</option>
            		<option value="2">طلبات كشف</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>.</label><br />
            	<input onclick="makeInvoice()" type="button" class="btn btn-danger" value="انشاء كشف">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>.</label><br />
            	<input onclick="downloadReport()" type="button" class="btn btn-success" value="تحميل تقرير">
            </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>
          </fieldset>

          <div class="row kt-margin-b-20">
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
              	<label>عدد السجلات في الصفحة الواحدة</label>
              	<select onchange="getorders()" class="form-control kt-input" name="limit" data-col-index="7">
              		<option value="10">10</option>
              		<option value="15">15</option>
              		<option value="20">20</option>
              		<option value="25">25</option>
              		<option value="30">30</option>
              		<option value="50">50</option>
              		<option value="100">100</option>
              		<option value="250">250</option>
              	</select>
              </div>
              <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
               <br /><h1>عدد الطلبيات:<span id="orders_count"></span></h1>
              </div>
            </div>

        <table class="table table-striped table-bordered table-hover table-checkable responsive nowrap" style="white-space: nowrap; width: 100%;" id="tb-orders">
			       <thead>
	  						<tr>
										<th><input  id="allselector" type="checkbox"><span></span></th>
                                        <th>تاكيد</th>
										<th>رقم الوصل</th>
										<th>الحالة</th>
										<th>المندوب</th>
										<th>المخزن</th>
										<th>اسم و هاتف العميل</th>
										<th>رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
                                        <th>التاريخ</th>
                                        <th>مبلغ الوصل</th>
										<th>المبلغ المستلم</th>
						   </tr>
      	            </thead>
                            <tbody id="ordersTable">
                            </tbody>
                            <tfoot>
	                <tr>
										<th></th>
                                        <th>تاكيد</th>
										<th>رقم الوصل</th>
										<th>الحالة</th>
										<th>المندوب</th>
										<th>المخزن</th>
										<th>اسم و هاتف العميل</th>
										<th>رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
                                        <th>التاريخ</th>
                                        <th>مبلغ الوصل</th>
										<th>المبلغ المستلم</th>

				   </tr>
	           </tfoot>
		</table>
        <div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" name=""
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        <hr />
          <fieldset><legend>التحديثات</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<input type="button" onclick="setOrdersStorage()" class="btn btn-info btn-lg" value="ادخال المحدد للمخزن" />
            </div>
          </div>
          </fieldset>
        </form>
		<!--end: Datatable -->
	</div>
</div>
</div>
<!-- end:: Content -->
</div>
<!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getBraches.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getorderStatus.js" type="text/javascript"></script>
<script src="js/getAllDrivers.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getStorage.js" type="text/javascript"></script>
<script type="text/javascript">
getAllDrivers($("#driver"));
getStorage($("#storage"));
function getorders(){
$.ajax({
  url:"script/_getReturnedOrders.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#tb-orders").addClass("loading");
  },
  success:function(res){
   console.log(res);
   $("#tb-orders").removeClass("loading");
   $("#tb-orders").DataTable().destroy();
   $('#ordersTable').html("");
   $("#pagination").html("");
   $("#orders_count").text(res.total[0].orders);
   if(res.pages >= 1){
     if(res.page > 1){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)-1)+')" class="page-link">السابق</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
         );
     }
     if(Number(res.pages) <= 5){
       i = 1;
     }else{
       i =  Number(res.page) - 5;
     }
     if(i <=0 ){
       i=1;
     }
     for(i; i <= res.pages; i++){
       if(res.page != i){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(i)+')"  class="page-link">'+i+'</a></li>'
         );
       }else{
         $("#pagination").append(
          '<li class="page-item active"><span class="page-link">'+i+'</span></li>'
         );
       }
       if(i == Number(res.page) + 5 ){
         break;
       }
     }
     if(res.page < res.pages){
         $("#pagination").append(
          '<li class="page-item"><a href="#" onclick="getorderspage('+(Number(res.page)+1)+')" class="page-link">التالي</a></li>'
         );
     }else{
         $("#pagination").append(
          '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
         );
     }
   }

   $.each(res.data,function(){
   if(this.storage_id == 0){
     btn ='<button type="button" class="btn btn-icon text-danger btn-lg" onclick="setOrderStorage('+this.id+')"><span class="flaticon-download"></span></button>';
   }else if(this.storage_id != 0){
     btn ='<button type="button" class="btn btn-icon text-success btn-lg" onclick="setOrderOutStorage('+this.id+')"><span class="flaticon-upload"></span></button>';
     btn +='<button type="button" class="btn btn-icon text-info btn-lg" onclick="setOrderResend('+this.id+')"><span class="flaticon2-refresh"></span></button>';
   }else{
     btn ="";
   }
   if(this.storage_id == 1 ){
     btn +=  '<button type="button" class="btn btn-icon text-warning btn-lg" onclick="setOrderOutToClient('+this.id+')"><span class="flaticon-reply"></span></button>';
   }
      $('#ordersTable').append(
       '<tr>'+
            '<td>'+
                '<input class="" type="checkbox" name="id[]" rowid="'+this.id+'">'+
            '</td>'+
            '<td width="100px;">'+
                btn+
            '</td>'+
            '<td>'+this.order_no+'</td>'+
            '<td>'+this.status_name+'<br />('+this.storage_status+')</td>'+
            '<td>'+this.driver_name+'</td>'+
            '<td>'+this.storage_status+'</td>'+
            '<td>'+this.store_name+'<br />'+phone_format(this.client_phone)+'</td>'+
            '<td>'+phone_format(this.customer_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+'<br />'+this.address+'</td>'+
            '<td>'+this.date+'</td>'+
            '<td>'+formatMoney(this.price)+'</td>'+
            '<td>'+formatMoney(this.new_price)+'</td>'+
         '</tr>');
     });

     var myTable= $('#tb-orders').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
       "scrollX": true,
       "bPaginate": false,
       "bLengthChange": false,
       "bFilter": false,
       serverPaging: true
      });
      $("#tb-orders").removeClass("loading");
    },
   error:function(e){
     $("#tb-orders").removeClass("loading");
    console.log(e);
  }
});
}
function getorderspage(page){
    $("#p").val(page);
    getorders();
}
function downloadReport(){
var domain = "script/downloadStorageReport.php?";
var data = $("#ordertabledata").serialize()+'&pageDir=1&reportType=3&space=5&fontSize=12';
window.open(domain + data, '_blank');
}
getClients($("#client"));
function getclient(){
 getClients($("#client"),$("#branch").val());
 getorders();
 getAllDrivers($("#driver_action"),$("#branch").val());
}

$( document ).ready(function(){
getAllDrivers($("#driver_action"),$("#branch").val());
getStores($('#store'));
getorders();
$("#allselector").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
      $('input[name="id\[\]"]').attr('checked', false);;
    }else{
      $('input[name="id\[\]"]').attr('checked', true);;
    }
});
$('#start').datepicker({
    format: "yyyy-mm-dd",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
    pickerPosition: 'bottom-left',
    defaultDate:'now'
});
$('#end').datepicker({
    format: "yyyy-mm-dd",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
    pickerPosition: 'bottom-left',
    defaultDate:'now'
});
getBraches($("#branch"));
getBraches($("#to_branch"));
getCities($("#city"));

});
function disable(){
  if($("#action").val() == 'asign'){

    $("#discount").attr("disabled",true);
    $("#driver_action").removeAttr("disabled");
    $("#status_action").attr("disabled",true);
  }else if($("#action").val() == 'delete'){

    $("#discount").attr("disabled",true);
    $("#driver_action").attr("disabled",true);
    $("#status_action").attr("disabled",true);
  }else if($("#action").val() == 'status'){

    $("#discount").attr("disabled",true);
    $("#driver_action").attr("disabled",true);
    $("#status_action").removeAttr("disabled");
  }else if($("#action").val() == 'discount'){

    $("#discount").removeAttr("disabled");
    $("#driver_action").attr("disabled",true);
    $("#status_action").removeAttr("disabled");
  }else if($("#action").val() == 'money_in' || $("#action").val() == 'money_out'){

    $("#discount").attr("disabled",true);
    $("#driver_action").attr("disabled",true);
    $("#status_action").attr("disabled",true);
  }else{

    $("#discount").attr("disabled",true);
    $("#driver_action").removeAttr("disabled");
    $("#status_action").removeAttr("disabled");
  }
  getAllDrivers($("#driver_action"),$("#branch").val());
  $('.selectpicker').selectpicker('refresh');
   console.log($("#action").val());
}

function setOrdersStorage(){
     $('input[name="ids\[\]"]', form).remove();
      var form = $('#ordertabledata');
      $.each($('input[name="id\[\]"]:checked'), function(){
               rowId = $(this).attr('rowid');
         form.append(
             $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'ids[]')
                .val(rowId)
         );
      });

      $.ajax({
        url:"script/_setOrdersStorage.php",
        type:"POST",
        data:$("#ordertabledata").serialize(),
        success:function(res){
          getorders();
          console.log(res);
          if(res.success == 1){
            Toast.success("تم الادخال الى المخزن");
          }else{
            Toast.warning("حدث خطاء! حاول مرة اخرى. تاكدد من تحديد عنصر واحد على اقل تقدير");
          }
        },
        error:function(e){
           Toast.error("خطأ!");
          console.log(e);
        }
      });

      // Remove added elements
      //$('input[name="id\[\]"]', form).remove();
}

function setOrderStorage(id){
        $.ajax({
        url:"script/_setOrderStorage.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الادخال الى المخزن');
           getorders();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res);
        },
        error:function(e){
          console.log(e);
        }
      });
}
function setOrderOutToClient(id){
  if(confirm("هل انت متاكد من ارجاع الطلب للعميل؟")){
        $.ajax({
        url:"script/_setOrderOutToClient.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم ارجاع الطلب للعميل');
           getorders();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res);
        },
        error:function(e){
          console.log(e);
        }
      });
  }
}

function setOrderResend(id){
  if(confirm("هل انت متاكد من اعاده ارسال الطلب")){
        $.ajax({
        url:"script/_setOrderResend.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم اخراج واعادة ارسال الطلب');
           getorders();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res);
        },
        error:function(e){
          console.log(e);
        }
      });
  }
}
function makeInvoice() {
  if($("#storage").val() > 0 ){
    if(Number($("#store").val()) > 0){
      if(Number($("#invoice").val()) == 1){
              $.ajax({
                url:"script/_makeInvoiceByStorageStaff.php",
                data: $("#ordertabledata").serialize(),
                beforeSend:function(){
                 $("#ordertabledata").addClass("loading");
                },
                success:function(res){
                  $("#ordertabledata").removeClass("loading");
                  if(res.success == 1){
                    getorders();
                    var d = new Date();
                    window.open('invoice/'+res.invoice, '_blank');
                  }else{
                    Toast.warning("خطأ");
                  }
                  console.log(res);
                },
                error:function(e){
                  $("#ordertabledata").removeClass("loading");
                  console.log(e);
                }
              });
      }else{
        Toast.warning("يحب تحديد الطلبات بدون كشف");
      }
    }else{
      Toast.warning("يحب تحديد الصفحه");
    }
  }else{
     Toast.warning("يجب تحديد المخزن");
  }
}
function setOrderOutStorage(id){
        $.ajax({
        url:"script/_setOrderOutStorage.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الادخال الى المخزن');
           getorders();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res);
        },
        error:function(e){
          console.log(e);
        }
      });
}
</script>
<script src="./assets/js/demo1/pages/components/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
