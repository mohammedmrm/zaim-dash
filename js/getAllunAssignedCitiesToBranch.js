function getAllunAssignedCitiesToBranch(elem){
   $.ajax({
     url:"script/_getAllunAssignedCitiesToBranch.php",
     type:"POST",
     beforeSent:function(){

     },
     success:function(res){
       elem.html("");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.name+"</option>");
       });
       elem.selectpicker('refresh');
       console.log(res);
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>خطا</option>");
        console.log(e);
     }
   });
}