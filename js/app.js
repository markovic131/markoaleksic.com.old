$(function () {

    $(function(){$('a[href*="://"], form[action*="://"]').not($('a[href*="://'+location.host+'"]')).attr('target','_blank');});
    $("ul#navigation a").smoothScroll({
        afterScroll: function () {
            $('ul#navigation a.active').removeClass('active');
            $(this).addClass('active');
        }
    });

    $('div.section').waypoint(function () {
        var id = $(this).attr('id');
        $('ul#navigation a.active').removeClass('active');
        $('ul#navigation a[href="#' + id + '"]').addClass('active');

    });

    $(window).scroll(function () {
        if ($(window).scrollTop() === 0) {
            $('ul#navigation a.active').removeClass('active');
            $('ul#navigation a[href="#objectives"]').addClass('active');
        } else if ($(window).height() + $(window).scrollTop() === $('#container').height()) {
            $('ul#navigation a.active').removeClass('active');
            $('ul#navigation a[href^="#"]:last').addClass('active');
        }
    });

    $('.tab').each(function () {
        $(this).find('ul > li:first').addClass('active');
        $(this).find('div.tab_container > div:first').addClass('active');
    });

    $('.toggle h3').click(function () {
        $(this).parent().find('.toggle_data').slideToggle();
    });

    $('.tab > ul > li').click(function () {
        $(this).parent().find('li.active').removeClass('active');
        $(this).addClass('active');

        $(this).parent().parent().find('div.tab_container > div.active').removeClass('active').slideUp();
        $(this).parent().parent().find('div.tab_container > div#' + $(this).attr('id')).slideDown().addClass('active');

        return false;
    });

    $('.gotop').addClass('hidden');

    $("a.gotop").smoothScroll();

    $('#wrap').waypoint(function (event, direction) {
        $('.gotop').toggleClass('hidden', direction === "up");
    }, {
        offset: '-100%'
    });

    $('#submit').click(sendMessage);
});

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
    var msg = $("textarea#message").val();
    var submitBtn = $('button#submit');

    // check if all the fields are filled
    if (name == '' || email == '' || msg == '') {
        $("div#msgs").html('<p class="alert alert-danger">All fields are required</p>');
        return false;
    }

    // verify the email address
    if (!checkEmail(email)) {
        $("div#msgs").html('<p class="alert alert-danger">Please enter a valid email address</p>');
        return false;
    }
    submitBtn.prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i>');

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
                $("div#msgs").html('<p class="alert alert-danger">Could not complete your request. Try again!</p>');
                submitBtn.prop('disabled',false).html('<strong>Send</strong>');
            }
        },
        error: function () {
            $("div#msgs").html('<p class="alert alert-danger">Could not complete your request. Try again!</p>');
            submitBtn.prop('disabled',false).html('<strong>Send</strong>');
        }
    });

    return false;
}