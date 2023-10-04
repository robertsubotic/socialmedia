<?php
    require_once '../classes/User.php';
    require_once '../config/config.php';
    $user = new User();
    $user->logout();
    header("Location: ../../");
    exit();
?>