function getStores(elem,client){
   $.ajax({
     url:"script/_getStores.php",
     type:"POST",
     data:{client: client},
     success:function(res){
       elem.html("");
       elem.append(
           '<option value="">... اختر ...</option>'
       );
       $.each(res.data,function(){
         elem.append("<option value='"+this.id+"'><b>"+this.name+"</b>-"+this.client_name+"</option>");
       });
       console.log(res);
       elem.selectpicker('refresh');
     },
     error:function(e){
        elem.append("<option value='' class='bg-danger'>Error</option>");
        console.log(e);
     }
   });
}