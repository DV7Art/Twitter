$(function(){
    $(document).on('click', '.retweet', function(){
        var tweet_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        $counter = $(this).find('.retweetsCounter');
        $count = $counter.text();
        $button = $(this);

        $.post('http://twitter/core/ajax/retweet.php', {showPopup:tweet_id, user_id:user_id},function(data){
            $('.popupTweet').html(data);
            $('.close-retweet-popup').click(function(){
                $('.retweet-popup').hide();
            });
        });
    });
});

// $.post('http://twitter/core/ajax/retweet.php', {showPopup:tweet_id, user_id:user_id}, function(data) { ... });: 
// Виконує AJAX-запит методом POST до зазначеного URL з параметрами showPopup, tweet_id та user_id. 
// Коли відбудеться успішна відповідь, викличеться функція, яка вставить HTML-вміст (отриманий з сервера) в елемент з класом "popupTweet".