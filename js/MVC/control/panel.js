$(document).ready(function(){
      $('#tabs-config').bind('tabsload', function(event, ui) {
                            
                            if (ui.tab.id == 'editar-web') {
                                var editPage = new Pages();
                                editPage.orderWeb();
                                editPage.deleteWeb();
                                }
                                
                            if (ui.tab.id == 'sitios') {
                                var objsitio = new Sitio();
                                objsitio.setSortable();
                                objsitio.addSitio();
                                objsitio.editSitio();
                                
                                }
                             if(ui.tab.id=='modificar-clave'){
                                 var objchangeclave = new Changes_claves();
                                     objchangeclave.change_clave();
                            }
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
                          }

                         );
     
 });


