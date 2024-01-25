$(function(){
    $(document).on('click','.t-show-popup', function(){
        var tweet_id = $(this).data('tweet'); //tweet - 71
        $.post('http://twitter/core/ajax/popuptweets.php', {showpopup:tweet_id}, function(data){
            $('.popupTweet').html(data); //home-208
            $('.tweet-show-popup-box-cut').click(function(){//popuptweets - 15
                $('.tweet-show-popup-wrap').hide();  //popuptweets - 11
            });
        });
    });

    $(document).on('.click', '.imagePopup', function(e){     //tweet - 92
        e.stopPropagation();
        var tweet_id =$(this).data('tweet');
        $.post('http://twitter/core/ajax/imagepopup.php', {showImage:tweet_id}, function(data){
            $('.popupTweet').html(data);
            $('.close-imagePopup').click(function(){    //imagepopup - 13
                $('.img-popup').hide(); //imagepopup - 10
            })  
        })
    });
});