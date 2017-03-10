<?php

/**
 * Created by PhpStorm.
 * User: xiaof
 * Date: 2017-03-09
 * Time: 4:46 PM
 */
class Controller
{
    /**
     * Redirect to another page
     * @param $url
     */
    function redirect($url)
    {
        $url = ROOT_URL . $url;
        if (headers_sent()) {
            exit('<script type="text/javascript">window.location.href="' . $url . '";</script>');
        } else {
            header('Location: ' . $url);
            exit();
        }
    }

}