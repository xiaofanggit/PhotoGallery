<!DOCTYPE html>
<html lang="en">
<head>
    <title>Photo Galleries</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>​
<div class="container">
    <div class="row">
        <?php if (isset($_SESSION) && !empty($_SESSION['userId'])): ?>
            <a href="<?= ROOT_URL ?>/Users/logout" class="btn btn-default pull-right">Sign Out</a>
            <a href="<?= ROOT_URL ?>/Galleries/manager" class="btn btn-default pull-right">Gallery Manager</a>
            <?php else: ?>
            <a href="<?= ROOT_URL ?>/Users/login" class="btn btn-default pull-right">Login</a>
        <?php endif; ?>
        <a href="<?= ROOT_URL ?>/Galleries/display" class="btn btn-default pull-right">Display Gallery</a>
    </div>

