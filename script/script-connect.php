<?php

require_once('../vendor/autoload.php');

use App\CreateToken;
use App\OAuthDataBuilder;
use App\ErrorHandler;

// Поддомен нужного аккаунта
$subdomain = 'kotikovsoftware'; 

// Формируем URL для запроса
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; 

// Проверяем, что все необходимые поля в POST запросе не пусты
if (empty($_POST['clientId']) || empty($_POST['clientSecret']) || empty($_POST['code']) || empty($_POST['redirectUri'])) {
    $response['error'] = 'Ошибка: Все поля должны быть заполнены.';
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit; // Прерываем выполнение скрипта
}

$clientId = $_POST['clientId'];
$clientSecret = $_POST['clientSecret'];
$code = $_POST['code'];
$redirectUri = $_POST['redirectUri'];

// Создаем данные, которые будем отправлять в запросе
$date = new OAuthDataBuilder($clientId, $clientSecret, $code, $redirectUri);
$data = $date->buildData();

// Создаем объект запроса 
$curl = new CreateToken($link, $data);

try {
    // Отправляем запрос
    $curl->sendRequest();

    // Если код ответа не успешный - выбрасываем исключение  
    if ($curl->getCode() < 200 || $curl->getCode() > 204) {
        throw new Exception(ErrorHandler::getErrorDescription($curl->getCode()), $curl->getCode());
    }

    // Данные получаем в формате JSON
    $answer = json_decode($curl->getOut(), true);
    $answer['subdomain'] = $subdomain;
    $filename = 'token.json';

    // Проверяем существование файла
    if (!file_exists($filename)) {
        // Создаем пустой файл, если он не существует
        touch($filename);
        $content = json_encode($answer, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents($filename, $content);
    }

    $fileContents = file_get_contents($filename);

    // Парсим JSON
    $tokenData = json_decode($fileContents, true);

    // Проверяем наличие необходимых элементов
    if (
        !isset($tokenData['token_type'], $tokenData['expires_in'], $tokenData['access_token'], $tokenData['refresh_token'], $tokenData['subdomain'])
    ) {
        $response['error'] = 'Ошибка: Данные в файле не полные или отсутствуют.';
    } else {
        $response['message'] = 'Данные в файле корректны';
    }
} catch (\Exception $e) {
    $response['error'] = 'Ошибка: Неправильно введенные данные';
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
