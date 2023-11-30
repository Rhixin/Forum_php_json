<?php
session_start();
include("functions.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    deleteComment($_POST["comment-id"]);
    header("Location: main.php");
    exit();
}