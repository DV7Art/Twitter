$(function () {
    $(document).on('click', '.deleteTweet', function () {        //tweet - 109
        var tweet_id = $(this).data('tweet');
        $.post('http://twitter/core/ajax/deleteTweet.php', { showpopup: tweet_id }, function (data) {
            $('.popupTweet').html(data);                        //home-208
            $('.close-retweet-popup, .cancel-it').click(function () {
                $('.retweet-popup').hide();
            });

            $(document).on('click', '.delete-it', function () {       //deletetweet - 38
                $.post('http://twitter/core/ajax/deleteTweet.php', { deleteTweet: tweet_id }, function () {
                    $('.retweet-popup').hide();
                    location.reload(); //перезавантаження сторінки
                })
            })
        });
    });


    $(document).on('click', '.deleteComment', function () {     //popuptweets - 171 | comment - 43
        var comment_id = $(this).data('comment');
        var tweet_id = $(this).data('tweet');

        $.post('http://twitter/core/ajax/deleteComment.php', { deleteComment: comment_id }, function () {
            $.post('http://twitter/core/ajax/popupTweets.php', { showpopup: tweet_id }, function (data) {
                $('.popupTweet').html(data);                           //home-208
                $('.tweet-show-popup-box-cut').click(function () {    //popuptweets - 15
                    $('.tweet-show-popup-wrap').hide();             //popuptweets - 11
                });
            });
        });
    });
});
