<?php
    require_once "app/config/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social-Media-App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-blue-900 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="" class="text-2xl font-bold">Social-Media-App</a>
            </div>
            <div class="space-x-4">
                <a href="/social-media" class="hover:text-blue-300">Home</a>
                <a href="#" class="hover:text-blue-300">About Us</a>
                <?php if(isset($_SESSION['id'])) {
                    echo '<a href="app/social" class="bg-gray-600 px-3 py-2 rounded-full hover:bg-gray-800">Social</a>';
                    echo '<a href="app/auth/logout.php" class="bg-blue-600 px-3 py-2 rounded-full hover:bg-blue-400">Logout</a>';
                } else {
                    echo '<a href="app/auth/register.php" class="bg-green-500 px-3 py-2 rounded-full hover:bg-green-700">Register</a>';
                    echo '<a href="app/auth/login.php" class="bg-gray-600 px-3 py-2 rounded-full hover:bg-gray-800">Login</a>';
                } ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-12 px-4">
        <h1 class="text-center text-3xl mb-4">Welcome to Social-Media-App!</h1>
        <img src="https://via.placeholder.com/600x400" alt="Random Picture" class="w-full md:w-1/2 mb-6 mx-auto rounded shadow-lg">
        <p class="mb-6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vel libero at massa vehicula sollicitudin eu vitae arcu. Morbi feugiat, tellus ac viverra vehicula, nunc velit pharetra sapien, at tempor odio justo eget libero. Aenean iaculis massa a dui.At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
        </p>
        <h2 class="text-center text-2xl mb-4">Contact Us</h2>
        <div class="flex justify-center">
            <form action="." method="POST" class="w-full md:w-2/3">
                <div class="mb-4">
                    <label for="name" class="block mb-2">Name:</label>
                    <input type="text" id="name" name="name" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2">Email:</label>
                    <input type="email" id="email" name="email" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="subject" class="block mb-2">Subject:</label>
                    <input type="text" id="subject" name="subject" required class="w-full p-2 border rounded">
                </div>
                <div class="mb-4">
                    <label for="message" class="block mb-2">Message:</label>
                    <textarea id="message" name="message" rows="6" required class="w-full p-2 border rounded"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Submit</button>
            </form>
        </div>
    </div>

    <footer class="bg-blue-900 text-white p-6 mt-12">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-sm">&copy; 2023 Social-Media-App</div>
            <div class="text-sm">Made by Robert Subotic</div>
        </div>
    </footer>

</body>
</html>
