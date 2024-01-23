$(function(){
    $('.search').keyup(function(){
        var search = $(this).val();
        $.post('http://twitter/core/ajax/search.php', {search:search},function(data){
            $('.search-result').html(data);
        });
    });
});