var EditorCSS= function(xcss_field){
   this.css_field=xcss_field;
    
    
    this.setCSS= function(selector_field){

                selector_field.attr({ 
                  style: this.css_field.val()
                });
  
    }
    
}