$(function () {
    $(document).on('click', '.retweet', function () {
        $tweet_id = $(this).data('tweet');
        $user_id = $(this).data('user');
        $counter = $(this).find('.retweetsCounter');
        $count = $counter.text();
        $button = $(this);

        $.post('http://twitter/core/ajax/retweet.php', { showPopup: $tweet_id, user_id: $user_id }, function (data) {
            $('.popupTweet').html(data);
            $('.close-retweet-popup').click(function () {
                $('.retweet-popup').hide();
            });
        });
    });

    $(document).on('click', '.retweet-it', function () {
        var comment = $('.retweetMsg').val();
        $.post('http://twitter/core/ajax/retweet.php', { retweet: $tweet_id, user_id: $user_id, comment: comment }, function () {
            $('.retweet-popup').hide();
            $count++;
            $counter.text($count);
            $button.removeClass('retweet').addClass('retweeted');
        });
    });
});

// $.post('http://twitter/core/ajax/retweet.php', {showPopup:tweet_id, user_id:user_id}, function(data) { ... });: 
// Виконує AJAX-запит методом POST до зазначеного URL з параметрами showPopup, tweet_id та user_id. 
// Коли відбудеться успішна відповідь, викличеться функція, яка вставить HTML-вміст (отриманий з сервера) в елемент з класом "popupTweet".