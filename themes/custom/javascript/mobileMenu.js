jQuery.noConflict();

(function($) {
    $(document).ready(function() {

        //responsive menu
        $('li.menu-parent').click(function(event) {
            if ($(window).width() < 1200) {
                console.log($(window).width())
                if (!$(this).hasClass('open')) { //open
                    //close others
                    $('li.menu-parent').removeClass('open');
                    $('li.menu-parent span.open-button').html('+');

                    $(this).removeClass('open');
                    $(this).hide().addClass('open').slideDown();
                    $(this).find('.open-button').html('-');
                } else { //close
                    $(this).removeClass('open');
                    $(this).find('.open-button').html('+');
                }
            }
        });
    });

    $(window).load(function() {

    });
}(jQuery));