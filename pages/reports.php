<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,3,5]);
}
?>
<?
include("config.php");
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
  background-color: #008000;
  color:#FFFFFF;
  text-align: center !important;
}


@page {
  size: landscape;
  margin: 5mm 5mm 5mm 5mm;
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
    <form id="ordertabledata" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>فلتر</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>فرع الاستلام:</label>
            	<select onchange="getclient();getAllDrivers($('#driver'),$('#branch').val())" class="form-control kt-input" id="branch" name="branch" data-col-index="6">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>فرع الارسال:</label>
            	<select onchange="" class="form-control kt-input" id="to_branch" name="to_branch" data-col-index="6">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الصفحه:</label>
            	<select onchange="" data-actions-box="true" data-show-subtext="true" data-live-search="true"  class="selectpicker form-control kt-input" id="store" name="store" data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>الحالة:</label>
            	<select onchange=""  title="اختر الحالة" class="form-control kt-input" id="orderStatus" name="orderStatus[]" data-live-search="true" data-show-subtext="true" data-actions-box="true" multiple data-col-index="7">
            		<option value="">Select</option>
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المحافظة المرسل لها:</label>
            	<select id="city" name="city"  onchange="getTowns2($('#town'),$(this).val());" data-live-search="true" class="form-control kt-input" data-col-index="2">
            		<option value="">Select</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة التكرار:</label>
                <select name="repated" onchange="" class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="">عرض الكل</option>
            		<option value="1">عرض المكرر فقط</option>
            		<option value="2">عرض غير المكرر</option>
                </select>
            </div>
          </div>
          <div class="row kt-margin-b-20">
            <div class="col-lg-1 kt-margin-b-10-tablet-and-mobile">
            	<label>رقم الوصل:</label>
            	<input id="order_no" name="order_no" value="<?php if(!empty($_GET['order_no'])){ echo $_GET['order_no'];} ?>" onkeyup="" type="text" class="form-control kt-input" placeholder="" data-col-index="0">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>اسم او هاتف المستلم:</label>
            	<input name="customer" onkeyup="" type="text" class="form-control kt-input" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="" onchange="" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input  type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المندوب:</label>
                <select id="driver" name="driver"  data-actions-box="true" data-live-search="true" class="form-control kt-input" data-col-index="2">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة تسليم المبلغ للعميل:</label>
                <select name="money_status"  class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="">... اختر...</option>
            		<option value="1">تم تسليم المبلغ</option>
            		<option value="0">لم يتم تسليم المبلغ</option>
                </select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة الطلبات من الكشف</label>
                <select id="invoice" name="invoice"  class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="">... اختر...</option>
            		<option value="1">طلبات بدون كشف</option>
            		<option value="2">طلبات كشف</option>
                </select>
            </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>
          <div class="row kt-margin-b-20">
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>المنطقه:</label>
                <select id="town" name="town"  class="form-control kt-input" data-live-search="true" data-col-index="2">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة التاكيد من الفروع</label>
                <select id="confirm" name="confirm"  class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="all">الكل</option>
            		<option value="1">الطلبيات المؤكدة</option>
            		<option value="4">الطلبيات الغير المؤكدة</option>
                </select>
            </div>
<!--            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>حالة المخزن</label>
                <select id="storageStatus" name="storageStatus"  class="selectpicker form-control kt-input" data-col-index="2">
            		<option value="all">الكل</option>
            		<option value="1">بدون كشف </option>
            		<option value="2">لديها كشف  ولم يتم التحاسب</option>
            		<option value="3">لديها كشف وتم التحاسب</option>
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
<!--            <div class="col-lg-1 kt-margin-b-10-tablet-and-mobile">
                	<label class="">.</label><br />
                    <input  id="invoicebtn" name="invoicebtn" type="button" value="كشف" onclick="makeInvoice()" class="btn btn-danger" placeholder="" data-col-index="1">
            </div>-->
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                	<label class="">.</label><br />
                    <input id="download" name="download" type="button" value="تحميل التقرير" data-toggle="modal" data-target="#reportOptionsModal" class="btn btn-success" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                	<label class="">.</label><br />
                    <input  type="button" value="بحث" onclick="getorders()"  class="btn btn-warning" placeholder="" data-col-index="1">
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
              	<label>عدد السجلات</label>
              	<select onchange="getorders()" class="form-control selectpicker" name="limit" data-col-index="7">
                    <option value="10">10</option>
              		<option value="15">15</option>
              		<option value="20">20</option>
              		<option value="25">25</option>
              		<option value="30">30</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
              	</select>
            </div>
          </div>
          </fieldset>
		<!--begin: Datatable -->
        <div class="" id="section-to-print">
          <div class="col-md-12" id="">
          <div class="row kt-margin-b-20 text-white" id="total-section">
               <div class="col-sm-4">
                    <label>الصفحه:&nbsp;</label><label id="total-client"> لم يتم تحديد عميل </label>
                 </div>
                 <div class="col-sm-3">
                    <label>المبلغ الصافي:&nbsp;</label><label id="total-price"> 0.0 </label>
                 </div>
                 <div class="col-sm-2">
                    <label>مجوع الخصم:&nbsp;</label><label id="total-discount"> 0.0 </label>
                 </div>
                 <div class="col-sm-3">
                    <label>عدد الطلبات:&nbsp;</label><label id="total-orders"> 0 </label>
                 </div>
          </div>
          </div>
        <div calss="col-sm-12 table-responsive">
		<table class="table table-striped  table-bordered  nowrap" style="white-space: nowrap; width: 100%;"  id="tb-orders">
			       <thead>
	  						<tr>
										<th>رقم الوصل</th>
										<th>اسم وهاتف العميل</th>
										<th>عنوان وهاتف المستلم</th>
										<th>الحاله</th>
										<th>تاريخ الادخال</th>
										<th>مبلغ الوصل</th>
										<th>المبلغ المستلم</th>
										<th>تعديل</th>
										<th>المدخل</th>
										<th>مبلغ التوصيل</th>
										<th>المبلغ الصافي للعميل</th>
										<th>المندوب</th>
										<th>اسم موضف التبليغات</th>
										<th>من فرع الى فرع</th>

		  					</tr>
      	            </thead>
                            <tbody id="ordersTable">
                            </tbody>

		</table>
        </div>
        <div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        </div>
        </form>
        <!--end: Datatable -->
	</div>

</div>

</div>
<!-- end:: Content -->
</div>
<div class="modal fade" id="editOrderModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title">تعديل الطلب</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editOrderForm">
				<div class="kt-portlet__body">
                    <div class="form-group">
						<label>رقم الطلب:</label>
						<input type="name" id="e_order_no" name="e_order_no" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_order_no_err"></span>
					</div>
                    <div class="form-group">
						<label>السعر المستلم:</label>
						<input type="name" id="e_iprice" name="e_iprice" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_iprice_err"></span>
					</div>
                    <div class="form-group">
						<label>مبلغ الوصل:</label>
						<input type="name" id="e_price" name="e_price" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="e_price_err"></span>
					</div>
<!--                  <div class="form-group">
  						<label>نوع الطلب:</label>
  						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control" name="e_order_type" id="e_order_type" >
                          <option value="">----</option>
                          <option value="multi">عامة</option>
                          <option value="ملابس">ملابس</option>
                          <option value="الكترونيات">الكترونيات</option>
                          <option value="وثائق">وثائق</option>
                          <option value="اثاث">اثاث</option>
                         </select>
                          <span class="form-text text-danger" id="e_order_type_err"></span>
  				</div>-->
                  <div class="form-group">
  						<label>الوزن:</label>
  						<input type="number" value="1" id="e_weight" name="e_weight" class="form-control"  placeholder="">
  						<span class="form-text text-danger" id="e_weight_err"></span>
  				  </div>
                  <div class="form-group">
  						<label>العدد:</label>
  						<input type="number" value="1" id="e_qty" name="e_qty" class="form-control"  placeholder="">
  						<span class="form-text text-danger" id="e_qty_err"></span>
  				  </div>
                  <div class="form-group">
  						<label>التاريخ:</label>
  						<input type="text" id="e_date" name="e_date" class="form-control" data-col-index="5">
  						<span class="form-text text-danger" id="e_date_err"></span>
  				  </div>
                  <div class="form-group">
  						<label>الفرع:</label>
  						<select onchange="updateClient()" data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_branch" id="e_branch"  value="">
                          </select>
                          <span class="form-text text-danger" id="e_branch_err"></span>
  				</div>
                  <div class="form-group">
  						<label>العميل:</label>
  						<select onchange="getStores($('#e_store_id'),$(this).val())" data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_client" id="e_client_id"  value="">
                        </select>
                        <span class="form-text text-danger" id="e_client_err"></span>
  			     </div>
                 <div class="form-group">
  						<label>اسم السوق او الصفحه:</label>
  						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_store" id="e_store_id"  value="">
                          </select>
                          <span class="form-text text-danger" id="e_store_err"></span>
  				  </div>
                  <div class="form-group">
  						<label>اسم المستلم:</label>
  						<input type="text" id="e_customer_name" name="e_customer_name" class="form-control"  placeholder="">
  						<span class="form-text text-danger" id="e_customer_name_err"></span>
  				</div>
                  <div class="form-group">
  						<label>اسم المستلم:</label>
  						<input type="text" id="e_customer_phone" name="e_customer_phone" class="form-control"  placeholder="">
  						<span class="form-text text-danger" id="e_customer_phone_err"></span>
  				</div>
                  <div class="form-group">
  						<label>المحافظة:</label>
  						<select onchange="updateTown()" data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_city" id="e_city"  value="">
                          </select>
                          <span class="form-text text-danger" id="e_city_err"></span>
  				</div>
                  <div class="form-group">
  						<label>المدينة(القضاء او الحي):</label>
  						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_town" id="e_town"  value="">
                          </select>
                          <span class="form-text text-danger" id="e_town_err"></span>
  				</div>
                  <div class="form-group">
  						<label>الفرع المرسل له:</label>
  						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_branch_to" id="e_branch_to"  value="">
                          </select>
                          <span class="form-text text-danger" id="e_branch_to_err"></span>
  				</div>
                  <div class="form-group">
      				<label>ملاحظات</label>
      				<textarea type="text" class="form-control" id="e_order_note" name="e_order_note" value=""></textarea>
      				<span id="e_order_note_err" class="form-text text-danger"></span>
      			</div>
                </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updateOrder()" class="btn btn-brand">حفظ التغيرات</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" name="e_Orderid" id="editOrderid"/>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<div class="modal fade" id="trackOrderModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">حالة الطلب</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
<div class="kt-portlet kt-portlet--height-fluid">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">تتبع الطلبية</h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-scroll ps ps--active-y" data-scroll="true" data-mobile-height="764" style="">
                    <!--Begin::Timeline -->
                    <div class="kt-timeline" id="orderTimeline">
                    </div>
                    <!--End::Timeline 1 -->
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 946px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 300px;"></div></div></div>
            </div>
        </div>
        <!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>
<div class="modal fade" id="receiptOrderModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">حالة الطلب</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
          <iframe id='receiptIframe' src="" onload="frameLoaded()" width="100%" height="600px"></iframe>
        <!--end::Portlet-->
        </div>
      </div>

    </div>
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
<div class="modal fade" id="reportOptionsModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">تحميل تقرير</h4>
        </div>
        <div class="modal-body">
    <!--Begin:: App Content-->
    <div class="kt-grid__item kt-grid__item--fluid kt-app__content">
        <div class="kt-portlet">
            <form class="kt-form kt-form--label-right" id="addStaffForm">
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="form-group row">
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>نوع التقرير:</label>
                                    <select data-live-search="true" class="selectpicker form-control" id="reportType" name="reportType">
                                       <option value="1">تقرير تسليمات للمندوب</option>
                                       <option value="2">تقرير المحافظه المرسل لها</option>
                                       <option value="3">تقرير الفرع المرسل له</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>حجم الخط</label>
                                    <input type="number" step="1" min="5" max="100" id="fontSize" name="fontSize" value="12" class="form-control"/>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>اتجاه الورقه:</label>
                                    <select data-live-search="true" class="selectpicker form-control" id="pageDir" name="pageDir">
                                       <option value="L">افقي </option>
                                       <option value="P">عامودي</option>
                                    </select>
                                    <span class="form-text text-danger" id="staff_id_err"></span>
                                </div>
                                <div class="col-lg-6 kt-margin-b-10-tablet-and-mobile">
                                	<label>المسافه بين النص وحدود الخلية</label>
                                    <input type="number" step="1" min="0" max="30" id="space" name="space" value="10" class="form-control"/>
                                    <span class="form-text text-danger" id="staff_id_err"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                            </div>
                            <span class="form-text text-danger" id="staff_password_err"></span>
                        </div>
                    </div>

                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-3 col-xl-3">
                            </div>
                            <div class="col-lg-9 col-xl-9">
                                <button type="button" onclick="downloadReport()" class="btn btn-success">تحميل التقرير</button>&nbsp;
                                <button type="reset" data-dismiss="modal" class="btn btn-secondary">الغأ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--End:: App Content-->
        </div>
      </div>

    </div>
  </div>
<input type="hidden" id="user_id" value="<?php echo $_SESSION['userid'];?>"/>
<input type="hidden" id="user_branch" value="<?php echo $_SESSION['user_details']['branch_id'];?>"/>
<input type="hidden" id="user_role" value="<?php echo $_SESSION['role'];?>"/>
            <!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
                        <!--end::Page Vendors -->



            <!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="assets/js/demo1/pages/components/datatables/extensions/fixedcolumns.js" type="text/javascript"></script>
<script src="js/getBraches.js" type="text/javascript"></script>
<script src="js/getClients.js" type="text/javascript"></script>
<script src="js/getStores.js" type="text/javascript"></script>
<script src="js/getorderStatusMulti.js" type="text/javascript"></script>
<script src="js/getCities.js" type="text/javascript"></script>
<script src="js/getTowns.js" type="text/javascript"></script>
<script src="js/getManagers.js" type="text/javascript"></script>
<script src="js/getAllDrivers.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).keydown(function(e) {
if (event.which === 13 || event.keyCode === 13 ) {
    event.stopPropagation();
    event.preventDefault();
    getorders();
}
});
var myTable;
getStores($("#store"));
getStores($("#e_store_id"));
getClients($("#e_client_id"),0);
getAllDrivers($("#driver"),$("#branch").val());
$('#tb-orders').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
       "scrollX": true,
       "aaSorting": [],
       "bPaginate": false,
       "bLengthChange": false,
       "bFilter": false,
      });
