 var Pages = function(){
     Pages.prototype.orderWeb=function(){
        $('#sortable').sortable({
                                    update: function(event, ui) {
                                    var order = $('#sortable').sortable('toArray').toString();
                                    $.get('lib/order-web.php', {order:order}
                                        );
                                    }
                                    
                                    
                                }); 
                                return null;
     }
     
     Pages.prototype.deleteWeb=function(){
       $('#sortable li #botones a.delete').click(function(e) {
                                 if(confirm('Seguro de Eliminar este registro?')){
                                    e.preventDefault();
                                     var parent =$(this).parents('li');
                                     

                                     $.ajax({
                                         type: 'get',
                                         url: 'lib/eliminar_web.php',
                                         data: 'id=' + parent.attr('id').replace('record-',''),
                                         success: function() {
                                             parent.slideUp(300,function() {
                                                 parent.remove();
                                             });
                                         }

                                     });


                                }
                                return null;
                                }

                            );                     
     }
     Pages.prototype.init=function(){
        
            alert("hola");
     }
 }
 
 

 var editPage = new Pages();
 
 $(document).ready(function(){
      $('#tabs-config').bind('tabsload', function(event, ui) {
                            if (ui.tab.id == 'editar-web') {
                                editPage.orderWeb();
                                editPage.deleteWeb();
                                }
                          }

                         );
     
 });



