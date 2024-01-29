$(function(){
	$(document).on('click', '#send', function(){  //messages - 158
		var message = $('#msg').val();
		var get_id   = $(this).data('user');
		$.post('http://twitter/core/ajax/messages.php', {sendMessage:message,get_id:get_id}, function(data){
			getMessages();
			$('#msg').val('');
		});
	});
});