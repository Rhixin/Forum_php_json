<?php
session_start();
include("functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</head>

<body>

    <div class="home_container">
        <div class="all_posts_box">
            <?php echo getPosts(); ?>
        </div>
        <?php echo displayLeftHeader(); ?>
        <?php include_once("header.php") ?>





    </div>


</body>

</html>

<?php

$users = getUsersData();

$posts = getPostsData();

$comments = getCommentsData();

$postsarr = array();

foreach ($posts as $post) {
    foreach ($users as $user) {
        if ($user['id'] == $post['uid']) {
            $post['uid'] = $user;

            break;
        }
    }
    $post['comments'] = array();
    foreach ($comments as $comment) {
        if ($post['id'] == $comment['postId']) {
            $post['comments'][] = $comment;
        }
    }
    $postarr[] = $post;
}

//count comments
$new_id = count($comments) + 1;

// Check which reply button was clicked
foreach ($postsarr as $parr) {
    if (isset($_POST['reply_btn_final_' . $parr['id']])) {
        // Handle the specific reply button click here
        $new_comment = [
            "postId" => $parr['id'],
            "id" => $new_id,
            "name" => $_SESSION['user_name'],
            "email" => "marionuss@ent.org",
            "body" => $_POST['reply_input']
        ];

        // Add the new user to the comments array
        array_push($comments, $new_comment);

        // Convert the updated comments array to JSON
        $json = json_encode($comments);

        // Write the JSON data to the file
        $file_name = "../data/comments.json";
        file_put_contents($file_name, $json);
    }
}
?>