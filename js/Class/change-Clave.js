function changeClave(){
	
    $('#frm_change_clave #btn-change-clave').click(function(e){
                                    e.preventDefault();

                                   var clave1= $('#frm_change_clave #txtclave');
                                   var clave2= $('#frm_change_clave #txtnewclave');
                                   var clave3= $('#frm_change_clave #txtnewclave2');

                                    if(clave2 == clave3){
                                            $.ajax({
                                         type: 'post',
                                         url: 'lib/change-clave.php',
                                         data: {clave1:clave1.val(), 
                                             clave2:clave2.val(),
                                             clave3:clave3.val()},
                                         success: function(data) {
                                                alert(data);
                                             $('#mensaje').show();
                                             $('#mensaje').slideDown(300,function() {
                                                $('#mensaje').css('border', '1px solid red');
                                                $('#mensaje').css('background-color', '#ffff00');
                                                $('#mensaje').html(data);
                                                clave1.val('');
                                                clave2.val('');
                                                clave3.val('');

                                             });
                                         }

                                     });
                                     }else{
                                            alert('favor de colocar la misma clave');
                                                }
                                });
}

$(document).ready(function(){
    $('#tabs-config').bind('tabsload', function(event, ui) {
                            if(ui.tab.id=='modificar-clave'){
                                changeClave();
                            }
    });
});



