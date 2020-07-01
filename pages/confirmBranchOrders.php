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
			  <b>تأكيد طلبيات الافرع</b>
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
            	<select onchange="getclient()" class="form-control kt-input" id="branch" name="branch" data-col-index="6">
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
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الحالة:</label>
            	<select onchange="getorders()" class="form-control kt-input" id="orderStatus" name="orderStatus" data-col-index="7">
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
            	<label>اسم او هاتف المستلم:</label>
            	<input name="customer" onkeyup="getorders()" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المحافظة المرسل لها:</label>
            	<select id="city" name="city" onchange="getorders()" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الفرع المرسل له:</label>
            	<select id="to_branch" name="to_branch" onchange="getclient()" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة تسليم المبلغ للعميل:</label>
                <select name="money_status" onchange="getorders()" class="form-control kt-input" data-col-index="2">
            		<option value="">... اختر...</option>
            		<option value="1">تم تسليم المبلغ</option>
            		<option value="0">لم يتم تسليم المبلغ</option>
                </select></div>
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
            </div>

        <table class="table table-striped table-bordered table-hover table-checkable responsive no-wrap" id="tb-orders">
			       <thead>
	  						<tr>
										<th><input  id="allselector" type="checkbox"><span></span></th>
										<th>تاكيد</th>
										<th>رقم الشحنه</th>
                                        <th>رقم الوصل</th>
										<th width="150px">اسم و هاتف العميل</th>
										<th width="150px">رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
										<th>مبلغ الوصل</th>
                                        <th>مع التوصيل</th>
										<th>مبلغ التوصيل</th>
                                        <th>الخصم</th>
                                        <th>حالة المبلغ</th>
                                        <th width="100px">التاريخ</th>
						   </tr>
      	            </thead>
                            <tbody id="ordersTable">
                            </tbody>
                            <tfoot>
	                <tr>
										<th></th>
                                        <th>تاكيد</th>
										<th>رقم الشحنه</th>
										<th>رقم الوصل</th>
										<th width="150px">اسم و هاتف العميل</th>
										<th width="150px">رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
										<th>مبلغ الوصل</th>
                                        <th>مع التوصيل</th>
										<th>مبلغ التوصيل</th>
                                        <th>الخصم</th>
                                        <th>حالة المبلغ</th>
                                        <th width="100px">التاريخ</th>
				   </tr>
	           </tfoot>
		</table>
        <div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        <hr />
          <fieldset><legend>التحديثات</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<input type="button" onclick="confirmOrders()" class="btn btn-info btn-lg" value="تأكيد كل المحدد" />
            </div>
          </div>
          </fieldset>
        </form>
		<!--end: Datatable -->
	</div>
</div>	</div>
<!-- end:: Content -->				</div>
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
<script type="text/javascript">
function getorders(){
$.ajax({
  url:"script/_getUnconfirmedOrders.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#tb-orders").addClass("loading");
  },
  success:function(res){
   console.log(res);
   //saveEventDataLocally(res)
   $("#tb-orders").DataTable().destroy();
   $('#ordersTable').html("");
   $("#pagination").html("");
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
      $('#ordersTable').append(
       '<tr>'+
            '<td>'+
                '<input class="" type="checkbox" name="id[]" rowid="'+this.id+'">'+
            '</td>'+
            '<td width="100px;">'+
                '<button type="button" class="btn btn-icon text-success" onclick="confirmOrder('+this.id+')"><span class="flaticon-like"></span></button>'+
            '</td>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.order_no+'</td>'+
            '<td>'+this.client_name+'<br />'+phone_format(this.client_phone)+'</td>'+
            '<td>'+phone_format(this.customer_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+'<br />'+this.address+'</td>'+
            '<td>'+formatMoney(this.price)+'</td>'+
            '<td>'+this.with_dev+'</td>'+
            '<td>'+formatMoney(this.dev_price)+'</td>'+
            '<td>'+formatMoney(this.discount)+'</td>'+
            '<td>'+this.money_status+'</td>'+
            '<td>'+this.date+'</td>'+
         '</tr>');
     });

     var myTable= $('#tb-orders').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
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
getorderStatus($("#orderStatus"));
getorderStatus($("#status_action"));
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

function confirmOrders(){
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
        url:"script/_confirmOrders.php",
        type:"POST",
        data:$("#ordertabledata").serialize(),
        success:function(res){
          getorders();
          console.log(res);
          if(res.success == 1){
            Toast.success("تم تأكيد الطلبيات بنجاح");
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

function confirmOrder(id){
        $.ajax({
        url:"script/_confirmOrder.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم تأكيد الطلب');
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
