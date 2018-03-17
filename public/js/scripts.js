$(function () {
    function showCookie(name) {
        if (document.cookie != "") {
            const cookies = document.cookie.split(/; */);
    
            for (let i=0; i<cookies.length; i++) {
                const cookieName = cookies[i].split("=")[0];
                const cookieVal = cookies[i].split("=")[1];
                if (cookieName === decodeURIComponent(name)) {
                    return decodeURIComponent(cookieVal);
                }
            }
        }
    }
    $('#mainNav > .icon').on('click', function () {
        var x = $('#mainNav');
        if (x.hasClass("responsive")) {
            x.removeClass("responsive");
            return;
        }

        if (x.hasClass("topNav")) {
            x.addClass("responsive");

            return;
        }


    });


    $('.link').on('click', function () {
        window.prompt("Copy to clipboard: Ctrl+C, Enter", $(this).val());

    });
    
$('.fa').on('click', function () {
    console.log("{{Auth::id()}}");
    let parentID = $(this).parent().attr('class');
    let parent = $(this).parent();
    let starID = $(this).val();
    let stars = $(this).parent().children();
    for (let i = stars.length; i >= starID; i--) {
        $(stars[i]).removeClass('checked');
    }
    for (let i = 0; i < starID; i++) {
        $(stars[i]).addClass('checked');
    }
    let us_id = showCookie('user_id');
    let token = $('meta[name="csrf_token"]').attr('content');

    var rate = {
        picture_rate: starID,
        picture_id: parentID,
        user_id: us_id,
        is_active: true
    }
    console.log(window.location.href);
   let url = window.location.href;
    console.log(url);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: (url+'/store_rating'),
        type: "post", //typ połączenia
        contentType: 'aplication/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'json', //typ danych jakich oczekujemy w odpowiedzi
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: JSON.stringify(rate),
    }).done(function (response) {
        $('.container').prepend(response);
        $('.alert').first().hide();

        $('.alert').first().slideDown(2000).delay(2000).slideUp(2000);
        $('alert').first().remove();


    })



});


$('#find-button').on('click', function () {
    let us_id = showCookie('user_id');
    let token = $('meta[name="csrf_token"]').attr('content');
    const text = $('.main-search').val();
    var picture_to_find = {

        user_id: us_id,
        title:text
    }
    console.log(window.location.href);
   let url = window.location.href;
    console.log(url);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: (url+'/find_pictures'),
        type: "post", //typ połączenia
        contentType: 'aplication/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'json', //typ danych jakich oczekujemy w odpowiedzi
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: JSON.stringify(picture_to_find),
    }).done(function (response) {
        console.log(response.length);
        $('.rowPictures').remove();
        var $i=0;
        response.forEach(picture => {;
            
            var $x= "<div class='row rowPictures'><div class='col-md-1 col-lg-1'></div></div>";
            if ($i==0 || $i % 3 ==0)
            {
            $('.container').append($x);
                console.log("III");
            }
            const $post = $(`
            <div class="col-md-3 col-sm-3 picture p2">


            <div class="row">
                <div class="col-md-12 col-sm-12">
                ${picture.title}
                </div>
            </div>
        
        
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <a href="http://localhost/web/image_hosting/public/pictures/${picture.id}">
                        <img class="img-thumbnail picture-icon" src="http://localhost/web/image_hosting/public/${picture.source}">
                    </a>
                </div>
            </div>
        
        
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <span> ${picture.description} </span>
                </div>
                <br>
        
        
            </div>
            <div class="card-footer author">
                Added by:
                <b>
                    <a class="author-link" href="user/${picture.user.id}">${picture.user.name}</a>
                </b>
                <div class="div-comments">
                                    <span class="image-comments">Average rating: <b>0 </b></span> <br>
                    <a href="pictures/${picture.id}">
                        <img style="margin-left:5px" src="../css/img/speech-message.png" placeholder="comments">
                        <span class="image-comments">Comments: ${picture.comment.length}</span> <br>
                        </a>
                        <br>
                </div>
            </div>

        </div>
            `);
            $i++;
            $('.rowPictures').last().append($post);
            $('.rowPictures').last().children('.p2').css('display','none');

        });
        console.log($('.p2'));
        $('.p2').each(function(i){
            console.log("EEE"+$(this));
            $( this ).delay(400*i).fadeIn(3000);
        })
       
    });



});




$('#find-button-alb').on('click', function () {
    let us_id = showCookie('user_id');
    let token = $('meta[name="csrf_token"]').attr('content');
    const text = $('.main-search').val();
    var picture_to_find = {

        user_id: us_id,
        title:text
    }
    console.log(window.location.href);
   let url = window.location.href;
    console.log(url);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: (url+'/find_albums'),
        type: "post", //typ połączenia
        contentType: 'aplication/json', //gdy wysyłamy dane czasami chcemy ustawić ich typ
        dataType: 'json', //typ danych jakich oczekujemy w odpowiedzi
        beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data: JSON.stringify(picture_to_find),
    }).done(function (response) {
        console.log(response.length);
        $('.rowPictures').remove();
        var $i=0;
        response.forEach(picture => {;
            
            var $x= "<div class='row rowPictures'><div class='col-md-1 col-lg-1'></div> </div>";
            if ($i==0 || $i % 3 ==0)
            {
            $('.container').append($x);
                console.log("III");
            }
            const $post = $(`
            <div class="col-md-3 col-sm-3 picture p2">


            <div class="row">
                <div class="col-md-12 col-sm-12">
                ${picture.title}
                </div>
            </div>
        
        
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <a href="http://localhost/web/image_hosting/public/pictures/${picture.id}">
                        <img class="img-thumbnail picture-icon" src="http://localhost/web/image_hosting/public/${picture.source}">
                    </a>
                </div>
            </div>
        
        
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <span> ${picture.description} </span>
                </div>
                <br>
        
        
            </div>
            <div class="card-footer author">
                Added by:
                <b>
                    <a class="author-link" href="user/${picture.user.id}">${picture.user.name}</a>
                </b>
                <div class="div-comments">
                                    <span class="image-comments">Average rating: <b>0 </b></span> <br>
                    <a href="pictures/${picture.id}">
                        <img style="margin-left:5px" src="../resources/img/speech-message.png" placeholder="comments">
                        <span class="image-comments">Comments: ${picture.comment.length}</span> <br>
                        </a>
                </div>
            </div>

        </div>
            `);
            $i++;
            $('.rowPictures').last().append($post);
            $('.rowPictures').last().children('.p2').css('display','none');

        });
        console.log($('.p2'));
        $('.p2').each(function(i){
            console.log("EEE"+$(this));
            $( this ).delay(400*i).fadeIn(3000);
        })
       
    });



});




    $('.admin-div').on('mouseenter', function () {

        $(this).next().children().slideDown(500).css('display', 'block');

    })

    $('.menuOl').on('mouseleave', function () {

        $(this).children().slideUp(500);

    })

    var NavY = $('#mainNav').offset().top;
    var stickyNav = function () {
        var ScrollY = $(window).scrollTop();

        if (ScrollY >= NavY) {
            $('#mainNav').addClass('sticky');
        } else {
            $('#mainNav').removeClass('sticky');
        }
    };

    stickyNav();

    $(window).scroll(function () {
        stickyNav();
    });

})