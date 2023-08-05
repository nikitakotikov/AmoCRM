<?php

require_once('../vendor/autoload.php');

use App\TokenManager;
use App\AmoCRMClient;
use App\LeadValidator;
use App\LeadDataBuilder;
use App\DataSanitizer;
use App\PostDataChecker;





$filename = 'token.json';
$fieldsToCheck = ['name', 'phone', 'email', 'price'];

if (!file_exists($filename)) {
    echo json_encode(['Ошибка: Файл token.json не существует.'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit; // Прерываем выполнение скрипта
}

//Получаем токен для входа из файла token.json, который создается в корне
$tokenManager = new TokenManager($filename);
$access_token = $tokenManager->getAccessToken();
$subdomain = $tokenManager->getSubDomain();

$amoClient = new AmoCRMClient($subdomain, $access_token);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (PostDataChecker::checkPostData($fieldsToCheck)) {
        $title = 'Тестовое задание';
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $price = (int)$_POST['price'];

        //Экранируем данные
        $sanitizedData = DataSanitizer::sanitizeAndBuildArray($name, $phone, $email, $price);

        //Проводим валидацию данных
        $errors = LeadValidator::validate(
            $sanitizedData['name'],
            $sanitizedData['phone'],
            $sanitizedData['email'],
            $sanitizedData['price']
        );

        if (!empty($errors)) {
            //echo "Ошибка: " . implode(', ', $errors);
        } else {
            try {

                //Создаем данные для запроса, которые будет отправлять
                $leadDataBuilder = new LeadDataBuilder();
                $leadDataBuilder->addLead($title, $sanitizedData['price']);
                $leadDataBuilder->addField(2397785, $sanitizedData['name']);
                $leadDataBuilder->addField(2397787, $sanitizedData['email']);
                $leadDataBuilder->addField(2397789, $sanitizedData['phone']);
                $leadData = $leadDataBuilder->build();

                //Отправляем запрос
                $response = $amoClient->createLead($leadData);
                    $errors[] = 'Успешно';
            } catch (Exception $e) {
                echo "Ошибка: " . $e->getMessage();
            }
        }
    } else {
        $errors[] = "Ошибка: Не все поля заполнены.";
    }
}

echo json_encode($errors, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
