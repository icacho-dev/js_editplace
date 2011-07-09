
var LayoutPages = function(){
    
    var objpropiedades=TAFFY([]);
    var div;
    var objeditorcss;//variable de la clase EditorCSS
    var objtools;
    
    
    
    LayoutPages.prototype.addDiv= function(objeto){
        
       
                        var htm =   "";
                        var uid = objtools.getIDUnique();
                        var objclass = $(objeto).attr("class");
                                           
			htm = "<div rel='draggable' class='"+ objclass +"'  id='item_"+ uid +"'>\n\
                            <img id='item_"+ uid +"' src='img/btneditar.png' class='propiedades' rel='item_"+ uid +"' /> \n\
                            <img src='img/handle.png' class='handle' /> \n\
                            <img id='item_"+ uid +"' src='img/btneliminar.png' class='eliminar' rel='item_"+ uid +"' />\n\
                        </div>";

                        //agregando a json
                            objpropiedades.insert({
                                 proid:"item_" + uid  ,
                                 prostyle:'',
                                 proclass:objclass,
                                 promodulo:''
                            });
                        //fin de json
                        
//                        if(div == null){
//                        
//                          $("#constructor").append(htm);
//                        }else{
                          div.append(htm);  
//                        }
			
                        
                        return null;
                        
			
    }
    
    LayoutPages.prototype.eliminarDiv = function(){


//                               var proindex = $("div").index($(this).parents('div'));
//                                var getid= $("div").eq(proindex).attr('id');
//                                
//                                $("#"+$(this).attr("rel")).remove();
                                div.remove();
                                /*deleting of json*/
                                    objpropiedades.remove({proid:div.attr("id")
            });
                                /*ending json*/
                                
    }
    
    LayoutPages.prototype.guardarData= function(){
        $("#guardar").click(function ()
		 	{
                        //variables
			var order = $('#constructor').sortable('toArray').toString();
                        var namePage = getPageCurrent();
                        // fin de variables
                            $.ajax({
                            type:      		"post",
                            url:		"lib/savezonas.php",
                            data:    {propiedades: objpropiedades.stringify(),
                                        order:order,
                                        pagina:namePage
                            },
                            success:	function(){
                                alert("enviado correctamente");
                            }
                            });
			

			});
    }
     LayoutPages.prototype.clearDiv=function(){
         div="";
     }
    LayoutPages.prototype.setDiv=function(objeto){
            
//          var proindex = $("div").index(objeto);
//          var getid= $("div").eq(proindex).attr('id');
          //alert(objeto.attr("id"));
          div  = objeto;
 
   
    }
    
    LayoutPages.prototype.dialogProperties=function(){
        // variables
            var txtmodulo = $("#frm-layout #modulo") ;
            var txtcss  =   $("#frm-layout #txtcss");
       // fin de variables
            
           
           
           $( "#dialog:ui-dialog" ).dialog( "destroy" );

            $("#dialog-modal").dialog({
             autoOpen: false,
             title:'DIV ID =' + div.attr("id"),
             width:'400px',
             modal: true,
             open: function(event, ui){

                         var getProperties = objpropiedades.get({
                                proid:div.attr("id")
                            });
                            if(getProperties!=""){
                                if(getProperties[0].promodulo!=""){
                                   txtmodulo.val(getProperties[0].promodulo); 
                                }
                                else{
                                    txtmodulo.val("");
                                }
                                if(getProperties[0].prostyle!=""){
                                   txtcss.val(getProperties[0].prostyle); 
                                }else{
                                    txtcss.val("");
                                }  
                            }
                                

             },
             buttons: {
                                    "Save": function() {

                                            div.attr({
                                                style:txtcss.val()
                                            });    

                                           //actualizando Json
                                           objpropiedades.update({prostyle: txtcss.val(),
                                                                 promodulo: txtmodulo.val()},
                                                                {proid: div.attr("id")});
                                           // fin de json
                                           $( this ).dialog( "close" );
                                    },
                                    "Close": function() {
                                            $( this ).dialog( "close" );
                                    }
                            },
                            close: function() {

                            }
            }
        );
        $("#dialog-modal").dialog("open");    
      
    }
    

    
    LayoutPages.prototype.checkDivConstructor    =   function(){
        objpropiedades.remove();
    var numeroid=$("#constructor div").length;
    
    if (numeroid > 0){
        
        var namePage = getPageCurrent();
        
        $.get("lib/getzona.php", {pagina:namePage},
               function(request){
                        var objRequest = eval("(" + request + ")");
                        var i = 0;
                        var size = objRequest.length;
                        for (i = 0; i < size; i++){
                            objpropiedades.insert({
                                         proid:objRequest[i]['id']  ,
                                         prostyle:objRequest[i]['css'],
                                         proclass:objRequest[i]['class'],
                                         promodulo:objRequest[i]['id_modulo']
                             });
                        }
                        
                    
               });


    }else{
        objpropiedades.remove();
    }
    
    }
    
    LayoutPages.prototype.init=function(){
        
        objtools = new Tools()
        objeditorcss = new EditorCSS($("#frm-layout #txtcss"));
        div =   $("#constructor"); //pasando los valores
         /*funcion del editorCSS*/
         objeditorcss.css_field.bind("keyup",function(event) { 
             
                 
                 if(objeditorcss.css_field.val().substr(objeditorcss.css_field.val().length - 1, 1) == ';' || 
                 objeditorcss.css_field.val().length == 0) {
                   
                     if(div != ""){
                            
                          objeditorcss.setCSS(div);
                     }
                 }
             
             
         }); 
           /*fin del editorCSS*/
         
             
             
        $( "#div-tipo" ).buttonset();
        $("#constructor").sortable({handle : '.handle'});
        $("#constructor").selectable();
        $("#constructor .handle,#constructor .propiedades").disableSelection();
        
    }
    
    LayoutPages.prototype.loadLayoutPage=function(){
        $("#cmb-page").bind('change',function(){
            
      
        var page = $("#cmb-page");
        
        var htm ="";
          
         
         $.get("lib/getzona.php", {
             idpagina:page.val()
         },
               function(request){
                   if(request != ""){
                       //limpiando componentes
                        objpropiedades.remove();//removiendo el json
                        $("#constructor").html("");
                        //fin de limpieza
                       
                        var uid="";
                        
                        var objRequest = eval("(" + request + ")");
                        
                        var i = 0;
                        
                        var size = objRequest.length;
                        
                        for (i = 0; i < size; i++){
                            
                            uid = objtools.getIDUnique();
                            
                            objpropiedades.insert({
                                         proid:uid,
                                         prostyle:objRequest[i]['css'],
                                         proclass:objRequest[i]['class'],
                                         promodulo:objRequest[i]['id_modulo']
                             });
                             
                             htm = "<div rel='draggable' \n\
                                          class='"+ objRequest[i]['class'] +"' \n\
                                          id='"+ uid +"'\n\
                                          style='" + objRequest[i]['css'] + "'>\n\
                            <img id='"+ uid +"' src='img/btneditar.png' class='propiedades' /> \n\
                            <img src='img/handle.png' class='handle' /> \n\
                            <img id='"+ uid +"' src='img/btneliminar.png' class='eliminar' rel='"+uid +"' />\n\
                            </div>";
                             $("#constructor").append(htm);
                             htm="";
                        } 
                   }
                   
                        
                        
                    
               });
    });
    }
}

