<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,9,5]);
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
.returned {
  background-color: #FFCCCC!important;
}
.replace {
  background-color: #FFFF99!important;
}
.half {
  background-color: #FF9933 !important;
}
 .chatbody {
  height: 400px;
  border:1px solid #A9A9A9;
  border-radius: 10px;
  overflow-y: scroll;
  padding-top:5px;
 }
 .msg {
   display: block;
   position: relative;
   margin-bottom:15px;
   padding-bottom:10px;
 }
 .other{
   position: relative;
   margin-left:0px;
   width:80%;
   margin-right:auto;
   text-align: left !important;
 }
 .other .content {
   background-color: #F8F8FF;
   border-top-right-radius: 5px;
   border-bottom-right-radius: 5px;
   text-align: left !important;
 }

 .mine {
   position: relative;
   width:80%;
   margin-left:0px;
   margin-right: 0px;

 }
 .mine .content {
   background-color: #008B8B;
   color:#F8F8FF;
   border-top-left-radius: 5px;
   border-bottom-left-radius: 5px;
 }

 .content{
   position: relative;
   padding:5px;
   padding-left:15px;
   padding-right:15px;
   display:inline-block;
   min-width:10px;
   max-width:80%;
   font-size: 14px;
   color:#000000;
 }
.name {
  position: relative;
  display: inline-block;
  font-size:10px;
}
.time {
  display:inline-block;
  position: relative;
  font-size: 10px;
  color: #696969;
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
			  <b>متابعة الطلبات</b>
			</h1>
		</div>
	</div>

	<div class="kt-portlet__body">
		<!--begin: Datatable -->
        <form id="ordertabledata" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>فلتر</legend>
          <div class="row kt-margin-b-20">
<!--            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الفرع:</label>
            	<select onchange="getclient()" class="form-control kt-input" id="branch" name="branch" data-col-index="6">
            	</select>
            </div>
           <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>العميل:</label>
            	<select onchange="getStores($('#store'),$(this).val());" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="client" name="client" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الصفحة (البيج):</label>
            	<select onchange="" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>-->
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الحالة:</label>
            	<select onchange="" class="form-control kt-input" id="orderStatus" name="orderStatus[]" data-col-index="7">
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
  				<input onchange="" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>رقم الوصل:</label>
            	<input id="order_no" name="order_no" onkeyup="" type="text" class="form-control kt-input" placeholder="" data-col-index="0">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label> هاتف المستلم:</label>
            	<input name="customer" onkeyup="" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المحافظة المرسل لها:</label>
            	<select id="city" name="city" onchange="" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المندوب:</label>
                <select id="driver" name="driver"  data-actions-box="true" data-live-search="true" class="form-control kt-input" data-col-index="2">
            	</select>
            </div>
<!--            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الفرع المرسل له:</label>
            	<select id="to_branch" name="to_branch" onchange="getclient()" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>-->
<!--            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة التحاسب مع العميل:</label>
                <select name="money_status" onchange="" class="form-control selectpicker" data-col-index="2">
            		<option value="">... اختر...</option>
            		<option value="1">تم التحاسب </option>
            		<option value="0">لم يتم التحاسب</option>
                </select>
            </div>-->
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة الاستعلامات</label>
                <select id="callcenter" name="callcenter"  class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="all">الكل</option>
            		<option value="1">تم الاستعلام</option>
            		<option value="2">لم يتم الاستعلام</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>.</label><br />
                <input type="button" onclick="getorders()" class="btn btn-warning" value="بحث"/>
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
                <br /><label class="fa-2x">عدد الطلبيات:&nbsp;</label><label class="fa-2x" id="total-orders"> 0 </label>
            </div>
            </div>

        <table class="table table-striped table-bordered  table-checkable  nowrap" id="tb-orders">
			       <thead>
	  						<tr>
										<th>تاكيد</th>
										<th>رقم الوصل</th>
										<th width="150px">اسم و هاتف العميل</th>
										<th width="150px">المندوب</th>
										<th width="150px">رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
										<th>الحالة</th>
										<th>اخر ملاحظة</th>
										<th>مبلغ الوصل</th>
                                        <th>المبلغ المستلم</th>
										<th>حالة المبلغ</th>
                                        <th width="100px">التاريخ</th>
						   </tr>
      	            </thead>
                            <tbody id="ordersTable">
                            </tbody>
                            <tfoot>
	                <tr>
										<th>تاكيد</th>
										<th>رقم الوصل</th>
										<th width="150px">اسم و هاتف العميل</th>
										<th width="150px">المندوب</th>
										<th width="150px">رقم هاتف المستلم</th>
										<th>عنوان المستلم</th>
										<th>الحالة</th>
                                        <th>اخر ملاحظة</th>
										<th>مبلغ الوصل</th>
                                        <th>المبلغ المستلم</th>
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

        </form>
		<!--end: Datatable -->
	</div>
</div>
</div>
<!-- end:: Content -->
</div>
<div class="modal fade" id="chatOrderModal" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">المحادثات</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
        <div class="row">
            <div class="col-12 chatbody" id="chatbody">

            </div>
        </div>
        <div class="row"><hr /></div>
        <div class="row">
          <div class="col-12">
             <div class="input-group">
                   <button onclick="sendMessage()" class="btn btn-info btn-sm" id="btn-chat">ارسال</button>
                   <textarea id="message" type="text" class="form-control input-sm" placeholder=""></textarea>
             </div>
             <input type="hidden"  id="chat_order_id"/>
             <input type="hidden" value="0" id="last_msg"/>
          </div>
        </div>
        <!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<input type="hidden" id="user_id" value="<?php echo $_SESSION['userid'];?>"/>
<input type="hidden" id="user_branch" value="<?php echo $_SESSION['user_details']['branch_id'];?>"/>
<input type="hidden" id="user_role" value="<?php echo $_SESSION['role'];?>"/>
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
$(document).keydown(function(e) {
if (event.which === 13 || event.keyCode === 13 ) {
    event.stopPropagation();
    event.preventDefault();
    getorders();
}
});
getAllDrivers($("#driver"),$("#branch").val());
function getorders(){
$.ajax({
  url:"script/_getOrdersReport.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#tb-orders").addClass("loading");
  },
  success:function(res){
   console.log(res);
   //saveEventDataLocally(res)
   $("#total-orders").text(res.total[0].orders);
   $("#tb-orders").removeClass("loading");
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
     nuseen_msg =this.nuseen_msg;
     notibg = "kt-badge--danger";
     if(this.nuseen_msg == null){
       nuseen_msg = "";
       notibg="";
     }
     callcenter ='<button type="button" class="btn btn-icon" onclick="OrderChat('+this.id+');setMsgSeen('+this.id+')" data-toggle="modal" data-target="#chatOrderModal">'+
                   '<span class="kt-header__topbar-icon"> <i class="flaticon-chat"></i> <span class="kt-badge  kt-badge--notify kt-badge--sm '+notibg+'">'+nuseen_msg+'</span> </span>'+
                  '</button>';


     if(this.callcenter_id == 0){
       callcenter += '<button type="button" class="btn btn-clean text-success" onclick="callCenter('+this.id+')"><span class="fa fa-check"></span></button>';
     }else {
       callcenter +="<br /> تم التدقيق من قبل "+this.callcenter_name;
     }
     bg = "";
     if(this.order_status_id == 9){
       bg= "returned";
     }else if(this.order_status_id == 6){
       bg= "half";
     }else if(this.order_status_id == 5){
       bg= "replace";
     }
      $('#ordersTable').append(
       '<tr class="'+bg+'">'+
            '<td width="100px;">'+
                callcenter+
            '</td>'+
            '<td>'+this.order_no+'</td>'+
            '<td>'+this.store_name+'<br />'+phone_format(this.client_phone)+'</td>'+
            '<td>'+this.driver_name+'<br />'+phone_format(this.driver_phone)+'</td>'+
            '<td>'+phone_format(this.customer_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+'<br />'+this.address+'</td>'+
            '<td>'+this.status_name+'</td>'+
            '<td>'+this.t_note+'</td>'+
            '<td>'+formatMoney(this.price)+'</td>'+
            '<td>'+formatMoney(this.new_price)+'</td>'+
            '<td>'+this.money_status+'</td>'+
            '<td>'+this.date+'</td>'+
         '</tr>');
     });

     var myTable= $('#tb-orders').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
       'scrollX':true,
       "bPaginate": false,
       "bLengthChange": false,
       "bFilter": false,
       serverPaging: true
      });

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
function callCenter(id){
  if(confirm("هل انت متاكد من تأكيد التبلغ على هذا الطلب")){
      $.ajax({
        url:"script/_setCallCenterCheck.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم  تاكيد التبليغ');
           getorders();
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
  }
}
function OrderChat(id,last){
  if(id != $("#chat_order_id").val()){
    chat = 1;
    $("#chatbody").html("");
  }else{
    chat = 0;
  }
  $("#chat_order_id").val(id);

  $.ajax({
    url:"script/_getMessages.php",
    type:"POST",
    data:{order_id:$("#chat_order_id").val(),last:last},
    beforeSend:function(){

    },
    success:function(res){
       if(res.success == 1){
         if(res.last <= 0){
             $("#chatbody").html("");
         }
         $.each(res.data,function(){
            clas = 'other';
           if(this.is_client == 1){
                name = this.client_name
                role = "عميل"
           }else{
               name = this.staff_name
               if(this.from_id== $("#user_id").val()){
                 clas = 'mine';
               }
             role =  this.role_name;
           }
           message =
           "<div class='row'>"+
             "<div class='msg "+clas+"' msq-id='"+this.id+"'>"+
                "<span class='name'>"+name+ " ( "+role+" ) "+"</span><br />"+
                "<span class='content'>"+this.message+"</span><br />"+
                "<span class='time'>"+this.date+"</span><br />"+
             "</div>"+
           "</div>"
           $("#chatbody").append(message);
           $("#last_msg").val(this.id);
         });
          $('#chatbody').animate({scrollTop: $('#chatbody')[0].scrollHeight},100);
            $("#spiner").remove();
       }
    },
    error:function(e){
      console.log(e);
    }
  });
}
function sendMessage(){
  $.ajax({
    url:"script/_sendMessage.php",
    type:"POST",
    data:{message:$("#message").val(), order_id:$("#chat_order_id").val()},
    beforeSend:function(){
      $("#chatbody").append('<div id="spiner" class="clearfix"><span class="spinner-border"></span></div>');
      $('#chatbody').animate({scrollTop: $('#chatbody')[0].scrollHeight},100);
      $("#message").val("");
    },
    success:function(res){
       $('#chatbody').animate({scrollTop: $('#chatbody')[0].scrollHeight},100);
       //OrderChat($("#chat_order_id").val(),$("#last_msg").val());
       console.log(res);
    },
    error:function(e){
      console.log(e);
    }
  });
}
var mychatCaller;
$("#chatOrderModal").on('show.bs.modal', function(){
mychatCaller = setInterval(function(){
  OrderChat($("#chat_order_id").val(),$("#last_msg").val());
}, 1000);
});
$("#chatOrderModal").on('hide.bs.modal', function(){
clearInterval(mychatCaller);
});
function setMsgSeen(id){
     $.ajax({
    url:"script/_setMsgSeen.php",
    type:"POST",
    data:{id:id},
    success:function(res){
      getorders();
    }
  });
}
</script>
<script src="./assets/js/demo1/pages/components/forms/widgets/bootstrap-datetimepicker.js" type="text/javascript"></script>
