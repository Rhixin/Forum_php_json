<?php
session_start();
include("functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comments = getCommentsData();
    $new_id = count($comments) + 1;

    global $commentsJSON;

    $new_comment = [
        "postId" => $_POST["post-id"],
        "id" => $new_id,
        "name" => $_SESSION['user_name'],
        "email" => $_SESSION['user_email'],
        "body" => htmlspecialchars($_POST["reply_input"]),
    ];

    $comments_array = getCommentsData();
    $comments_array[] = $new_comment;

    file_put_contents($commentsJSON, json_encode($comments_array, JSON_PRETTY_PRINT));
    header("Location: main.php");
    exit();
}