var Tools = function(){
    this.getID= function(){
         objeto = $(objeto).index(this);

      alert('hola' + index);
    }
    this.getIDUnique = function(){
        var dt=new Date();
        dt =dt.getFullYear()+""+
                dt.getMonth()+""+
                dt.getDate()+""+
                dt.getHours()+""+
                dt.getMinutes()+""+
                dt.getSeconds() + "" +
                dt.getMilliseconds();
      
//        var num = Math.random();
//        var rnd = Math.round(num*100000);
       return dt;
    }
}


function getPageCurrent(){
    var loc = window.location;
    var namePage = loc.pathname.substring(loc.pathname.lastIndexOf('/')+1);

    switch (namePage) {
        case "":
            namePage="home";
            break;
        
    }
    return namePage;
}


