function getAllunAssignedTowns(elem){
   $.ajax({
     url:"script/_getAllunAssignedTowns.php",
     type:"POST",
     beforeSent:function(){

     },
     success:function(res){
       elem.html("");
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'>"+this.city+' - '+this.town+"</option>");
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