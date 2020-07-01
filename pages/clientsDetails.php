<?php
require_once("config.php");
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
.tdstyle {
  color: #000000;
  font-weight: bold;
}
.success {
 background-color: #CCFFCC;
}
.danger {
background-color: #FFCCCC;
}
.warning{
background-color: #FFFF99;
}
@media print {
  body * {
    visibility: hidden;

  }
  #printReportForm, .header{
    display: none;
  }

  #section-to-print, #section-to-print * {
    visibility: visible;
    color: #000000;

  }
  #section-to-print {
    //position: absolute;
    margin:0px;
    padding: 0px;
    left: 0;

  }
  .dele, .edit{
   visibility: hidden;
   display: none;
  }
}
.text-white {
  color: #FFFFFF;
  padding: 15px;
  font-size: 18px;
}
#total-section {
  background-color: #242939;
  border-radius: 5px;
  box-shadow: 0px 0px 0px #444444;
  margin-top:5px;
}
.table td {
  padding: 4px !important;
  text-align: center !important;
}
.danger {
  display: block;
  background-color: #990000;
  color:#FFFFFF;
  text-align: center !important;
}
.success {
  display: block;
  background-color: #990000;
  color:#FFFFFF;
  text-align: center !important;
}
.span {
  display: inline-block;
  width: 150px;
}

hr {
  border-bottom: #FF6347 2px solid;
}

@page {
  size: landscape;
  margin: 5mm 5mm 5mm 5mm;
  }
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">

            </div>
        </div>
    </div>
</div>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
	<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				تقرير الطبات
			</h3>
		</div>
	</div>


	<div class="kt-portlet__body">
    <form id="storedataform" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>فلتر</legend>
          <div class="row">

              <div class="col-lg-9" id="store_info">
              </div>
          </div>
         <div class="row">
         <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
                  <div class="row">
                  	<label>السوق او الصفحه:</label>
                  	<select onchange="getStoreDetails();storeInfo();getInvoices();getStoreReturned();" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
                  		<option value="">Select</option>
                  	</select>
                  </div>

          </div>
          <div class="col-md-3">
                      <label>الفترة الزمنية:</label>
                      <div class="input-daterange input-group" id="kt_datepicker">
        				<input value="" onchange="getStoreDetails();storeInfo();getInvoices();getStoreReturned();" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
        				<div class="input-group-append">
        					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
        				</div>
        				<input onchange="getStoreDetails();storeInfo();getInvoices();getStoreReturned();" type="text" class="form-control kt-input" name="end" id="end" placeholder="الى" data-col-index="5">
                	</div>
         </div>
         </div>
          </fieldset>
          <div class="row">
          <div class="col-md-12">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-toolbar">
                    <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-2x nav-tabs-line-danger" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fa-1x active" data-toggle="tab" href="#recived" role="tab" aria-selected="false">
                                <i class="flaticon-list"></i> الطلبيات الواصلة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa-1x" data-toggle="tab" href="#returned" role="tab" aria-selected="false">
                                <i class="flaticon-list"></i> الطلبيات الراجعة
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fa-1x" data-toggle="tab" href="#invoices" role="tab" aria-selected="true">
                                <i class="fa fa-file-pdf"></i> الكشوفات
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
              <div class="tab-pane active" id="recived" role="tabpanel">
                <div class="row">
                  <div class="col-md-2">
                    <label>سعر توصيل بغداد:</label>
                    <input type="number" min="0" step="500" name="dev_price_b" class="form-control"/>
                  </div>

                  <div class="col-md-2">
                    <label>سعر التوصيل باقي المحافظات</label>
                    <input type="number" min="0" step="500" name="dev_price_o" class="form-control"/>
                  </div>
                </div>
                <table class="table table-striped  table-bordered table-hover table-checkable responsive no-wrap" id="tb-orders-reciverd">
			       <thead>
	  						<tr>
										<th>رقم الشحنه</th>
										<th>رقم الوصل</th>
										<th>تاريخ الطلب</th>
										<th>رقم المستلم</th>
										<th>العنوان</th>
										<th>مبلغ الوصل</th>
										<th>المبلغ المستلم</th>
										<th>الخصم</th>
										<th>سعر التوصيل</th>
										<th>الصافي للعميل</th>
                                        <th>حالة الطلب</th>

                            </tr>
                   </thead>
                   <tbody id='orders-reciverd'>
                   </tbody>
                </table>
              <div class="col-md-12" id="store_data">


              </div>
              </div>
              <div class="tab-pane" id="returned" role="tabpanel">
                 <fieldset><legend>الحالات</legend>
                 <div class="row">
                   <div class="col-md-3">
                    	<select onchange="getStoreReturned();" title="اختر الحالة" data-show-subtext="true" data-live-search="true" data-actions-box="true" multiple  class="selectpicker form-control kt-input" id="status" name="status[]"  data-col-index="7">
                            <option value="9">راجع كلي</option>
                    		<option value="6">راجع جزئي</option>
                    		<option value="5">استبدال</option>
                       </select>
                     </div>
                     <div class="col-md-2">
                    	<input type="button" onclick="makeInvoiceForReturned()" class="btn btn-danger" value="انشاء كشف"/>
                     </div>
                  </div>
                  </fieldset>
                	<table class="table  table-bordered  responsive no-wrap" id="tb-returned">
                			       <thead>
                	  						<tr>
        										<th>رقم الشحنه</th>
        										<th>رقم الوصل</th>
        										<th>تاريخ الطلب</th>
        										<th>رقم المستلم</th>
        										<th>العنوان</th>
        										<th>مبلغ الوصل</th>
        										<th>المبلغ المستلم</th>
        										<th>الخصم</th>
        										<th>سعر التوصيل</th>
        										<th>الصافي للعميل</th>
                                                <th>حالة الطلب</th>
                		  					</tr>
                      	            </thead>
                                    <tbody id="returnedTable">
                                    </tbody>
                      </table>
              </div>
              <div class="tab-pane" id="invoices" role="tabpanel">
                	<table class="table  table-bordered  responsive no-wrap" id="tb-invioces">
                			       <thead>
                	  						<tr>
                        						<th>رقم الفاتوره</th>
                        						<th>اسم الصفحه</th>
                        						<th>اسم العميل</th>
                        						<th>رقم هاتف العميل</th>
                        						<th>التاريخ</th>
                        						<th>الملف</th>
                        						<th>حالة الفاتورة</th>
                        						<th>تعديل</th>
                		  					</tr>
                      	            </thead>
                                    <tbody id="invoicesTable">
                                    </tbody>
                      </table>

              </div>
            </div>
            </div>

            </div>
            <div class="row">
            </div>
            <hr />
  	    <!--begin: Datatable -->
        </form>
        <!--end: Datatable -->
	</div>

