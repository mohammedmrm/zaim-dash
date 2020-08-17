<?php
if(file_exists("script/_access.php")){
  require_once("script/_access.php");
  access([1,2,5]);
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
				الفواتير
			</h3>
		</div>
	</div>


	<div class="kt-portlet__body">
    <form id="invoicesForm" class="kt-form kt-form--fit kt-margin-b-20">
          <fieldset><legend>بحث عن كشف</legend>
          <div class="row kt-margin-b-20">
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            	<label>المخزن:</label>
            	<select  onchange='getStorageInvoices();' data-live-search="true" class="form-control kt-input" id="storage_id" name="storage" data-col-index="6">
            	</select>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>رقم الكشف:</label>
            	<input id="id" name="id" class="form-control"/>
            </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="<?php echo date('Y-m-d', strtotime('-7 days'));?>" onchange="getInvoices()" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input onchange="getInvoices()" type="text" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
            	<label>بحث:</label><br />
            	<button type="button" onclick="getInvoices();" type="text" class="btn btn-success" value="" placeholder="" data-col-index="0">بحث
                    <span id="search"  role="status"></span>
                </button>
            </div>
          <div class="kt-separator kt-separator--border-dashed kt-separator--space-md"></div>
          </div>
          </fieldset>

		<!--begin: Datatable -->
        <div class="" id="section-to-print">
		<table class="table  table-bordered  responsive no-wrap" id="tb-invioces">
			       <thead>
	  						<tr>
        						<th>#</th>
        						<th>رقم الفاتوره</th>
        						<th>اسم المخزن</th>
        					    <th>التاريخ</th>
        						<th>الملف</th>
        						<th>تعديل</th>
		  					</tr>
      	            </thead>
                    <tbody id="invoicesTable">
                    </tbody>
                            <tfoot>
	           </tfoot>
		</table>
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
<div class="modal fade" id="transModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">تحويل الى مخزن</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="transForm">
      <div class="modal-body">
        <select id="storage" name="storage">

        </select>
        <input type="hidden" id="storage_invoice_id" name="storage_invoice_id"/>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" onclick="transToStorage()" class="btn btn-primary">ادخال للمخزن</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getStorage.js" type="text/javascript"></script>
<script type="text/javascript">

function getInvoices(){
   $.ajax({
     url:"script/_getStorageInvoices.php",
     type:"POST",
     data:$("#invoicesForm").serialize(),
     beforeSend:function(){
       $("#tb-invioces").DataTable().destroy();
       $("#invoicesTable").html("");
     },
     success:function(res){
     console.log(res);

     $.each(res.data,function(){
      btn ='<button type="button" class="btn btn-clean btn-link" onclick="transStorageInvoice('+this.id+')" data-toggle="modal" data-target="#transModal"><span class="flaticon-add"></sapn></button>';

     if(this.orders_status == 4){
       bg = 'success';
     }else if(this.orders_status == 6 || this.orders_status == 9 ){
       bg = 'danger';
     }else if(this.orders_status == 7){
       bg = 'warning';
     }else{
       bg = "";
     }
      $("#invoicesTable").append(
       '<tr class="'+bg+'">'+
            '<td></td>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.storage_name+'</td>'+
            '<td>'+this.in_date+'</td>'+
            '<td><a href="storage_invoice/'+this.path+'" target="_blank">تحميل ملف الكشف</a></td>'+
            '<td>'+
                btn+
                '<button type="button" class="btn btn-clean btn-link" onclick="deleteStorageInvoice('+this.id+')" data-toggle="modal" data-target="#deleteOrderModal"><span class="flaticon-delete"></sapn></button>'+
            '</td>'+
        '</tr>');
     });

     var myTable = $('#tb-invioces').DataTable({
      "oLanguage": {
        "sLengthMenu": "عرض_MENU_سجل",
        "sSearch": "بحث:"
      },

      });
     },
     error:function(e){
        console.log(e);
     }
   });
}
function transStorageInvoice(id){
   $('#storage_invoice_id').val(id);
}
function transToStorage(){
      $.ajax({
        url:"script/_transToStorage.php",
        type:"POST",
        data:$("#transForm").serialize(),
        success:function(res){
         if(res.success == 1){
           Toast.success('تم');
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
function deleteStorageInvoice(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deleteStorageInvoice.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
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
$( document ).ready(function(){
 getStorage($("#storage"));
 getStorage($("#storage_id"));
 getInvoices();
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
</script>