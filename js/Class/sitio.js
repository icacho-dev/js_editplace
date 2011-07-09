var Sitio = function(){

    this.deleteSitio=function(){
         $(".sitio .delete").livequery('click', function (e){

                                if(confirm('Seguro de Eliminar este registro?')){
                                    e.preventDefault();
                                     var parent =$(this).parents('li');
                                     
                                     $.ajax({
                                         type: 'post',
                                         url: 'lib/Sitio.php',
                                         data: {
                                             id:parent.attr('id').replace('record-',''),
                                             evento:'desactivateData'
                                         },
                                         success: function(request) {
                                             
                                             if(request == 1){
                                                 parent.slideUp(300,function() {
                                                     parent.remove();
                                                 });
                                             }else{
                                                 alert("no se pudo desactivar");
                                             }
                                         }

                                     });


                                }
                                });
                                
                                return null;
    }
    this.addSitio = function(){
      $("#create-sitio").button().livequery('click',function(){
        
        //$( "#dialog:ui-dialog" ).dialog( "destroy" );
       
        $("#dialog-form").dialog({
         autoOpen: false,
         title:'Add Sitio',
         width:'270px',
	 modal: true,
         buttons: {
				"Save": function() {
                                 $.ajax({
                                         type: 'post',
                                         url: 'lib/Sitio.php',
                                         data: {evento:'addData',
                                                titulo:$("#txttitulo").val(),
                                                icono:$("#txticono").val()},
                                         success: function(request) {
                                             
                                             $("#sortable_sitio").append("\
                                            <li  class=\"ui-state-default\" id=\"" + request + "\">" +
                                             $('#txttitulo').val() +
                                            "<div id='botones'> \n\
                                                <img src=\"img/btneditar.png\" alt='boton de editar' class='editar' \n\
                                                id='" + request + "'/>\n\
                                                <img id=" + request +  " class='delete' src='img/btneliminar.png' alt='boton de Desabilitar'/>\n\
                                            </div></li>");
                                             
                                             $( this ).dialog( "close" );

                                         }

                                     });       
                                      
                                       
				},
				"Close": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
                }
            );
                
        $("#dialog-form").dialog("open");
          
          
          
      });
      return null;    
      
    }
    
    this.updateSitio = function(){
        $(".sitio .editar").livequery('click',function(){
            //$( "#dialog:ui-dialog" ).dialog( "destroy" );

            var getid ="";
            getid=$(this).attr("id");
           
       
        $("#dialog-form").dialog({
         autoOpen: false,
         title:'Edit Sitio',
         width:'280px',
	 modal: true,
         open:function(){
             $("#frmsitio").hide();
             $("#loadAjax").show();
             $.ajax({
                                         type: 'post',
                                         url: 'lib/Sitio.php',
                                         data: {id:getid,evento:"getdata"},
                                         success: function(request) {
                                             var objRequest = eval("(" + request + ")");
                                             
                                             /*pasando datos al formulario*/
                                             $("#txttitulo").val(objRequest.titulo);
                                             $("#txticono").val(objRequest.icon)
                                             
                                             /*fin del pasado de data*/
                                             $("#loadAjax").hide();
                                             $("#frmsitio").show();
                                             }

                                     }); 
             
         },
         buttons: {
				"Update": function() {
                                 $.ajax({
                                         type: 'post',
                                         url: 'lib/Sitio.php',
                                         data: {
                                             id:getid,
                                             titulo:$("#txttitulo").val(),
                                                icono:$("#txticono").val(),
                                                evento:'updateData'},
                                            
                                         success: function(request) {
                                             alert(request);
                                           }

                                     });       
                                      
                                       
				},
				"Close": function() {
					$( this ).dialog( "destroy" );
				}
			},
	close: function() {
			$( this ).dialog( "destroy" );	
			}
                }
            );
                
      $("#dialog-form").dialog("open");
      });
      return null;
    }
    this.alertDiv=function(){
            $("#constructor div").livequery('click',function () {
          // this is the dom element clicked
          var proindex = $("div").index(this);
          var getid= $("div").eq(proindex).attr('id');
          this.divid=getid;


        });
      
    }
    this.orderSitio= function(){
        $('#sortable_sitio').sortable({
                                    update: function(event, ui) {
                                    var order = $('#sortable_sitio').sortable('toArray').toString();
                                    $.post('lib/Sitio.php', 
                                    {array_id:order,
                                        evento:'order'}
                                        );
                                    }
                                    
                                    
                                }); 
                                return null;
    }
    
    this.animationLoad= function(idshow,idhide){
        $(idshow).show();
        $(idhide).hide();
        
    }
    this.animationClose= function(idshow,idhide){
        $(idshow).hide();
        $(idhide).show();
    }
}






var objsitio;
$(document).ready(function(){
    
    $('#tabs-config').bind('tabsload', function(event, ui) {
                                if (ui.tab.id == "sitios") {
                                  objsitio = new Sitio();  
                                  objsitio.orderSitio();
                                  objsitio.addSitio();
                                  objsitio.updateSitio();
                                  objsitio.deleteSitio();

                                }else{
                                  objsitio =null;  
                                }
                            });
    
   
});

