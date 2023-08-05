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
        <form id="myForm" method="post" action="test.php">
            <label for="name">clientId:</label><br>
            <input type="text" id="clientId" name="clientId"><br>
            <label for="phone">clientSecret:</label><br>
            <input type="text" id="clientSecret" name="clientSecret"><br>
            <label for="email">code:</label><br>
            <input type="text" id="code" name="code"><br>
            <label for="price">redirectUri:</label><br>
            <input type="text" id="redirectUri" name="redirectUri"><br><br>
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
                    url: 'script/script-connect.php', // Укажите путь к вашему PHP скрипту
                    data: formData,
                    dataType: 'json', // Указываем, что ожидаем JSON-ответ
                    success: function(response) {
                        // Обработка успешного ответа от сервера
                        if (response.message) {
                            window.location.href = 'add-deal.php'; // Замените на вашу страницу
                        } else {
                            $('#responseMessage').html(response.error);
                        }
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
