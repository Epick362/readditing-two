$(function() {
    // initialize kudos
    $("figure.kudoable").kudoable();
 
    // check to see if user has already kudod
    if($.cookie(postId) == 'true') {
        // make kudo already kudod
        $("figure.kudoable").removeClass("animate").addClass("complete");
 
        /*
        * Your server would take care of the proper kudos count, but because this is a
        * static page, we need to set it here so it doesn't become -1 when you remove
        * the kudos after a reload
        */
        $(".num").html(1);
    }
 
    // after kudo'd
    $("figure.kudo").bind("kudo:added", function(e) {
        var element = $(this);
 
        // set cookie so user cannot kudo again for 365 days
        $.cookie(postId, 'true', { expires: 365 });
    });
 
    // after removing a kudo
    $("figure.kudo").bind("kudo:removed", function(e) {
        var element = $(this);
 
        // remove cookie
        $.removeCookie(postId);
    });
});