function getTowns2(elem,city){
   $.ajax({
     url:"script/_getTowns.php",
     type:"POST",
     data:{city: city},
     beforeSent:function(){

     },
     success:function(res){
       elem.html("");
       elem.append("<option value=''>-- اختر --</option>");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.name+"</option>");
       });
       elem.selectpicker('refresh');
       console.log(res);
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>");
        console.log(e);
     }
   });
}
getTowns2($("#town"),1);
function getorders(){
$.ajax({
  url:"script/_getOrdersReport.php",
  type:"POST",
  data:$("#ordertabledata").serialize(),
  beforeSend:function(){
    $("#section-to-print").addClass('loading');


  },
  success:function(res){
   console.log(res);
  // saveEventDataLocally(res.data);
   $("#section-to-print").removeClass('loading');
   $("#tb-orders").DataTable().destroy();
   $("#ordersTable").html("");
   $("#pagination").html("");

/*   if($("#user_role").val() !=1 && $("#user_role").val() !=5){
    $('#branch').selectpicker('val', $("#user_branch").val());
    $('#branch').attr('disabled',"disabled");
    $('#branch').selectpicker('refresh');
   }*/

   $("#total-client").html(res.total[0].store);
   $("#total-price").text(formatMoney(res.total[0].client_price));
   $("#total-discount").text(formatMoney(res.total[0].discount));
   $("#total-orders").text(res.total[0].orders);

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
          '<li class="page-item"><a href="#" onclick="getorderspage('+(i)+')" class="page-link">'+i+'</a></li>'
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
     if(this.invoice_id > 0 ){
         inv = '<a href="invoice/'+this.invoice_path+'" target="_blank" style="color:#FFFFFF;"> | رقم الكشف: '+'<b>'+this.invoice_id+'</b></a>';
     }else{
        inv = ""
     }
     if(this.money_status == 1){
       money = '<span class="success">تم التحاسب'+inv+'</span>';
     }else{
       money = '<span class="danger">لم يتم التحاسب'+inv+'</span>';
     }
     nuseen_msg =this.nuseen_msg;
     notibg = "kt-badge--danger";
     if(this.nuseen_msg == null){
       nuseen_msg = "";
       notibg="";
     }
     if(this.driver_id == 0){
       icon = "<br /><span  data-toggle='kt-tooltip' data-placement='top' data-original-title='لم يتم احالة الطلب الى مندوب' class='fa-2x text-danger flaticon-truck'></span>";
     }else{
       icon = "<br /><span  data-toggle='kt-tooltip' data-placement='top' data-original-title='تم الاحالة الى مندوب' class='fa-2x text-success flaticon2-delivery-truck'></span>";
     }
     if(this.driver_invoice_id > 0){
        icon = "<br /><a href='driver_invoice/"+this.driver_invoice_path+"'>رقم الكشف المندوب: "+this.driver_invoice_id+"</a>";
     }
     if(this.confirm == 4){
       bg ="bg-warning";
     }else{
       bg ="";
     }
     date = this.date;
     d1 = new Date(date);
     d2 = new Date();
     const diffTime = Math.abs(d2 - d1);
     const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
     if(diffDays >= 30 && this.invoice_id <= 0){
        date = '<div class="fc-draggable-handle kt-badge kt-badge--lg kt-badge--danger kt-badge--inline kt-margin-b-15" data-color="fc-event-danger">'+date+'</div>';
     }
     callcenter ="";
     if(this.callcenter_id == 0){
       callcenter = '<button type="button" class="btn btn-clean text-success" onclick="callCenter('+this.id+')"><span class="fa fa-check"></span></button>';
     }
     $("#ordersTable").append(
       '<tr class="'+bg+'">'+
            '<td>'+this.order_no+icon+'</td>'+
            '<td>'+this.store_name+'<br />'+(this.client_phone)+'</td>'+
            '<td>'+this.city+'/'+this.town+''+
            '<br />'+(this.customer_phone)+'</td>'+
            '<td>'+this.status_name+'<br /> ('+this.storage_status+')</td>'+
            '<td>'+date+'</td>'+
            '<td>'+formatMoney(this.price)+'</td>'+
            '<td>'+formatMoney(this.new_price)+'</td>'+
            '<td>'+
                '<button type="button" class="btn btn-clean" onclick="editOrder('+this.id+')" data-toggle="modal" data-target="#editOrderModal"><span class="flaticon-edit"></sapn></button>'+
                '<button type="button" class="btn btn-clean" onclick="deleteOrder('+this.id+')" data-toggle="modal" data-target="#deleteOrderModal"><span class="flaticon-delete"></sapn></button>'+
                '<button type="button" class="btn btn-clean" onclick="OrderTracking('+this.id+')" data-toggle="modal" data-target="#trackOrderModal"><span class="flaticon-information"></span></button>'+
                '<button type="button" class="btn btn-clean" onclick="OrderReceipt('+this.id+')" data-toggle="modal" data-target="#receiptOrderModal"><span class="fa fa-barcode"></span></button>'+
                '<button type="button" class="btn btn-clean" onclick="OrderChat('+this.id+');setMsgSeen('+this.id+')" data-toggle="modal" data-target="#chatOrderModal">'+
                   '<span class="kt-header__topbar-icon"> <i class="flaticon-chat"></i> <span class="kt-badge  kt-badge--notify kt-badge--sm '+notibg+'">'+nuseen_msg+'</span> </span>'+
                '</button>'+ callcenter+
                '<br />'+money+
            '</td>'+
            '<td>'+this.staff_name+'</td>'+
            '<td>'+formatMoney(this.dev_price)+'</td>'+
            '<td>'+formatMoney(this.client_price)+'</td>'+
            '<td>'+this.driver_name+'</td>'+
            '<td>'+this.callcenter_name+'</td>'+
            '<td> من :'+this.branch_name+' الى :'+this.to_branch_name+'</td>'+
        '</tr>');
     });

     myTable= $('#tb-orders').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },
      "scrollX": true,
      "aaSorting": [],
       "bPaginate": false,
       "bLengthChange": false,
       "bFilter": false,
      });
    },
   error:function(e){
    $("#section-to-print").removeClass('loading');
    console.log(e);
  }
});
}
$('a.toggle-vis').on( 'click', function (e) {
    e.preventDefault();

    // Get the column API object
    var column = myTable.column( $(this).attr('data-column') );

    // Toggle the visibility
    column.visible( ! column.visible() );
} );
function deleteOrder(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteOrder.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
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

function getorderspage(page){
    $("#p").val(page);
    getorders();
}
function OrderReceipt(id){
 $('#receiptIframe').parent().addClass('loading');
 $('#receiptIframe').attr('src','script/makeReceipt.php?id='+id);
}
function frameLoaded(){
  $('#receiptIframe').parent().removeClass('loading');
}
  getBraches($("#e_branch"));
  getBraches($("#e_branch_to"));
  getCities($("#e_city"));
function editOrder(id){

  $("#editOrderid").val(id);
  $.ajax({
    url:"script/_getOrder.php",
    data:{id: id},
    beforeSend:function(){
     $("#editOrderForm").addClass("loading");
    },
    success:function(res){
      $("#editOrderForm").removeClass("loading");
      console.log(res);
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_order_no').val(this.order_no);
          $('#e_price').val(this.price);
          $('#e_iprice').val(this.new_price);
          $('#e_customer_phone').val(this.customer_phone);
          $('#e_customer_name').val(this.customer_name);
          $('#e_date').val(this.date);

          $('#e_city').selectpicker('val',this.to_city);
          $('#e_city').val(this.to_city);
          $('#e_branch').val(this.from_branch);

          getTowns($('#e_town'),$('#e_city').val());


          $("#e_weight").val(this.weight);
          $("#e_qty").val(this.qty);
          $("#e_order_note").val(this.note);



          $('#e_town').selectpicker('val',this.to_town);
          $('#e_town').val(this.to_town);

          $('#e_branch_to').selectpicker('val',this.to_branch);
          $('#e_branch_to').val(this.to_branch);
          if(this.client_name != null){
            $('#e_client_id').selectpicker('val',this.client_id);
            $('#e_client_id').val(this.client_id);
          }

          if(this. store_name != null){
          $('#e_store_id').selectpicker('val',this.store_id);
          $('#e_store_id').val(this.store_id);
          }
          $('.selectpicker').selectpicker('refresh');
        });
      }
    },
    error:function(e){
      $("#editOrderForm").removeClass("loading");
      console.log(e);
    }
  });
}
function updateClient(){
 getClients($('#e_client'),$('#e_branch').val());
}