</div>

</div>
<!-- end:: Content -->
</div>
<input type="hidden" id="user_branch" value="<?php echo $_SESSION['user_details']['branch_id'];?>"/>
<input type="hidden" id="user_role" value="<?php echo $_SESSION['role'];?>"/>
            <!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
                        <!--end::Page Vendors -->



            <!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getStores.js" type="text/javascript"></script>
<script type="text/javascript">
$('#tb-returned').DataTable();
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
function  getStoreDetails(){
  $.ajax({
    url:"script/_getStoreDetails.php",
    type:"POST",
    data:$("#storedataform").serialize(),
    beforeSend:function(){
       $("#store_info").addClass('loading');
       $("#tb-orders-reciverd").addClass('loading');
       $("#tb-invioces").DataTable().destroy();
       $('#tb-orders-reciverd').DataTable().destroy();
       $('#orders-reciverd').html("");
       $("#invoicesTable").html("");
       $("#store_info").html("");
       $("#store_data").html("");
    },
    success:function(res){
      $("#store_info").removeClass('loading');
      $("#tb-orders-reciverd").removeClass('loading');
      console.log(res);
      content ="";
      $.each(res.data,function(k,v){
             $.each(v,function(){
                   content = content +
                       '<tr>'+
                          '<td>'+this.id+'</td>'+
                          '<td>'+this.order_no+'</td>'+
                          '<td>'+this.dat+'</td>'+
                          '<td>'+this.customer_phone+'</td>'+
                          '<td>'+this.city_name+'-'+this.town_name+'-'+this.address+'</td>'+
                          '<td>'+this.price+'</td>'+
                          '<td>'+this.new_price+'</td>'+
                          '<td>'+this.discount+'</td>'+
                          '<td>'+this.dev_price+'</td>'+
                          '<td>'+this.client_price+'</td>'+
                          '<td>'+this.status_name+'</td>'+
                       '</tr>'
                   ;
             });
         $("#orders-reciverd").append(content);
      });
      if(res.success == 1){
      $("#store_data").append(
        '<br /><br /><table class="table table-striped  table-bordered">'+
          '<tr>'+
            '<td>عدد الطلبيات</td>'+
            '<td>المبلغ الكلي</td>'+
            '<td>مبلغ التوصيل</td>'+
            '<td>الخصم</td>'+
            '<td>الصافي للعميل</td>'+
            '<td>انشاء فاتوره</td>'+
          '</tr>'+
          '</tr>'+
            '<td>'+res.pay.orders+'</td>'+
            '<td>'+res.pay.income+'</td>'+
            '<td>'+res.pay.dev+'</td>'+
            '<td>'+res.pay.discount+'</td>'+
            '<td>'+res.pay.client_price+'</td>'+
            '<td><button onclick="makeInvoice()" type="button" class="btn btn-success">انشاء كشف</button></td>'+
          '</tr>'+
        '</table>'
      );
      }


     var table= $('#tb-orders-reciverd').DataTable();
    },
    error:function(e){
     $("#store_info").removeClass('loading');
     $("#tb-orders-reciverd").removeClass('loading');
     console.log(e);
    }
  })
}


