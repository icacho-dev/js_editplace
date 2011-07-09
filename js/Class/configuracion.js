var Configuracion = function(){
    this.updateData = function(){
        $("#frm-configuracion #send").livequery("click",function(event){
            event.preventDefault();
            
            alert($("#frm-configuracion").attr("id"));
            alert($("#frm-configuracion").serialize());
        })
    }
}

var objconfig  = new Configuracion();


$(document).ready(function(){
    $('#tabs-config').bind('tabsload', function(event, ui) {
                                if (ui.tab.id == "configuracion") {
                                  objconfig.updateData();

                                }
                            });
   
});


