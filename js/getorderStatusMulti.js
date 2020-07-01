function getorderStatus(elem,add = 0){
$.ajax({
  url:"script/_getorderStatus.php",
  type:"POST",
  success:function(res){
   console.log(res);
   elem.html("");
   if(add){
     elem.append(
       '<option style="" value="">-- اختر الحالة --</option>'
     );
   }
   $.each(res.data,function(){
     bg ="";
     if(this.id == 4){
       bg ="#9CDE7C";
     }else if(this.id == 5){
       bg ="#FFFFAC";
     }else if(this.id == 9){
       bg ="#F2A69B";
     }else if(this.id == 4){
       bg ="";
     }else if(this.id == 4){
       bg ="";
     }
     elem.append(
       '<option style="background-color:'+bg+'" value="'+this.id+'">'+this.status +'</option>'
     );
     if(elem.attr('st') == 'st'){
       getorders();
     }
    });
    elem.selectpicker('refresh');
    },
   error:function(e){
    console.log(e);
  }
});
}
