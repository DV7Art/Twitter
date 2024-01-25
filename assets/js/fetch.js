$(function () {
    var win = $(window);
    var offset = 10;

    win.scroll(function () {
        if ($(document).height() - offset <= (win.height() + win.scrollTop())) {
            offset += 10;
            $('#loader').show(); // home - 206
            $.post('http://twitter/core/ajax/fetchPosts.php', { fetchPosts: offset }, function (data) {
                $('.tweets').html(data); // home - 200
                $('#loader').hide();
            });
        }
    });
});