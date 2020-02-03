$(document).ready(function(e) {
    $('.item_tab').click(function(){
        $('.item_tab').removeClass('active');
        var id_tab=$(this).attr('href');
        $(this).addClass('active');
        $('.content_tab').css({'display':'none'});
        $(id_tab).fadeIn();
        return false;
    });
});