$(function () {
    $(document).on('click', '.like-btn', function () {
        var tweet_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCounter');
        var count = counter.text();
        var button = $(this);

        $.post('http://twitter/core/ajax/like.php', { like: tweet_id, user_id: user_id }, function () {
            counter.show();
            button.addClass('unlike-btn');
            button.removeClass('like-btn');
            count++;
            counter.text(count);
            button.find('.fa-heart-o').addClass('fa-heart');
            button.find('.fa-heart').removeClass('fa-heart-o');
        });
    });

    $(document).on('click', '.unlike-btn', function () {
        var tweet_id = $(this).data('tweet');
        var user_id = $(this).data('user');
        var counter = $(this).find('.likesCounter');
        var count = counter.text();
        var button = $(this);

        $.post('http://twitter/core/ajax/like.php', { unlike: tweet_id, user_id: user_id }, function () {
            counter.show();
            button.addClass('like-btn');
            button.removeClass('unlike-btn');
            count--;
            if(count === 0){
                counter.hide();
            }else{
                counter.text(count);
            }
            counter.text(count);
            button.find('.fa-heart').addClass('fa-heart-o');
            button.find('.fa-heart-o').removeClass('fa-heart');
        });
    });
});


// Цей фрагмент коду використовує jQuery та AJAX для взаємодії з сервером при кліці на кнопку "лайк" у твіті. Давайте розберемо його:

// $(function () { ... });: Це jQuery-функція, яка викликається при завантаженні сторінки.

// $(document).on('click', '.like-btn', function () { ... });: Це подія кліку, яка спрацьовує при кліку на елемент з класом 'like-btn', навіть якщо цей елемент є динамічно доданим в DOM після завантаження сторінки.

// var tweet_id = $(this).data('tweet');: Отримання значення атрибута 'data-tweet' кнопки, яке містить ідентифікатор твіта.

// var user_id = $(this).data('user');: Отримання значення атрибута 'data-user' кнопки, яке містить ідентифікатор користувача.

// var counter = $(this).find('.likesCounter');: Знаходження елементу з класом 'likesCounter' всередині кнопки.

// var count = counter.text();: Отримання поточного значення лічильника лайків.

// var button = $(this);: Зберігання посилання на кнопку в змінну для подальших змін.

// $.post('http://twitter/core/ajax/like.php', { like: tweet_id, user_id: user_id }, function () { ... });: Виклик AJAX-запиту типу POST до сервера за допомогою jQuery. Дані (tweet_id та user_id) передаються на сервер. Функція обратного виклику викликається після успішного виконання запиту.

// button.addClass('unlike-btn');: Додавання класу 'unlike-btn' до кнопки.

// button.removeClass('like-btn');: Видалення класу 'like-btn' з кнопки.

// count++;: Збільшення значення лічильника лайків.

// counter.text(count);: Оновлення тексту лічильника лайків.

// button.find('.fa-heart-o').addClass('fa-heart');: Заміна класу 'fa-heart-o' (пусте серце) на 'fa-heart' (заповнене серце) в іконці.

// button.find('.fa-heart').removeClass('fa-heart-o');: Видалення класу 'fa-heart-o' з іконки.