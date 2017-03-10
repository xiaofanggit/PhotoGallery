<?php

/**
 * Created by PhpStorm.
 * User: xiaof
 * Date: 2017-03-09
 * Time: 5:20 PM
 */
class UserModel extends Model
{
    /**
     * Since we don't use Database, here only allow this user to login.
     * @param $email
     * @param $password
     * @return array
     */
    public function isLogin($email, $password){
        if ($email === 'xiaofang@gmail.com'){
            if ($password === '12345') {
                //$_SESSION['userLoggedIn'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['userId'] = 1;
                return array('validUser' => true);
            }else{
                $wrongPassword = 'Wrong password.';
            }
        }else{
            $wrongEmail = 'Wrong email address.';
        }
        return array(
            'validUser' => false,
            'password' => isset($wrongPassword) ? $wrongPassword : '',
            'email' => isset($wrongEmail) ? $wrongEmail : '');
    }
}