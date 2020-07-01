function getBraches(elem,choose = 1){
$.ajax({
  url:"script/_getBranches.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
   if(choose){
     elem.append(
       '<option value="">... اختر فرع ...</option>'
     );
    }
   $.each(res.data,function(){
     elem.append(
       '<option value="'+this.id+'">'+this.name +'</option>'
     );
     elem.selectpicker('refresh');
   });
  },
  error:function(e){
    console.log(e);
  }
});
}