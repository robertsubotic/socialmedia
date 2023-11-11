<?php
    require_once '../classes/Post.php';
    require_once '../classes/User.php';
    require_once '../config/config.php';

    $csrf_token = $_SESSION['csrf_token'];

    if(!isset($_SESSION['id'])) {
        header("Location: ../../");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $description = $_POST['post_description'];

        if(empty($_POST['post_description'])) {
            $_SESSION['error_message']['text'] = "Description Empty!";
            header("Location: index.php");
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message']['text'] = "CSRF Token Validation failed!";
            header("Location: index.php"); 
            exit();
        }

        $post = new Post();
        $new_post = $post->create($_POST['post_description']);

        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .icon-like {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 antialiased leading-none font-sans">

    <div class="container mx-auto h-full flex">
        <div class="w-1/4 bg-white p-4 border-r border-gray-200">
            <ul>
                <li class="mb-4">
                    <a href="profile.php" class="text-gray-500 hover:text-blue-700">Profile</a>
                </li>
                <li class="mb-4">
                    <a href="index.php" class="text-blue-500 hover:text-blue-700">Home</a>
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
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <textarea name="post_description" id="post_description" class="w-full p-2 mt-2 border rounded" placeholder="Write your post here..."></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Post</button>
                </form>
            </div>

            <?php
            $post_inst = new Post();
            $posts = $post_inst->getPosts();

            $posts = array_reverse($posts);

            foreach ($posts as $post) :
            ?>
                <div class="mb-4 p-2 border-b border-gray-200">
                    <h3 class="font-bold text-black"><?php echo htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?></h3> </br>
                    <p class="text-gray-700"><?php echo htmlspecialchars($post['description'], ENT_QUOTES, 'UTF-8'); ?></p> </br>
                        <?php 
                            $postObj = new Post();
                            $isLikedByCurrentUser = $postObj->checkIfPostIsLikedByUser($post['id'], $_SESSION['id'], $connection);
                            echo '<p class="like-count text-gray-500">' . intval($post['likes']) . ' likes</p>';
                            echo '<button data-post-id="' . $post['id'] . '" class="like-btn p-2 hover:bg-gray-100 rounded transition duration-200 focus:outline-none" data-liked="' . ($isLikedByCurrentUser ? 'true' : 'false') . '">';
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="<?php echo $isLikedByCurrentUser ? 'currentColor' : 'none'; ?>" viewBox="0 0 24 24" stroke="<?php echo $isLikedByCurrentUser ? 'none' : 'currentColor'; ?>" class="icon-like h-6 w-6 <?php echo $isLikedByCurrentUser ? 'text-red-500' : 'text-gray-400'; ?>">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>

                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="../../public/js/social.js"></script>
</body>
</html>
