$(function () {
    $(".btn-info'").click(function(e){
        var idClicked = e.target.id;
    })


    $('#mainNav > .icon').on('click',function() {
        var x = $('#mainNav');
        if(x.hasClass("responsive")){
            x.removeClass("responsive");
            return;
        }

        if (x.hasClass("topNav")){
            x.addClass("responsive");
        
            return;
        }
           
        
    });



})