$(function(){
    $('.search').keyup(function(){
        var search = $(this).val();
        $.post('http://twitter/core/ajax/search.php', {search:search},function(data){
            $('.search-result').html(data);
        });
    });

    $(document).on('keyup', '.search-user', function(){
		$('.message-recent').hide();
		var search = $(this).val();
		$.post('http://twitter/core/ajax/searchUserInMsg.php', {search:search}, function(data){
			$('.message-body').html(data);
		});
	});
});