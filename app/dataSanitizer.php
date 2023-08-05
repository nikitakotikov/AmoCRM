<?php

namespace App;

class DataSanitizer 
{
    public static function sanitizeAndBuildArray($name, $phone, $email, $price) {
        $sanitizedData = [
            "name" => self::sanitizeString($name),
            "phone" => self::sanitizeString($phone),
            "email" => self::sanitizeEmail($email),
            "price" => self::sanitizePrice($price)
        ];

        return $sanitizedData;
    }

    private static function sanitizeString($value) {
        return filter_var(trim($value), FILTER_SANITIZE_STRING);
    }

    private static function sanitizeEmail($value) {
        return filter_var(trim($value), FILTER_SANITIZE_EMAIL);
    }

    private static function sanitizePrice($value) {
        return (int)$value;
    }
}
