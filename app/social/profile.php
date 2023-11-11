<?php
    require_once '../config/config.php';
    require_once '../classes/User.php';

    if(!isset($_SESSION['id'])) {
        header("Location: ../../");
    }

    $csrf_token = $_SESSION['csrf_token'];
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPassword = $_POST['newPassword'];
        $retypePassword = $_POST['retypePassword'];

        if (empty($_POST['newPassword']) || empty($_POST['retypePassword'])) {
            $_SESSION['error_message']['text'] = "All fields are required!";
            header("Location: profile.php"); 
            exit();
        }

        if($_POST['newPassword'] !== $_POST['retypePassword']) {
            $_SESSION['error_message']['text'] = "Passwords don't match!";
            header("Location: profile.php"); 
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message']['text'] = "CSRF Token Validation failed!";
            header("Location: profile.php"); 
            exit();
        }

        $user = new User();

        $user->changePassword($newPassword);

        $result = $user;

        if($result) {
            header("Location: profile.php");
        } else {
            $_SESSION['error_message']['text'] = "Something went wrong.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Social-Media-App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen antialiased leading-none font-sans">

    <div class="container mx-auto h-full flex">
        <div class="w-1/4 bg-white p-4 border-r border-gray-200">
            <ul>
                <li class="mb-4">
                    <a href="" class="text-blue-500 hover:text-blue-700">Profile</a>
                </li>
                <li class="mb-4">
                    <a href="index.php" class="text-gray-500 hover:text-blue-700">Home</a>
                </li>
                <li class="mb-4">
                    <a href="commingsoon.html" class="text-gray-500 hover:text-blue-700">Notifications</a>
                </li>
                <li class="mb-4">
                    <a href="commingsoon.html" class="text-gray-500 hover:text-blue-700">Messages</a>
                </li>
                <li class="mb-4">
                    <a href="../auth/logout.php" class="text-gray-500 hover:text-blue-700">Log Out</a>
                </li>
            </ul>
        </div>
        <div class="w-3/4 bg-white p-4">
            <div class="mb-4 p-2 border-b border-gray-200">
                <h1 class="font-bold text-2xl mb-4">Your Profile</h1>
                <?php
                    $user = new User();
                    $username = $user->getUsername();
                    $email = $user->getEmail();
                ?>
                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-600">Username:</label>
                    <span class="text-gray-700"><?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-600">Email:</label>
                    <span class="text-gray-700"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>

                <div class="mb-4">
                    <label class="block mb-2 font-semibold text-gray-600">Password:</label>
                    <span class="text-gray-700">••••••••</span> <a onclick="togglePasswordFields();" class="text-blue-500 ml-2 hover:underline cursor-pointer">Change Password</a>
                </div>
                <?php if(isset($_SESSION['error_message'])) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Error:</strong>
                        <span class="block sm:inline"><?php 
                            echo $_SESSION['error_message']['text'];
                            unset($_SESSION['error_message']);
                        ?></span>
                    </div>
                <?php endif; ?>
                <div id="passwordFields" class="hidden space-y-4">
                    <form action="" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <div>
                            <label for="newPassword" class="block mb-2 font-semibold text-gray-600">New Password:</label>
                            <input type="password" id="newPassword" name="newPassword" class="w-full p-2 border rounded" placeholder="Enter new password">
                        </div><br>
                        <div>
                            <label for="retypePassword" class="block mb-2 font-semibold text-gray-600">Retype Password:</label>
                            <input type="password" id="retypePassword" name="retypePassword" class="w-full p-2 border rounded" placeholder="Retype new password">
                        </div><br>
                        <button type="submit" class="bg-blue-600 text-white w-full p-2 rounded hover:bg-blue-700">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
    function togglePasswordFields() {
        const fields = document.getElementById("passwordFields");
        if (fields.classList.contains("hidden")) {
            fields.classList.remove("hidden");
        } else {
            fields.classList.add("hidden");
        }
    }
</script>
</body>
</html>
