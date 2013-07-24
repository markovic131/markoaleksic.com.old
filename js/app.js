//Setup flex slider
// $(window).load(function () {
//     $('.gf-slider').flexslider();
// });
//Setup Page
$(function () {

    //Initialize PrettyPhoto here
	//Remove this line if you want to naviagate to url on each client box click
	//$('#clients.grid a').click(function(){return false;});
    //Initialize jQuery knob here
    //$(".knob").knob();
    //Initialie tipsy here
    // $('#fb').tipsy({ gravity: 'n', fade: true });
    // $('#tw').tipsy({ gravity: 'n', fade: true });
    // $('#ld').tipsy({ gravity: 'n', fade: true });
    /* smooth-scroll */
    $("ul#navigation a").smoothScroll({
        afterScroll: function () {
            $('ul#navigation a.active').removeClass('active');
            $(this).addClass('active');
        }
    });

    //Scroll
    $('div.page').waypoint(function () {
        var id = $(this).attr('id');
        $('ul#navigation a.active').removeClass('active');
        $('ul#navigation a[href="#' + id + '"]').addClass('active');

    });

    /* fixes */
    $(window).scroll(function () {
        if ($(window).scrollTop() === 0) {
            $('ul#navigation a.active').removeClass('active');
            $('ul#navigation a[href="#objectives"]').addClass('active');
        } else if ($(window).height() + $(window).scrollTop() === $('#container').height()) {
            $('ul#navigation a.active').removeClass('active');
            $('ul#navigation a[href^="#"]:last').addClass('active');
        }
    });

    /* tab */
    // first selector
    $('.tab').each(function () {
        $(this).find('ul > li:first').addClass('active');
        $(this).find('div.tab_container > div:first').addClass('active');
    });

    /* toggles */
    $('.toggle h3').click(function () {
        $(this).parent().find('.toggle_data').slideToggle();
    });

    // click functions
    $('.tab > ul > li').click(function () {
        $(this).parent().find('li.active').removeClass('active');
        $(this).addClass('active');

        $(this).parent().parent().find('div.tab_container > div.active').removeClass('active').slideUp();
        $(this).parent().parent().find('div.tab_container > div#' + $(this).attr('id')).slideDown().addClass('active');

        return false;
    });

    // var $container = $('div#works').isotope({
    //     itemSelector: 'img.work',
    //     layoutMode: 'fitRows'
    // });

    // // items filter
    // $('#works_filter a').click(function () {
    //     var selector = $(this).attr('data-filter');
    //     $('div#works').isotope({
    //         filter: selector,
    //         itemSelector: 'img.work',
    //         layoutMode: 'fitRows'
    //     });

    //     $('#works_filter').find('a.selected').removeClass('selected');
    //     $(this).addClass('selected');

    //     return false;
    // });

    //smooth scroll top
    $('.gotop').addClass('hidden');

    $("a.gotop").smoothScroll();

    $('#wrap').waypoint(function (event, direction) {
        $('.gotop').toggleClass('hidden', direction === "up");
    }, {
        offset: '-100%'
    });
    //bind send message here
    $('#submit').click(sendMessage);
});

/* Contact Form */
function checkEmail(email) {
    var check = /^[\w\.\+-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]{2,6}$/;
    if (!check.test(email)) {
        return false;
    }
    return true;
}

function sendMessage() {
    // receive the provided data
    var name = $("input#name").val();
    var email = $("input#email").val();
    var subject = $("input#subject").val();
    var msg = $("textarea#msg").val();
    var submitBtn = $('button#submit');

    // check if all the fields are filled
    if (name == '' || email == '' || subject == '' || msg == '') {
        $("div#msgs").html('<p class="alert alert-error">All fields are required</p>');
        return false;
    }

    // verify the email address
    if (!checkEmail(email)) {
        $("div#msgs").html('<p class="alert alert-error">Please enter a valid email address</p>');
        return false;
    }
    submitBtn.prop('disabled',true).html('<i class="icon-spinner icon-spin"></i>');

    $.ajax({
        type: "POST",
        url: 'post-contact',
        data: $('#cform').serialize(),
        dataType: 'json',
        success: function (data) {
            if (data.success == 1) {
                $("div#msgs").html('<p class="alert alert-success">You message has been sent successfully!</p>');
                $('#cform')[0].reset();
                submitBtn.prop('disabled',false).html('<strong>Send</strong>');        
            } else {
                $("div#msgs").html('<p class="alert alert-error">Could not complete your request. Try again!</p>');
                submitBtn.prop('disabled',false).html('<strong>Send</strong>');
            }
        },
        error: function () {
            $("div#msgs").html('<p class="alert alert-error">Could not complete your request. Try again!</p>');
            submitBtn.prop('disabled',false).html('<strong>Send</strong>');
        }
    });

    return false;
}