<?php
// users JSON
$usersJSON = '../data/users.json';

// posts JSON
$postsJSON = '../data/posts.json';

// comments JSON
$commentsJSON = '../data/comments.json';


// function get users from json
function getUsersData()
{
    global $usersJSON;
    if (!file_exists($usersJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($usersJSON);
    return json_decode($data, true);
}

// function get posts from json
function getPostsData()
{
    global $postsJSON;
    if (!file_exists($postsJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($postsJSON);
    return json_decode($data, true);
}

// function get comments from json
function getCommentsData()
{
    global $commentsJSON;
    if (!file_exists($commentsJSON)) {
        echo 1;
        return [];
    }

    $data = file_get_contents($commentsJSON);
    return json_decode($data, true);
}


function getPosts()
{
    $users = getUsersData();
    $posts = getPostsData();
    $comments = getCommentsData();
    $postsarr = array();

    // Reverse the order of posts
    $reversedPosts = array_reverse($posts);

    foreach ($reversedPosts as $post) {
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
        $postsarr[] = $post;
    }

    $str = "";

    foreach ($postsarr as $parr) {
        $str .= '<div class="model_box"' . (($_SESSION['user_id'] == $parr['uid']['id']) ? 'style="border: 10px solid #d3a223"' : '') . '>
            <div style="display: flex; flex-direction: row; margin-right: 5px; justify-content: space-between;">
                <div style="display: flex; width: auto">
                    <div style="width: 50px; height: 60px; margin-right: 10px">
                    <img src="https://ui-avatars.com/api/?rounded=true&name=' . $parr['uid']['name'] .  '" alt="user" width="50px" height="50px">
                    </div>
                    <p style="line-height: 50px; font-size: large">' . $parr['uid']['name'] . '</p>
                </div>' . (($_SESSION['user_id'] == $parr['uid']['id']) ? '<form action="delete_post.php" method="post">
                <input type="hidden" name="post-id" value="' . $parr["id"] . '">
                <button type="submit" style="height: 40px; width: 40px">X</button>
                </form>' : "") . '
            </div>
            
            <div class="title_box">
                <h3>' . $parr['title'] . '</h3>
            </div>
            <div class="body_box">' . $parr['body'] . '</div>
            <br>
            <h4>Comments</h4>';

        foreach ($parr['comments'] as $comm) {
            $str .= '<div class="model_box" id="comment_unique_id">
                <div style="display: flex; flex-direction: row; margin-right: 5px; justify-content: space-between;">
                <div style="display: flex; width: auto">
                    <div style="width: 50px; height: 60px; margin-right: 10px">
                    <img src="https://ui-avatars.com/api/?rounded=true&name=' . $comm['name'] .  '" alt="user" width="50px" height="50px">
                    </div>
                    <p style="line-height: 50px; font-size: large">' . $comm['name'] . '</p>
                </div>' . (($_SESSION['user_name'] == $comm['name']) ? '<form action="delete_comment.php" method="post">
                <input type="hidden" name="comment-id" value="' . $comm['id'] . '">
                <button type="submit" style="height: 40px; width: 40px">X</button>
                </form>' : "") . '
                </div>

                <div class="body_box">' . $comm['body'] . '</div>
            </div>';
        }

        $str .= '<form action="make_comment.php" method="post"><div class="reply_area">
            
            <textarea id="reply_input" name="reply_input" rows="2" placeholder="Reply something"></textarea>
            <input type="hidden" name="post-id" value="' . $parr["id"] . '">
            <button type="submit" class="btn btn-primary" name="reply_btn_final" id="reply_btn_final">Reply</button>
        </div></form>
        </div>';
    }


    return $str;
}





$users = getUsersData();

// Set variables to determine whether to display alerts
$user_present = false;
$wrong_password = false;

//LOG IN FUNCTION 
if (isset($_POST["log_in_btn"])) {
    $user_name = $_POST["log_in_username_input"];
    $pass_word = $_POST["log_in_password_input"];

    foreach ($users as $user) {
        if ($user['username'] == $user_name) {
            if ($user['password'] == $pass_word || password_verify($pass_word, $user['password'])) {
                $user_present = true;
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: main.php');
                exit();
            } else {
                $wrong_password = true;
            }
        }
    }

    if ($user_name == "" || $pass_word == "") {
        echo '<script>alert("Please Fill all the Forms");</script>';
    } else if ($wrong_password) {
        echo '<script>alert("You inputted a Wrong Password");</script>';
    } else if (!$user_present) {
        echo '<script>alert("User is not yet Created");</script>';
    } else if ($user_present && !$wrong_password) {
        echo '<script>alert("You inputted a Wrong Password");</script>';
    }
}





//SIGN UP FUNCTION 
// Validate and sanitize user inputs
$new_username = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupUsername"]) : "";
$new_password = isset($_POST["sign_up_btn_final"]) ? password_hash($_POST["signupPassword"], PASSWORD_DEFAULT) : "";
$new_first_name = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupFirstName"]) : "";
$new_last_name = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupLastName"]) : "";
$new_name = $new_first_name . " " . $new_last_name;
$new_gmail = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupEmail"]) : "";
$new_street = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupStreet"]) : "";
$new_barangay = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupBarangay"]) : "";
$new_city = isset($_POST["sign_up_btn_final"]) ? htmlspecialchars($_POST["signupCity"]) : "";

// Check if the form is submitted and required fields are not empty
if (isset($_POST["sign_up_btn_final"]) && (!empty($new_username) && !empty($new_password) && !empty($new_name) && !empty($new_gmail) && !empty($new_street) && !empty($new_barangay) && !empty($new_city))) {

    // Check if the username already exists
    $username_exists = false;
    foreach ($users as $user) {
        if ($user['username'] == $new_username) {
            $username_exists = true;
            break;
        }
    }

    // If username doesn't exist, proceed to create the account
    if (!$username_exists) {
        // Create a new user object
        $new_id = count($users) + 1;
        $new_person = [
            "id" => $new_id,
            "name" => $new_name,
            "username" => $new_username,
            "password" => $new_password,
            "email" => $new_gmail,
            "address" => [
                "street" => $new_street,
                "barangay" => $new_barangay,
                "city" => $new_city
            ]
        ];

        // Add the new user to the users array
        array_push($users, $new_person);

        // Convert the updated users array to JSON
        $json = json_encode($users);

        // Write the JSON data to the file
        $file_name = "../data/users.json";
        file_put_contents($file_name, $json);

        // Display a success message
        echo '<script>alert("Successfully Created an Account");</script>';
    } else {
        // Display an error message if the username already exists
        echo '<script>alert("Username ' . $new_username . ' already exists. Please choose a different username.");</script>';
    }
} else if (isset($_POST["sign_up_btn_final"])) {
    // Display an error message only if the form is submitted
    echo '<script>alert("Please Fill all the Forms");</script>';
}
?>


<?php
//MAIN PAGE FUNCIONS
//session_start();

function displayLeftHeader()
{
    $user_name = $_SESSION['user_name'];

    return '<div class="left_header"><form method="post" ><br><br><br>
    <div style="display: flex; flex-direction: column; justify-content: center; align-items: center">
        <div style="display: flex; flex-direction: row; margin-right: 5px">
            <div style="width: 50px; height: 60px; margin-right: 10px">
                <img src="https://ui-avatars.com/api/?rounded=true&name=' . $user_name . '" alt="user" width="50px" height="50px">
            </div>
            <p style="line-height: 50px; font-size: large">' . $user_name . '</p>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input type="text" class="form-control own_input_box" name="title_input" placeholder="Enter Title">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
            <textarea type="text" class="form-control own_input_box" name="body_input" rows="10" placeholder="What\'s on your mind?"></textarea>
        </div>
        
    <button type="submit" class="btn btn-primary" name="post_btn_final" id="post_btn">Create Post</button>

    </div></div>';
}

//LOG OUT FUNCTION 
if (isset($_POST["log_out_btn_final"])) {
    // Clear all session variables
    //session_unset();
    session_destroy();
    header('Location: log_in_page.php');
    exit();
}

//CREATE POST FUNCTION 
if (isset($_POST["post_btn_final"]) && !empty($_POST["title_input"]) && !empty($_POST["body_input"])) {
    $new_title = $_POST["title_input"];
    $new_body = $_POST["body_input"];

    $posts = getPostsData();
    $new_id = createNewPostID();
    $new_post = [
        "uid" => $_SESSION['user_id'],
        "id" => $new_id,
        "title" => $new_title,
        "body" => $new_body,
    ];

    // Add the new user to the users array
    array_push($posts, $new_post);

    // Convert the updated users array to JSON
    $json = json_encode($posts);

    // Write the JSON data to the file
    $file_name = "../data/posts.json";
    file_put_contents($file_name, $json);
    //echo '<script> alert(1); </script>';
}

function createNewPostID()
{
    $id = 0;
    $data = getPostsData();
    foreach ($data as $postData) {
        $id = $postData["id"];
    }

    return $id + 1;
}

function deletePost($post_id)
{
    global $postsJSON, $commentsJSON;
    $postsData = getPostsData();

    foreach ($postsData as $index => $post) {
        if ($post["id"] === intval($post_id)) {
            unset($postsData[$index]);
            break;
        }
    }


    $temp = array();
    foreach ($postsData as $post) {
        $temp[] = $post;
    }
    file_put_contents($postsJSON, json_encode($temp, JSON_PRETTY_PRINT));


    $commentsData = getCommentsData();

    foreach ($commentsData as $index => $comment) {
        if ($comment["postId"] == ($post_id)) {
            unset($commentsData[$index]);
        }
    }

    file_put_contents($commentsJSON, json_encode($commentsData, JSON_PRETTY_PRINT));
}

function deleteComment($comment_id)
{
    global $commentsJSON;
    $commentsData = getCommentsData();

    foreach ($commentsData as $index => $comment) {
        if ($comment["id"] === intval($comment_id)) {
            unset($commentsData[$index]);
            break;
        }
    }

    $temp = array();
    foreach ($commentsData as $comment) {
        $temp[] = $comment;
    }

    file_put_contents($commentsJSON, json_encode($temp, JSON_PRETTY_PRINT));
}


?>