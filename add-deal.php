<!DOCTYPE html>
<html>
<head>
    <title>Форма</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        #formContainer {
            align-items: center;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        #responseMessage {
            width: 500px;
        }
    </style>
</head>
<body>
    <div id='formContainer'>
        <form id="myForm">
            <label for="name">Имя:</label><br>
            <input required type="text" id="name" name="name"><br>
            <label for="phone">Телефон:</label><br>
            <input required type="tel" id="phone" name="phone"><br>
            <label for="email">Email:</label><br>
            <input required type="email" id="email" name="email"><br>
            <label for="price">Цена:</label><br>
            <input required type="text" id="price" name="price"><br><br>
        <input type="button" value="Отправить" id="submitButton">
    </form>
    <div id="responseMessage"></div>
</div>


    <script>
        $(document).ready(function() {
            // Обработка клика на кнопку "Отправить"
            $('#submitButton').click(function() {
                // Собираем данные из формы
                var formData = $('#myForm').serialize();

                // Отправляем данные через AJAX POST запрос
                $.ajax({
                    type: 'POST',
                    url: 'script/script-add-deal.php', // Укажите путь к вашему PHP скрипту
                    data: formData,
                    success: function(response) {
                        // Обработка успешного ответа от сервера
                        $('#responseMessage').text(response); // Изменили .html() на .text()
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Обработка ошибки
                        $('#responseMessage').html('Произошла ошибка: ' + textStatus);
                    }
                });
            });
        });
    </script>
</body>
</html>
