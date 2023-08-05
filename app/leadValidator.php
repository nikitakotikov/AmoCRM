<?php

namespace App;

class LeadValidator 
{
    public static function validate($name, $phone, $email, $price) {
        $errors = [];

        if (empty($name)) {
            $errors[] = "Имя не должно быть пустым.";
        }

        if (empty($phone)) {
            $errors[] = "Телефон не должен быть пустым.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Неправильный формат email.";
        }

        if (!is_numeric($price) || $price <= 0) {
            $errors[] = "Цена должна быть положительным числом.";
        }

        return $errors;
    }
}