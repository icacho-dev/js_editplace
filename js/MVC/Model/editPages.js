 var Pages = function(){
     this.orderWeb=function(){
        $('#sortable').sortable({
                                    update: function(event, ui) {
                                    var order = $('#sortable').sortable('toArray').toString();
                                    $.get('lib/order-web.php', {order:order}
                                        );
                                    }
                                    
                                    
                                }); 
                                return null;
     }
     
     this.deleteWeb=function(){
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
     this.init=function(){
        
            alert("hola");
     }
 }
 
 

