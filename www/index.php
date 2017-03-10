<?php
require_once 'core/core.class.php';
$url = isset($_SERVER['REQUEST_URI']) ? explode('/', ltrim($_SERVER['REQUEST_URI'],'/')) : '/';
Core::run($url);
?>