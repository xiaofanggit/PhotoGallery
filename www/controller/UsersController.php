<?php

/**
 * Created by PhpStorm.
 * User: xiaof
 * Date: 2017-03-09
 * Time: 4:46 PM
 */
class UsersController extends Controller
{
    private $userModel;
    function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Login
     * http://localhost:8888/Users/Login
     */
    public function login()
    {
        if (isset($_SESSION) && !empty($_SESSION['userId'])) {
            $this->redirect('/Galleries/display');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = $this->userModel->isLogin($_REQUEST['email'], $_REQUEST['password']);
            if ($response['validUser'] === true) {
                $this->redirect('/Galleries/display');
                exit;
            } else {
                if (!empty($response['email'])) {
                    $errors['email'] = $response['email'];
                }
                if (!empty($response['password'])) {
                    $errors['password'] = $response['password'];
                }
            }

        }
        require_once VIEW . "login.html.php";
    }

    /**
     * Logout
     */
    public function logout()
    {
        unset($_SESSION);
        session_destroy();
        session_write_close();

        $this->redirect('/Users/login');
    }
}