$(function(){
    $('#postComment').click(function(){ //popuptweets - 132 | safe dublicate comments
        var comment = $('#commentField').val(); //popuptweets - 117
        var tweet_id = $('#commentField').data('tweet');

        if (comment != "") {
            $.post('http://twitter/core/ajax/comment.php', {comment:comment, tweet_id:tweet_id}, function(data) {
              $('#comments').html(data);  //popuptweets - 138
              $('#commentField').val("");
            })
        }
    })  
})