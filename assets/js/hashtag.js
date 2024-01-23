$(function () {
    var regex = /[#|@](\w+)$/ig;
    $(document).on('keyup', '.status', function () {
        var content = $.trim($(this).val());
        var text = content.match(regex);
        var max = 140;
        if (text != null) {
            var dataString = 'hashtag=' + text;

            $.ajax({
                type: "POST",
                url: "http://twitter/core/ajax/getHashtag.php",
                data: dataString,
                cache: false,
                success: function (data) {
                    $('.hash-box ul').html(data);
                    $('.hash-box li').click(function () {
                        var value = $.trim($(this).find('.getValue').text());
                        var oldContent = $('.status').val();
                        var newContent = oldContent.replace(regex, "");

                        $('.status').val(newContent + value + ' ');
                        $('.hash-box li').hide();
                        $('.status').focus();

                        $('#count').text(max - content.length);
                    });
                }
            });
        } else {
            $('.hash-box li').hide();
        }
        $('#count').text(max - content.length);
        if (content.lenght === max) {
            $('#count').css('color', '#F00');
        } else {
            $('#count').css('color', '#000');
        }
    });
});


//для себе:
// Регулярний вираз /[#|@](\w+)$/ig є шаблоном для пошуку хештегів (#) або згадок (@) у рядку. Розглянемо його по частках:

// [#|@]: Це символьний клас, який відповідає або символу #, або символу @.

// (\w+): Це група захоплення, яка відповідає одному або більше (так що +) символам слова. Символи слова включають літери, цифри та підкреслення.

// $: Це якір кінця рядка. Забезпечує, що відповідність повинна знаходитися в кінці рядка.

// i: Цей прапорець робить регулярний вираз регістронезалежним, що означає, що він буде відповідати символам незалежно від регістра (тобто #HashTag і #hashtag вважатимуться однаковими).

// g: Цей прапорець робить регулярний вираз глобальним, що означає, що він буде шукати всі відповідності в рядку, а не припинятиме після першої відповідності.

// Основні етапи роботи коду:

// Ви отримуєте вміст поля вводу з класом .status і витягуєте з нього текст.

// Використовуючи регулярний вираз, ви витягуєте всі хештеги та згадки з тексту.

// Якщо текст містить хоча б один хештег або згадку, ви викликаєте AJAX-запит до сервера за допомогою $.ajax().

// Запит відправляється до http://twitter/core/ajax/getHashtag.php методом POST.

// При успішному виконанні запиту, вміст отриманої відповіді (data) вставляється в елемент з класом .hash-box ul.