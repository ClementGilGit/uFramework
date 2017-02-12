<?php

/**
 * Created by PhpStorm.
 * User: Rémi
 * Date: 07/02/2017
 * Time: 16:34
 */
namespace Validation;

class FormValidation
{
    public static function validationForm($user, $password, $passwordCheck)
    {
        $number = preg_match('@[0-9]@', $password);
        $upper = preg_match('@[A-Z]@', $password);
        $lower = preg_match('@[a-z]@', $password);
        $specialChars = preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $user);
        $dataError = array();

        if (empty($user)) {
            $dataError['user'] = 'Login Empty';
        }

        if ($specialChars) {
            $dataError['user']='Specials characters error';
        }

        if (strlen($user)<4) {
            $dataError['user'] = 'Not enough characters (min 4)';
        }
        if (strlen($user)>12) {
            $dataError['user'] = 'Too Many characters (max 12)';
        }
        if (empty($password)) {
            $dataError['password']='Password Invalid';
        }
        if (!$upper || !$lower || !$number || strlen($password)<6) {
            $dataError['password']= 'The password may have 1 number, 1 upper, 1 lower and 6 characters min';
        }
        if (empty($passwordCheck)) {
            $dataError['passwordCheck']='PasswordCheck Invalid';
        }
        if ($password!=$passwordCheck) {
            $dataError['passwordCheck']= 'Password and PasswordCheck are different';
        }

        return $dataError;
    }
}
