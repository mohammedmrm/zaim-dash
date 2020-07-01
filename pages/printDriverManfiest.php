<?php
if(file_exists("script/_access.php")){
require_once("script/_access.php");
access([1,2,5]);
}
?>
<?
include_once("config.php");
?>
<!-- end:: Subheader -->
					<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h1 class="">
				منفيست المندوبين
			</h1>
		</div>
	</div>

	<div class="kt-portlet__body">
     <form id="genrateManifestForm">
		<!--begin: Datatable -->


          <fieldset><legend>فلتر</legend>
          <div class="row">
          <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
               <div class="form-group">
						<label>الفرع:</label>
						<select  onchange="genrateManifest()" id="branch" name="branch" class="form-control selectpicker"  data-show-subtext="true" data-live-search="true" ></select>
						<span class="form-text  text-danger" id="item_err"></span>
			   </div>
          </div>
            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile">
            <label>الفترة الزمنية :</label>
            <div class="input-daterange input-group" id="kt_datepicker">
  				<input value="<?php echo date('Y-m-d'); ?>" onchange="genrateManifest" type="text" class="form-control kt-input" name="start" id="start" placeholder="من" data-col-index="5">
  				<div class="input-group-append">
  					<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
  				</div>
  				<input  type="text" onchange="genrateManifest" class="form-control kt-input" name="end"  id="end" placeholder="الى" data-col-index="5">
          	</div>
            </div>
           </div>
          </fieldset>
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-manifest">
			       <thead>
	  						<tr>
								<th>المندوب</th>
							</tr>
      	            </thead>
                            <tbody id="manifestTable">
                            </tbody>
		</table>
        <div class="kt-section__content kt-section__content--border">
		<nav aria-label="...">
			<ul class="pagination" id="pagination">

			</ul>
        <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
		</nav>
     	</div>
        </form>
		<!--end: Datatable -->
	</div>
</div>
</div>
<!-- end:: Content -->


<!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->



<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getBraches.js" type="text/javascript"></script>
<script type="text/javascript">
getBraches($("#branch"),0);
function genrateManifest(){
      $.ajax({
        url:"script/_getAllDrivers.php",
        type:"POST",
        beforeSend:function(){
          $("#genrateManifestForm").addClass("loading");
        },
        data:$("#genrateManifestForm").serialize(),
        success:function(res){
         $("#genrateManifestForm").removeClass("loading");
         $("#tb-manifest").DataTable().destroy();
         $("#manifestTable").html("");
         if(res.success == 1){
            $.each(res.data,function(){
              $("#manifestTable").append(
              "<tr><td>"+
              '<a href="script/downloadOrdersReport.php?start='+$('#start').val()+'&end='+$('#end').val()+'&driver='+this.id+'"  target="_blank" title="تحميل المنفيست">'+this.name+'</a>'+
              "</td></tr>");
            })
         }else{
           Toast.warning(res.msg);
         }
         $("#tb-manifest").DataTable({
           "aLengthMenu": [25, 30, 50, 100],
         });
         console.log(res)
        } ,
        error:function(e){
          $("#genrateManifestForm").removeClass("loading");
          console.log(e);
        }
      });
}
genrateManifest();
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
<script>


</script>