var objlayoutPage;
$(document).ready(function(){
     $('#tabs-config').bind('tabsload', function(event, ui) {
                                if (ui.tab.id == 'layout-web') {
                                                                            
                                   
                                    objlayoutPage = new LayoutPages();
                                    objlayoutPage.init();
                                   
                                    objlayoutPage.guardarData();
                                    objlayoutPage.checkDivConstructor();
                                    
                                    objlayoutPage.loadLayoutPage();
                                    
                                     /*eventos*/
                                      $(".eliminar").livequery('click', function (){
                                          alert("click en eliminar");
                                            objlayoutPage.setDiv($(this));
                                            objlayoutPage.eliminarDiv();
                                            });
                                            
                                            
                                    $("#constructor div").livequery('click',function () {
                                        
                                        objlayoutPage.setDiv($(this)); 
                                     }
                                     );
                                     
                                     
                                     $("div .propiedades").livequery('click',function(){
                                       objlayoutPage.setDiv($(this));   
                                       objlayoutPage.dialogProperties();  
                                     });
                                     
                                     $( "#constructor" ).bind( "selectableunselected", function(event, ui) {
                                         objlayoutPage.clearDiv();
                                     });
                                     
                                      $("#grid12-content div").bind("click",function (){
                                          objlayoutPage.addDiv($(this));
                                        });
                                     
                                    /*fin de eventos*/
                                    

                                        


                                }
                            });
     
});