function updateTown(){
   getTowns($('#e_town'),$('#e_city').val());
}
function updateOrder(){
  $.ajax({
    url:"script/_updateOrder.php",
    type:"POST",
    data:$("#editOrderForm").serialize(),
    beforeSend:function(){
      $("#editOrderForm").addClass("loading");
    },
    success:function(res){
      $("#editOrderForm").removeClass("loading");
        console.log(res);
       if(res.success == 1){
         getorders();
         Toast.success('تم الاضافة');
         $("#kt_form .text-danger").text("");
       }else{
          if(res.error["premission"] == 1){
           $("#e_order_no_err").text(res.error["order_no"]);
           $("#e_order_type_err").text(res.error["order_type"]);
           $("#e_price_err").text(res.error["order_price"]);
           $("#e_iprice_err").text(res.error["order_iprice"]);
           $("#e_weight_err").text(res.error["weight"]);
           $("#e_qty_err").text(res.error["qty"]);
           $("#e_client_err").text(res.error["client"]);
           $("#e_store_err").text(res.error["store"]);
           $("#e_client_phone_err").text(res.error["client_phone"]);
           $("#e_customer_name_err").text(res.error["customer_name"]);
           $("#e_customer_phone_err").text(res.error["customer_phone"]);
           $("#e_city_err").text(res.error["city"]);
           $("#e_town_err").text(res.error["town"]);
           $("#e_branch_err").text(res.error["branch_from"]);
           $("#e_branch_to_err").text(res.error["branch_to"]);
           $("#e_town_err").text(res.error["town"]);
           $("#e_with_dev_err").text(res.error["with_dev"]);
           $("#e_order_note_err").text(res.error["order_note"]);
           $("#e_date_err").text(res.error["date"]);
            Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
           }else{
            Toast.warning("لاتملك صلاحيات تعديل هذا الطلب",'خطأ');
           }
       }
    },
    error:function(e){
      console.log(e);
      $("#editOrderForm").removeClass("loading");
       Toast.error('خطأ');
    }
  });
}
function deleteorderStatus(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteorderStatus.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getorderStatus($("#orderStatusesTable"));
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

function getclient(){
 if($("#user_role").val() != 1){
     getClients($("#client"),$("#user_branch").val());
 }else{
     getClients($("#client"),$("#branch").val());
 }
 getorders();
}
$( document ).ready(function(){

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
$('#e_date').datepicker({
    format: "yyyy-mm-dd",
    showMeridian: true,
    todayHighlight: true,
    autoclose: true,
    pickerPosition: 'bottom-left',
});

getBraches($("#branch"));
getBraches($("#to_branch"));
getorderStatus($("#orderStatus"));
getorderStatus($("#status_action"));
getCities($("#city"));
getorders();
//-- set branch equles to user branch
$('#branch').selectpicker('val', $("#user_branch").val());
//-- set clients equles to user branch's clients
getclient();
});
function OrderTracking(id){
   $.ajax({
     url:"script/_getOrderTrack.php",
     data:{id: id},
     beforeSend:function(){

     },
     success:function(res){
       $("#orderTimeline").html('');
       console.log(res);
     if(res.success == 1){
       $.each(res.data,function(){
         if(this.order_status_id == 1){
             icon = "flaticon-attachment kt-font-primary";
             color = "primary";
         }else if(this.order_status_id == 2){
            icon = "flaticon-open-box kt-font-info";
            color = "info";
         }else if(this.order_status_id == 3){
            icon = "flaticon2-lorry kt-font-accent";
            color = "success";
         }else if(this.order_status_id == 4){
            icon = "flaticon-bus-stop kt-font-success";
            color = "success";
         }else if(this.order_status_id == 5){
            icon = "flaticon2-refresh kt-font-warning";
            color = "warning";
         }else if(this.order_status_id == 6){
            icon = "flaticon-reply kt-font-danger";
            color = "danger";
         }else if(this.order_status_id == 7){
            icon = "flaticon-clock-2 kt-font-warning";
            color = "warning";
         }else{
            icon = "flaticon-exclamation-1 kt-font-info";
            color = "info";
         }
         $("#orderTimeline").append(
                    '<div class="kt-timeline__item kt-timeline__item--'+color+'">'+
                            '<div class="kt-timeline__item-section">'+
                                '<div class="kt-timeline__item-section-border">'+
                                    '<div class="kt-timeline__item-section-icon">'+
                                        '<i class="'+ icon +'"></i>'+
                                    '</div>'+
                                '</div>'+
                               '<span class="kt-timeline__item-datetime">'+this.date+'<br />'+this.hour+'</span>'+
                            '</div>'+
                            '<a href="" class="kt-timeline__item-text">'+
                            '</a>'+
                            '<span class="kt-timeline__item-info h5 text-info"> حدث من قبل : '+this.staff_name+'</span>'+
                            '<div class="kt-timeline__item-info">'+
                                this.status+
                            '</div>'+
                        '</div>'
            );
        });
       }else{
         $("#orderTimeline").append("<h2>لا يوجد معلومات</h2>")
       }
     },
     error:function(e){
       console.log(e);
     }
   });
}
function downloadReport(){
var domain = "script/downloadOrdersReport.php?";
var data = $("#ordertabledata").serialize()+'&pageDir='+$("#pageDir").val()+'&reportType='+$("#reportType").val()+'&space='+$("#space").val()+'&fontSize='+$("#fontSize").val();
window.open(domain + data, '_blank');
}
function makeInvoice() {
  if($("#orderStatus").val() == 4 || $("#orderStatus").val() == 6 ||  $("#orderStatus").val() == 9 || $("#orderStatus").val() == 10 || $("#orderStatus").val() == 11  || $("#orderStatus").val() == 7){
    if(Number($("#store").val()) > 0){
        if(Number($("#invoice").val()) == 1){
              $.ajax({
                url:"script/_makeInvoice.php",
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
          console.log(Number($("#invoice").val()));
          Toast.warning("يحب تحديد الطلبات بدون كشف");
        }
    }else{
      Toast.warning("يحب تحديد الصفحه");
    }
  }else{
     Toast.warning("يحب تحديد حاله الطلب (مستلمه او راجعه او مؤجل)");
  }
}
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
function callCenter(id){
  if(confirm("هل انت متاكد من تأكيد التبلغ على هذا الطلب")){
      $.ajax({
        url:"script/_setCallCenterCheck.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم  تاكيد التبليغ');
           getorderStatus($("#orderStatusesTable"));
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
</script>