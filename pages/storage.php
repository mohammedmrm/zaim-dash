<?php
if(file_exists("script/_access.php")){
  require_once("script/_access.php");
  access([1,3]);
}
?>
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__toolbar">
            <div class="kt-subheader__wrapper">
                <div class="dropdown dropdown-inline" data-toggle="kt-tooltip" title="Quick actions" data-placement="top">
                    <span>اضافة مخزن</span>
                    <a data-toggle="modal" data-target="#addstorageModal" class="btn btn-icon btn btn-label btn-label-brand btn-bold" data-toggle="dropdown" data-offset="0px,0px" aria-haspopup="true" aria-expanded="false">
                        <i class="flaticon2-add-1"></i>

                    </a>
                </div>
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
				المخازن
			</h3>
		</div>
	</div>

	<div class="kt-portlet__body">
		<!--begin: Datatable -->
		<table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap" id="tb-storage">
			       <thead>
	  						<tr>
										<th>ID</th>
										<th>اسم المخزن</th>
										<th>الفرع</th>
							</tr>
      	            </thead>
                    <tbody id="storageTable">
                    </tbody>
		</table>
		<!--end: Datatable -->
	</div>
</div>
</div>
<!-- end:: Content -->
</div>


<!--begin::Page Vendors(used by this page) -->
<script src="assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<!--end::Page Vendors -->
<!--begin::Page Scripts(used by this page) -->
<script src="assets/js/demo1/pages/components/datatables/extensions/responsive.js" type="text/javascript"></script>
<script src="js/getAllunAssignedTownsTostorage.js" type="text/javascript"></script>
<script src="js/getAllunAssignedCitiesTostorage.js" type="text/javascript"></script>
<script type="text/javascript">
function getStorage(elem){
$.ajax({
  url:"script/_getStorage.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
   $.each(res.data,function(){
     elem.append(
       '<tr>'+
            '<td>'+this.id+'</td>'+
            '<td>'+this.name+'</td>'+
            '<td>'+this.branch_name+'</td>'+
       '</tr>');
     });
     $("#tb-storage").DataTable().destroy()
     var myTable= $('#tb-storage').DataTable();
    },
   error:function(e){
    console.log(e);
  }
});
}
getStorage($("#storageTable"));
</script>
<div class="modal fade" id="addstorageModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">اضافة مخزن</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="addstorageForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>الفرع</label>
						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="storage_branch" id="storage_branch"  value="">
                        </select>
                        <span class="form-text text-danger" id="storage_branch_err"></span>
					</div>
					<div class="form-group">
						<label>الاسم:</label>
						<input type="name" name="storage_name" class="form-control"  placeholder="">
						<span class="form-text  text-danger" id="storage_name_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="addstorage()" class="btn btn-brand">اضافة</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>

<div class="modal fade" id="editstorageModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">تعديل المخزن</h4>
        </div>
        <div class="modal-body">
		<!--begin::Portlet-->
		<div class="kt-portlet">

			<!--begin::Form-->
			<form class="kt-form" id="editstorageForm">
				<div class="kt-portlet__body">
					<div class="form-group">
						<label>الفرع</label>
						<select data-show-subtext="true" data-live-search="true" type="text" class="selectpicker form-control dropdown-primary" name="e_storage_branch" id="e_storage_branch"  value="">
                        </select>
                        <span class="form-text text-danger" id="e_storage_branch_err"></span>
					</div>
					<div class="form-group">
						<label>الاسم:</label>
						<input type="name" id="e_storage_name" name="e_storage_name" class="form-control"  placeholder="ادخل الاسم الكامل">
						<span class="form-text  text-danger" id="e_storage_name_err"></span>
					</div>
	            </div>
	            <div class="kt-portlet__foot kt-portlet__foot--solid">
					<div class="kt-form__actions kt-form__actions--right">
						<button type="button" onclick="updatestorage()" class="btn btn-brand">حفظ التغيرات</button>
						<button type="reset" data-dismiss="modal" class="btn btn-secondary">الغاء</button>
					</div>
				</div>
                <input type="hidden" name="e_storage_id" id="editstorageid"/>
			</form>
			<!--end::Form-->
		</div>
		<!--end::Portlet-->
        </div>
      </div>

    </div>
  </div>

