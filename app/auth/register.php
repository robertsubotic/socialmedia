<?php
    require_once "../classes/User.php";
    require_once "../config/config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $retype_password = $_POST['retype_password'];

        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['retype_password'])) {
            $_SESSION['error_message']['text'] = "All fields are required!";
            header("Location: register.php"); 
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message']['text'] = "Not valid email!";
            header("Location: register.php"); 
            exit();
        }

        if ($password !== $retype_password) {
            $_SESSION['error_message']['text'] = "Passowrds don't match!";
            header("Location: register.php"); 
            exit();
        }

        $user = new User();

        $created = $user->create($username, $email, $password);

        header("Location: login.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head> 
<body class="bg-gray-100 h-screen flex justify-center items-center">

<div class="bg-white p-8 rounded-lg shadow-md w-96">
    <h1 class="text-2xl mb-6 text-center">Register</h1>
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
            <label for="username" class="block mb-2">Username:</label>
            <input type="text" id="username" name="username" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2">Email:</label>
            <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2">Password:</label>
            <input type="password" id="password" name="password" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="retype_password" class="block mb-2">Retype Password:</label>
            <input type="password" id="retype_password" name="retype_password" required class="w-full p-2 border rounded">
        </div>
        <button type="submit" class="bg-green-600 text-white w-full p-2 rounded hover:bg-green-700">Register</button>
    </form>
</div>

</body>
</html>
