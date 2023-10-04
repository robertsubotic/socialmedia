<?php
    require_once "../config/config.php";
    require_once "../classes/Post.php";

    header('Content-Type: application/json');

    $post = new Post();
    $post_like = $post->likePost();
    
    echo json_encode($post_like);
    exit();
?>