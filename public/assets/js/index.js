
$(document).ready(function () {
    $('#alert').each(function () {
        $(this).animate({ marginTop: -100 }, 0).removeClass('d-none').hide().slideDown(10, function () {
            $(this).animate({ marginTop: 10 }, 250);
        });

        setTimeout(() => {
            $(this).animate({ marginTop: -100 }, 250);
        }, 2500);
    });
})