$(function(){
    var activo=1;
    function doLoading($this){
        activo=1;
        $loading = $("<div class='loading'></div>").css("display","inline-block");
        $.ajaxSetup({
          beforeSend: function(){
              if(activo==1){
                $this.attr("disabled",true);	
                $this.after($loading);	 
                }
          },
          complete: function(){
                $this.attr("disabled",false);	
                $("div.loading").remove();	
                activo=0;
          }
        });
    }
    
    $("button,a").live("click",function(event){
        doLoading($(event.target));
    }); 
    
    $("select").live("change",function(event){
        doLoading($(event.target));
    }); 
});