function openNav(){
    document.getElementById("mySidenav").style.width="200px";
    document.getElementById("main").style.marginLeft="200px";
    $("#opennav").hide();
    $("#closenav").show();
    $("body").css("overflow","hidden");
    $("body").css("position","relative");
}
function closeNav(){
    $('#mySidenav').attr('style','');
    $('#main').attr('style','');
    $('html').attr('style','');
    $('body').attr('style','');
    $("#closenav").hide();
    $("#opennav").show();
}
