<?php
if(file_exists("script/_access.php")){
  require_once("script/_access.php");
  access([1]);
}
?>
<style>
table.dataTable tr th.select-checkbox.selected::after {
    content: "✔";
    margin-top: -11px;
    margin-left: -4px;
    text-align: center;
    text-shadow: rgb(176, 190, 217) 1px 1px, rgb(176, 190, 217) -1px -1px, rgb(176, 190, 217) 1px -1px, rgb(176, 190, 217) -1px 1px;
}
</style>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
<!-- end:: Subheader -->
					<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
<div class="kt-portlet kt-portlet--mobile">
	<div class="kt-portlet__head">
		<div class="kt-portlet__head-label">
			<h3 class="kt-portlet__head-title">
				التحديث التلقائي
			</h3>
		</div>
	</div>
    <form id="autoUpdateForm">
	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-cities">
			       <thead>
	  						<tr>
	 							<th>ID</th>
								<th>المدينة</th>
								<th>بعد مضي</th>
								<th>الحالة</th>
                            </tr>
      	            </thead>
                            <tbody id="citiesTable">
                            </tbody>
		</table>
		<!--end: Datatable -->
	</div>
    <div class="kt-portlet__body">
      <input type="button" class="btn btn-info btn-lg" value="تحديث" onclick="update()" />
    </div>
    </form>
</div>
</div>
<!-- end:: Content -->
</div>


<!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script type="text/javascript">
function getcities(){
$.ajax({
  url:"script/_getCities.php", 
  type:"POST",
  data:{city: $("#city").val()},
  success:function(res){
   console.log(res);
   $("#tb-cities").DataTable().destroy();
   $("#citiesTable").html("");
    i=0;
    $.each(res.data,function(){
     if(this.active == 0){
       btn = '<button type="button" class="btn btn-success" onclick="active('+this.id+')">تنشيط</button>';
     }else{
       btn = '<button type="button" class="btn btn-warning" onclick="unactive('+this.id+')">الغا التنشيط</button>';
     }
     $("#citiesTable").append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.name+'</td>'+
            '<td>'+
                '<input name="config['+i+'][days]" type="number" class="form-control" value="'+this.days+'">'+
                '<input name="config['+i+'][city]" type="hidden" class="form-control" value="'+this.city_id+'">'+
            '</td>'+
            '<td>'+
                  btn+
             '</td>'+

       '</tr>');
       i++;
     });
     var myTable= $('#tb-cities').DataTable({
        className: 'select-checkbox',
        targets: 0,
        "oLanguage": {
        "sLengthMenu": "عرض _MENU_ سجل",
        "sSearch": "بحث:" ,
        select: {
        style: 'os',
        selector: 'td:first-child'
    }
      }
});
    },
   error:function(e){
    console.log(e);
  }
});
}
getcities();

function active(id){
  $.ajax({
    url:"script/_activeAutoUpdate.php",
    type:"POST",
    data:{id: id},
    beforeSend:function(){

    },
    success:function(res){
       console.log(res);
       if(res.success == 1){
         Toast.success('تم');
         getcities();
       }else{
        Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

    },
    error:function(e){
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
function unactive(id){
  $.ajax({
    url:"script/_unactiveAutoUpdate.php",
    type:"POST",
    data:{id: id},
    beforeSend:function(){

    },
    success:function(res){
       console.log(res);
       if(res.success == 1){
         Toast.success('تم');
         getcities();
       }else{
        Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

    },
    error:function(e){
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
function update(){
  $.ajax({
    url:"script/_setAutoUpdateDays.php",
    type:"POST",
    data:$('#autoUpdateForm').serialize(),
    beforeSend:function(){

    },
    success:function(res){
       console.log(res);
       if(res.success == 1){
         Toast.success('تم');
         getcities();
       }else{
        Toast.warning('خطأ');
       }

    },
    error:function(e){
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
</script>