<script type="text/javascript" src="js/getBraches.js"></script>
<script>
getBraches($("#storage_branch"));
function addstorage(){
  $.ajax({
    url:"script/_addstorage.php",
    type:"POST",
    data:$("#addstorageForm").serialize(),
    beforeSend:function(){

    },
    success:function(res){
       if(res.success == 1){
         $("#kt_form input").val("");
         Toast.success('تم الاضافة');
         getbraches($("#storageTable"));
       }else{
           $("#storage_name_err").text(res.error["storage_name_err"]);
           $("#storage_branch_err").text(res.error["storage_branch_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
      console.log(res);
    },
    error:function(e){
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
function editstorage(id){
  $("#editstorageid").val(id);
  getCities($("#e_storage_city"));
  getManagers($("#e_storage_manager"));
  $.ajax({
    url:"script/_getstorage1.php",
    data:{id: id},
    success:function(res){
      if(res.success == 1){
        $.each(res.data,function(){
          $('#e_storage_name').val(this.name);
          $('#e_storage_branch').selectpicker('val', this.city_id);
          $(".selectpicker").selectpicker("refresh");
        });
      }
      console.log(res);
    },
    error:function(e){
      console.log(e);
    }
  });
}
function updatestorage(){
    $.ajax({
       url:"script/_updatestorage.php",
       type:"POST",
       data:$("#editstorageForm").serialize(),
       beforeSend:function(){

       },
       success:function(res){
       if(res.success == 1){
         $("#kt_form input").val("");
          Toast.success('تم التحديث');
          getbraches($("#storageTable"));
       }else{
           $("#e_storage_name_err").text(res.error["storage_name_err"]);
           $("#e_storage_email_err").text(res.error["storage_email_err"]);
           $("#e_storage_phone_err").text(res.error["storage_phone_err"]);
           $("#e_storage_manager_err").text(res.error["storage_manager_err"]);
           $("#e_storage_city_err").text(res.error["storage_city_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
        console.log(res);
       },
       error:function(e){
        Toast.error('خطأ');
        console.log(e);
       }
    })
}
function deletestorage(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deletestorage.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getbraches($("#storageTable"));
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

$("#tb-storageTown").DataTable();
function getstorageTowns(id){
      $('#storage_id').val(id);
      $.ajax({
        url:"script/_getstorageTowns.php",
        type:"POST",
        data:{id:id},
        beforeSend:function(){
          $("#tb-storageTown").DataTable().destroy();
        },
        success:function(res){
         if(res.success == 1){
          $('#storageTown').html("");
          $('#storage_name').text(res.storage_info.name);

          $.each(res.data,function(){
            $('#storageTown').append(
            '<tr>'+
              '<td>'+this.id+'</td>'+
              '<td>'+this.city_name+'</td>'+
              '<td>'+this.town_name+'</td>'+
              '<td><button type="button" onclick="deletestorageTown('+this.id+')" class="btn btn-icon btn-danger"><span class="flaticon-delete"></span></button></td>'+
            '</tr>'
            );
          });
          $("#tb-driverTown").DataTable();
         }else{

         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
}
function setTownTostorage(){
      $.ajax({
        url:"script/_setTownTostorage.php",
        type:"POST",
        data:$("#storageTownsForm").serialize(),
        beforeSend:function(){
          $("#driverTownsForm").addClass("loading");
        },
        success:function(res){
        $("#storageTownsForm").removeClass("loading");
         if(res.success == 1){
           Toast.success(res.msg);
           getstorageTowns($('#storage_id').val());
           getAllunAssignedTownsTostorage($("#town"));
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          $("#storageTownsForm").removeClass("loading");
          console.log(e);
        }
      });
}
function deletestorageTown(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deletestorageTown.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getstorageTowns($('#storage_id').val());
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
getAllunAssignedTownsTostorage($("#town"));

$("#tb-storageCity").DataTable();
function getstorageCities(id){
      $('#c_storage_id').val(id);
      $.ajax({
        url:"script/_getstorageCities.php",
        type:"POST",
        data:{id:id},
        beforeSend:function(){
          $("#tb-storageCity").DataTable().destroy();
        },
        success:function(res){
         if(res.success == 1){
          $('#storageCity').html("");
          $('#c_storage_name').text(res.storage_info.name);

          $.each(res.data,function(){
            $('#storageCity').append(
            '<tr>'+
              '<td>'+this.id+'</td>'+
              '<td>'+this.city_name+'</td>'+
              '<td><button type="button" onclick="deletestorageCity('+this.id+')" class="btn btn-icon btn-danger"><span class="flaticon-delete"></span></button></td>'+
            '</tr>'
            );
          });
          $("#tb-driverCity").DataTable();
         }else{

         }
         console.log(res)
        } ,
        error:function(e){
          console.log(e);
        }
      });
}
function setCityTostorage(){
      $.ajax({
        url:"script/_setCityTostorage.php",
        type:"POST",
        data:$("#storageCitiesForm").serialize(),
        beforeSend:function(){
          $("#driverCitiesForm").addClass("loading");
        },
        success:function(res){
        $("#storageCitiesForm").removeClass("loading");
         if(res.success == 1){
           Toast.success(res.msg);
           getstorageCities($('#c_storage_id').val());
           getAllunAssignedCitiesTostorage($("#city"));
         }else{
           Toast.warning(res.msg);
         }
         console.log(res)
        } ,
        error:function(e){
          $("#storageCitiesForm").removeClass("loading");
          console.log(e);
        }
      });
}
function deletestorageCity(id){
  if(confirm("هل انت متاكد من الحذف")){
      $.ajax({
        url:"script/_deletestorageCity.php",
        type:"POST",
        data:{id:id},
        success:function(res){
         if(res.success == 1){
           Toast.success('تم الحذف');
           getstorageCities($('#c_storage_id').val());
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
getAllunAssignedCitiesTostorage($("#city"));
</script>