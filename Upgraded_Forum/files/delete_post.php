<?php
session_start();
include("functions.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    deletePost($_POST["post-id"]);
    header("Location: main.php");
    exit();
}