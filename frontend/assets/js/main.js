function amigable1(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");

    for (var i=0;i<url.length;i++) {
        var aux = url[i].split("=");
        link +=  "/"+aux[1];
    }
    return link;
}

function amigable(url) {
    var link="";
    url = url.replace("?", "");
    url = url.split("&");

    for (var i=0;i<url.length;i++) {
        var aux = url[i].split("=");
        link +=  "/"+aux[1];
    }
    return "http://localhost/repair_on_time" + link;
    //return "http://arevert.tk/repair_on_time" + link;
    // return "https://projects-alumnes-yomogan.c9users.io/proj_final_login/JoinElderly" + link;
}
