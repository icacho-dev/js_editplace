var Changes_claves = function(){
    this.change_clave = function(){
        $('#frm_change_clave #btn-change-clave').click(function(e){
                                    e.preventDefault();

                                   var clave1= $('#frm_change_clave #txtclave').val();
                                   var clave2= $('#frm_change_clave #txtnewclave').val();
                                   var clave3= $('#frm_change_clave #txtnewclave2').val();

                                    if(clave2 == clave3){
                                            $.ajax({
                                         type: 'post',
                                         url: 'lib/change-clave.php',
                                         data: 'clave1=' + clave1 + '&clave2='+ clave2 + '&clave3='+clave3,
                                         success: function(data) {
                                                alert(data);
                                             $('#mensaje').show();
                                             $('#mensaje').slideDown(300,function() {
                                                $('#mensaje').css('border', '1px solid red');
                                                $('#mensaje').css('background-color', '#ffff00');
                                                $('#mensaje').html(data);
                                                $('#frm_change_clave #txtclave').val('');
                                                $('#frm_change_clave #txtnewclave').val('');
                                                $('#frm_change_clave #txtnewclave2').val('');

                                             });
                                         }

                                     });
                                     }else{
                                            alert('favor de colocar la misma clave');
                                                }
                                });
    }
}


