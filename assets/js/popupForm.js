$(function () {
    $(document).on('click', '.addTweetBtn', function () {              //home - 86
        $('.status').removeClass().addClass('status-removed');  //всі елементи з класом .status втрачають свої поточні класи і отримують новий клас status-removed. Це може бути використано для зміни стилів або поведінки цих елементів на сторінці.
        $('.hash-box').removeClass().addClass('hash-removed');
        $('#count').attr('id', 'count-removed');

        $.post('http://twitter/core/ajax/tweetForm.php', function (data) {
            $('.popupTweet').html(data);                        //home-208
            $('.closeTweetPopup').click(function () {
                $('.popup-tweet-wrap').hide();                  //tweetform - 2
                $('.status-removed').removeClass().addClass('status');
                $('.hash-removed').removeClass().addClass('hash-box');
                $('#count-removed').attr('id', 'count');

            })
        });
    });

    $(document).on('submit', '#popupForm', function (e) {               //tweetform - 16
        e.preventDefault();              //e.preventDefault();: Цей рядок коду використовується для запобігання типової дії браузера для події. У контексті введення даних це часто використовується для того, щоб уникнути перезавантаження сторінки або відправки форми при кліці на кнопку.
        var formData = new FormData($(this)[0]); //Цей рядок створює новий об'єкт FormData із даних форми. $(this)[0] вказує на перший елемент форми (в даному випадку, саму форму). Об'єкт FormData дозволяє легко збирати дані форми для їх подальшої обробки або відправки через AJAX.
        formData.append('file', $('#file')[0].files[0]);                             //tweetform - 26
        //'file' є ключем, який вказує на поле або параметр, пов'язаний з файловим введенням форми.
        // $('#file')[0].files[0] — це значення, яке представляє обранний користувачем файл. $('#file')[0] отримує перший DOM-елемент з ідентифікатором 'file', і files[0] повертає перший обраний файл (якщо він існує).
        $.ajax({
            url: "http://twitter/core/ajax/addTweet.php",
            type: "POST",
            data: formData,
            success: function (data) {
                result = JSON.parse(data);

                if (result['error']) {
                    $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.error + '</p></div></div>').insertBefore('.header-wrapper');
                    $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
                    $('.popup-tweet-wrap').hide();                   
                } else if(result['success']){
                    $('<div class="error-banner"><div class="error-banner-inner"><p id="errorMsg">' + result.success + '</p></div></div>').insertBefore('.header-wrapper');
                    $('.error-banner').hide().slideDown(300).delay(5000).slideUp(300);
                    $('.popup-tweet-wrap').hide();
                    //location.reload();
                }
                
            },
            cache: false,
            contentType: false,
            processData: false
            
        });
        
        /**
        Цей блок коду використовує метод $.ajax для відправлення асинхронного HTTP-запиту на сервер. 
        url: Адреса, на яку буде відправлено запит. У цьому випадку запит буде відправлено за адресою "http://twitter/core/ajax/addTweet.php".
        type: Тип HTTP-запиту. У цьому випадку використовується POST-запит.
        data: Дані, які будуть відправлені на сервер. У цьому випадку використовується об'єкт formData, який містить дані форми, включаючи обраний файл.
        success: Функція, яка буде викликана при успішному завершенні запиту. В цьому випадку функція залишена порожньою, але може бути додана логіка для обробки відповіді сервера.
        cache: Вказує, чи слід використовувати кешування для цього запиту. У цьому випадку встановлено значення false.
        contentType: Вказує тип вмісту запиту. У цьому випадку встановлено значення false, оскільки contentType не обробляється (використовується FormData, який автоматично встановлює відповідний тип вмісту для форми, що містить файли).
        processData: Вказує, чи обробляти дані перед відправленням запиту. У цьому випадку встановлено значення false, оскільки обробка даних не потрібна при використанні FormData. */
    });
});