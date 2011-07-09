var Sitio = function(){
    this.eliminarDiv=function(){
         $(".eliminar").livequery('click', function ()
                                {

         alert("esta es una ventana de alerta");
                              
                                });
        return null;
    }
    
    this.setSortable= function(){
        $("#sortable").sortable();
        return null;
    }
    
    this.alertDiv=function(){
       return null;
        
    }
    this.init = function(){
        alert("esta es una ventana de alerta");
        return null;
        
    }
    this.addSitio = function(){
        $("#sitio #sortable #botones .agregar").livequery("click",function(){
            alert("agregar");
        });
        return null;
    }
    this.editSitio =function(){
        $("#sitio #sortable #botones .editar").livequery("click",function(){
            alert("EDITAR");
        });
        return null;
        
    }
}