function getStoreReturned(){
  $.ajax({
    url:"script/_getStoreReturned.php",
    type:"POST",
    data:$("#storedataform").serialize(),
    beforeSend:function(){
       $("#tb-returned").DataTable().destroy();
       $("#tb-returned").addClass('loading');
       $("#returnedTable").html("");
    },
    success:function(res){
      $("#tb-returned").removeClass('loading');
      console.log(res);
      content = "";
           $.each(res.data,function(){
                 content = content +
                       '<tr>'+
                          '<td>'+this.id+'</td>'+
                          '<td>'+this.order_no+'</td>'+
                          '<td>'+this.dat+'</td>'+
                          '<td>'+this.customer_phone+'</td>'+
                          '<td>'+this.city_name+'-'+this.town_name+'-'+this.address+'</td>'+
                          '<td>'+this.price+'</td>'+
                          '<td>'+this.new_price+'</td>'+
                          '<td>'+this.discount+'</td>'+
                          '<td>'+this.dev_price+'</td>'+
                          '<td>'+this.client_price+'</td>'+
                          '<td>'+this.status_name+'</td>'+
                       '</tr>'
                   ;
             });
      $("#returnedTable").append(content);
      $("#tb-returned").DataTable({});
      $("#tb-orders").DataTable();
    },
    error:function(e){
     $("#tb-returned").removeClass('loading');
     console.log(e);
    }
  });
}
function getInvoices(){
  $.ajax({
    url:"script/_getInvoices.php",
    type:"POST",
    data:{store:$("#store").val(),start:$("#start").val(),end:$("#end").val()},
    beforeSend:function(){
      $("#tb-invioces").DataTable().destroy();
      $("#tb-invoices").addClass('loading');
      $("#invoicesTable").html("");
    },
    data:$("#storedataform").serialize(),
    success:function(res){
     $("#tb-invoices").removeClass('loading');
     bg ="";
    $.each(res.data,function(){
         if(this.orders_status == 4){
           bg = 'success';
         }else if(this.orders_status == 6){
           bg = 'danger';
         }else if(this.orders_status == 7){
           bg = 'warning';
         }else{
           bg = "";
         }
         if(this.invoice_status == 1){
           invoice_status = "<span >تم التحاسب<span>";
           btn = '<button type="button" class="btn btn-danger" onclick="unpayInvoice('+this.id+')" >الغأ التحاسب</button>';
         }else{
           invoice_status = "<span >لم يتم التحاسب<span>";
           btn = '<button type="button" class="btn btn-success" onclick="payInvoice('+this.id+')">تم التحاسب</button>'+
           '<button type="button" class="btn btn-clean btn-link" onclick="deleteInvoice('+this.id+')"><span class="flaticon-delete"></sapn></button>';
         }
       if(this.orders_status == 4){
         bg = 'success';
       }else if(this.orders_status == 9 ){
         bg = 'danger';
         if(this.invoice_status == 1){
           invoice_status = "راجع للعميل";
             btn = '<button type="button" class="btn btn-danger" onclick="unpayInvoice('+this.id+')" >ارجاع للمخزن الرئيسي</button>';
         }else{
           invoice_status = "رواجع";
            btn = '<button type="button" class="btn btn-success" onclick="payInvoice('+this.id+')">راجع للعميل</button>'+
                  '<button type="button" class="btn btn-clean btn-link" onclick="deleteInvoice('+this.id+')" ><span class="flaticon-delete"></sapn></button>';
         }
       }
      $("#invoicesTable").append(
       '<tr class="">'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.store_name+'</td>'+
            '<td>'+this.client_name+'</td>'+
            '<td>'+this.client_phone+'</td>'+
            '<td>'+this.in_date+'</td>'+
            '<td><a href="invoice/'+this.path+'" target="_blank">تحميل ملف الفاتوره</a></td>'+
            '<td>'+invoice_status+'</td>'+
            '<td>'+
                btn+
            '</td>'+
        '</tr>');
     });
     var myTable= $('#tb-invioces').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض _MENU_ سجل",
        "sSearch": "بحث:",

      },
      "order": [],
      });

     console.log(res);
    },
    error:function(e){
     $("#tb-invoices").removeClass('loading');
     console.log(e);
    }
  });
}
function storeInfo(){
  $.ajax({
    url:"script/_getStoreInfo.php",
    type:"POST",
    beforeSend:function(){
      $("#store_info").html('');
      $("#store_info").addClass('loading');
    },
    data:$("#storedataform").serialize(),
    success:function(res){
     $("#store_info").removeClass('loading');
     console.log(res);
     $.each(res.data,function(){
       $("#store_info").append(
         '<div class="row">'+
           '<div class="col-sm-3 fa-1x"><span>الشحنات الكلية: </span><br /><span class="fa-2x text-info">'+this.total+'</span></div>'+
           '<div class="col-sm-3 fa-1x"><span >الشحنات المستلمة: </span><br /><span class="fa-2x text-success">'+this.recived+'</span></div>'+
           '<div class="col-sm-3 fa-1x"><span>الشحنات الراجعه: </span><br /><span class="fa-2x text-danger">'+this.returned+'</span></div>'+
           '<div class="col-sm-3 fa-1x"><span>الشحنات المعلقه: </span><br /><span class="fa-2x text-warning">'+this.others+'</span></div>'+
         '</div>'
       );
     });
    },
    error:function(e){
     $("#store_info").removeClass('loading');
     console.log(e);
    }
  });
}
function makeInvoice() {
 if(Number($("#store").val()) > 0){
        $.ajax({
            url:"script/_makeInvoiceForAll.php",
            type:"POST",
            data: $("#storedataform").serialize(),
            beforeSend:function(){
              $("#tb-orders-reciverd").addClass('loading');
            },
            success:function(res){
            $("#tb-orders-reciverd").removeClass('loading');
            console.log(res);
                  if(res.success == 1){
                    getInvoices();
                    getStoreDetails();
                  }else{
                   Toast.warning("خطأ");
                  }
                },
                error:function(e){
                  $("#orders-reciverd-total").removeClass('loading');
                  console.log(e);
                  Toast.warning("خطأ");
                }
              });
    }else{
      Toast.warning("يحب تحديد الصفحه");
    }
}
function makeInvoiceForReturned() {
 if(Number($("#store").val()) > 0){
        $.ajax({
            url:"script/_makeInvoiceForReturned.php",
            type:"POST",
            beforeSend:function(){
              $("#tb-returned").addClass("loading");
            },
            data: $("#storedataform").serialize()+"&orderStatus=6",
            success:function(res){
              $("#tb-returned").removeClass("loading");
            console.log(res);
                  if(res.success == 1){
                    getStoreReturned();
                    getInvoices();
                  }else{
                   Toast.warning("خطأ");
                  }
                },
                error:function(e){
                  console.log(e);
                }
              });
    }else{
      $("#tb-returned").removeClass("loading");
      Toast.warning("يحب تحديد الصفحه");
    }
}
function payInvoice(id){
  if(confirm("هل انت متاكد من دفع الفاتوره")){
      $.ajax({
        url:"script/_payInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الدفع');
           getInvoices();
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
function deleteInvoice(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getInvoices();
           getStoreDetails();
           getStoreReturned();
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
function unpayInvoice(id){
  if(confirm("هل انت متاكد من الغأ دفع الفاتوره")){
      $.ajax({
        url:"script/_unpayInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الدفع');
           getStoreDetails();
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
$( document ).ready(function(){
getStores($("#store"));
});

</script>