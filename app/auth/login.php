<?php
    require_once "../classes/User.php";
    require_once "../config/config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($_POST['email']) || empty($_POST['password'])) {
            $_SESSION['error_message']['text'] = "All fields are required!";
            header("Location: login.php"); 
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message']['text'] = "Not valid email!";
            header("Location: login.php"); 
            exit();
        }

        $user = new User();

        $result = $user->login($email, $password);;

        if($result) {
            header("Location: ../social/");
        } else {
            $_SESSION['error_message']['text'] = "Invalid creds.";
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">

<div class="bg-white p-8 rounded-lg shadow-md w-96">
    <h1 class="text-2xl mb-6 text-center">Login</h1>
    <?php if(isset($_SESSION['error_message'])) : ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline"><?php 
                echo $_SESSION['error_message']['text'];
                unset($_SESSION['error_message']);
            ?></span>
        </div>

    <?php endif; ?>
    <form action="" method="POST">
        <div class="mb-4">
            <label for="email" class="block mb-2">Email:</label>
            <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2">Password:</label>
            <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
        </div>
        <button type="submit" class="bg-blue-600 text-white w-full p-2 rounded hover:bg-blue-700">Login</button>
    </form>
</div>

</body>
</html>
