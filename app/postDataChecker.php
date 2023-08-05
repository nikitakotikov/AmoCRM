<?php

namespace App;

class PostDataChecker
{
    public static function checkPostData($fields)
    {
        foreach ($fields as $field) {
            if (!isset($_POST[$field])) {
                return false;
            }
        }
        return true;
    }
}
