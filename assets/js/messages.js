$(function(){
    $(document).on('click', '#messagePopup', function(){
		var getMessages = 1;
		$.post('http://twitter/core/ajax/messages.php', {showMessage:getMessages}, function(data){
			$('.popupTweet').html(data);
			$('#messages').hide();
  		});
	});
})