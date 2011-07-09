
var LayoutPages = function(){
    this.objpropiedades=TAFFY([]);
    this.divid="";
    
    this.agregarDiv= function(){
        $("#grid12-content div").bind("click",function (){
                        var htm="";
                        if(this.divid == ""){
                          this.divid="constructor";
                        }
                       
			var objclass = $(this).attr("class");
			var fecha=new Date();
			fecha = fecha.getFullYear()+""+fecha.getMonth()+""+fecha.getDate()+""+fecha.getHours()+""+fecha.getMinutes()+""+fecha.getSeconds();
			htm = "<div rel='draggable' class='"+ objclass +"'  id='item_"+fecha+"'>\n\
                            <img src='img/btneditar.png' class='propiedades' /> \n\
                            <img src='img/handle.png' class='handle' /> \n\
                            <img src='img/btneliminar.png' class='eliminar' rel='item_"+fecha+"' />\n\
                        </div>";

                        //agregando a json
                            this.objpropiedades.insert({
                                 proid:"item_" + fecha  ,
                                 prostyle:'',
                                 proclass:objclass,
                                 promodulo:'',
                                 procontenido:''
                            });
                        //fin de json

                     
			$("#" + this.divid).append(htm);

			});
    }
    
    this.eliminarDiv = function(){
        $(".eliminar").livequery('click', function ()
                                {

                               var proindex = $("div").index($(this).parents('div'));
                                var getid= $("div").eq(proindex).attr('id');
                                
                                $("#"+$(this).attr("rel")).remove();
                                /*deleting of json*/
                                    this.objpropiedades.remove({proid:getid});
                                /*ending json*/
                                });
    }
    this.guardarData = function(){
        $("#guardar").click(function ()
		 	{
                        //variables
			var order = $('#constructor').sortable('toArray').toString();
                        var namePage = getPageCurrent();
                        // fin de variables
                            $.ajax({
                            type:      		"post",
                            url:		"lib/savezonas.php",
                            data:    {propiedades: this.objpropiedades.stringify(),
                                        order:order,
                                        pagina:namePage
                            },
                            success:	function(){
                                alert("enviado correctamente");
                            }
                            });
			

			});
    }
    this.alertDiv = function(){
        $("#constructor div").livequery('click',function () {
      // this is the dom element clicked
      var proindex = $("div").index(this);
      var getid= $("div").eq(proindex).attr('id');
      this.divid=getid;
      
     
    });

     $( "#constructor" ).bind( "selectableunselected", function(event, ui) {
         this.divid='constructor';
     });
    }
    this.dialogProperties = function(){
        $("div .propiedades").livequery('click',function(){
      
       //sacando el Id
       var proindex = $("div").index($(this).parents('div'));
       var getid= $("div").eq(proindex).attr('id');
       //fin del get ID
       // variables
        var txtheight= "";
        var txtmargin = "";
        var txtmodulo ="" ;
        var txttipo = "";
       // fin de variables
       $( "#dialog:ui-dialog" ).dialog( "destroy" );
       
        $("#dialog-modal").dialog({
         title:'DIV ID =' + getid,
         width:'270px',
	 modal: true,
         open: function(event, ui){
            

             // variables
            txtheight= $("#txtheight").val();
            txtmargin = $("#txtmargin").val();
            txtmodulo = $("#modulo").val();
            txttipo = $("input[name='optTipo']:checked").val();
             // fin de variables
             //var getProperties = objpropiedades.get({proid:getid});
             //tmptxtheight = getProperties[0].prostyle;
             //alert(tmptxtheight.split(";"));
             
         },
         buttons: {
				"Save": function() {
                                   
                                       var div_style="";
                                       var div_class ="";

                                        $("#" + getid).css('height', txtheight + 'px');
                                        $("#" + getid).css('margin', txtmargin );
                                        
                                        if(txttipo== "fijo"){
                                            $("#" + getid).css("overflow", "scroll");
                                         }else{
                                            $("#" + getid).css("overflow", "none");
                                         }

                                     
                                         
                                         div_style=$("#" + getid).attr("style");
                                         div_class =$("#" + getid).attr("class");

                                
                                       //siguiendo con json
                                       this.objpropiedades.update({prostyle: div_style,
                                                             proclass:  div_class,
                                                             promodulo: txtmodulo,
                                                             procontenido:'contenido'},
                                                            {proid: getid});
                                       // fin de json
                                      
                                       
				},
				"Close": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
	}
    );
   })
   
    }
  this.checkDivConstructor=function(){
     this.objpropiedades.remove();
    var numeroid=$("#constructor div").length;
    
    if (numeroid > 0){
        var namePage = getPageCurrent();
        
        $.get("lib/getzona.php", {pagina:namePage},
               function(request){
                        var objRequest = eval("(" + request + ")");
                        var i = 0;
                        var size = objRequest.length;
                        for (i = 0; i < size; i++){
                            this.objpropiedades.insert({
                                         proid:objRequest[i]['id']  ,
                                         prostyle:objRequest[i]['css'],
                                         proclass:objRequest[i]['class'],
                                         promodulo:objRequest[i]['id_modulo'],
                                         procontenido:objRequest[i]['contenido']
                             });
                        }
                        
                    
               });


    }else{
        this.objpropiedades.remove();
    } 
  }
  
  this.setStyle = function(){
      $( "#div-tipo" ).buttonset();
  }
  
  this.loadLayoutPage=function(){
      $("#cmb-page").livequery('change',function(){
        var page = $("#cmb-page").attr("value");
        var htm ="";
          
         
         $.get("lib/getzona.php", {idpagina:page},
               function(request){
                   if(request != ""){
                       //limpiando componentes
                        this.objpropiedades.remove();//removiendo el json
                        $("#constructor").html("");
                        //fin de limpieza
                        var objtools = new Tools();
                        var uid="";
                        var objRequest = eval("(" + request + ")");
                        var i = 0;
                        var size = objRequest.length;
                        for (i = 0; i < size; i++){
                            uid = objtools.getIDUnique();
                            this.objpropiedades.insert({
                                         proid:uid,
                                         prostyle:objRequest[i]['css'],
                                         proclass:objRequest[i]['class'],
                                         promodulo:objRequest[i]['id_modulo'],
                                         procontenido:objRequest[i]['contenido']
                             });
                             htm = "<div rel='draggable' \n\
                                          class='"+ objRequest[i]['class'] +"' \n\
                                          id='"+ uid +"'\n\
                                          style='" + objRequest[i]['css'] + "'>\n\
                            <img src='img/btneditar.png' class='propiedades' /> \n\
                            <img src='img/handle.png' class='handle' /> \n\
                            <img src='img/btneliminar.png' class='eliminar' rel='"+uid +"' />\n\
                            </div>";
                             $("#constructor").append(htm);
                             htm="";
                        } 
                   }
                   
                        
                        
                    
               });
    });
  }
}


		
function loadTabs(){
    
    $('#tabs-config').bind('tabsload', function(event, ui) {
                                if (ui.tab.id == 'layout-web') {
                                    //funcion para que sea muevan

                                    $("#constructor").sortable({
                                            handle : '.handle'
                                            });

                                    $("#constructor").selectable();
                                    $("#constructor .handle,#constructor").disableSelection();
                                        alertDiv();
                                        eliminarDiv();
                                        guardarData();
                                        dialogProperties();
                                        checkDivConstructor();
                                        agregarDiv();
                                        setStyle();
                                        loadLayoutPage();


                                }
                            });
}
