<?php
session_start();
include("functions.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In/ Sign up Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container">

        <form method="post">
            <div class="bigger_box glow-border">
                <div id="side_pic"></div>
                <div class="big_box">

                    <input type="text" id="log_in_username" class="form-control" placeholder="Username"
                        name="log_in_username_input">
                    <div class="input-group">
                        <input type="password" id="log_in_password" class="form-control"
                            aria-describedby="passwordHelpBlock" placeholder="Password" name="log_in_password_input">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <ion-icon name="eye-outline" id="showPassword"
                                    onclick="togglePasswordVisibility('log_in_password', 'showPassword')"></ion-icon>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="log_in_btn" name="log_in_btn">Log In</button>
                    <br>
                    <div style="display: flex; justify-content: center; align-items: center;  margin: 10px">
                        <a href="https://www.youtube.com/results?search_query=ai+documentary"
                            style="text-align: center; padding: 10px; color: white">Forgot
                            password?</a>
                    </div>

                    <hr>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" id="sign_up_btn" data-bs-toggle="modal"
                        data-bs-target="#signupModal">
                        Create New Account
                    </button>

                    <!-- Signup Modal -->
                    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog"
                        aria-labelledby="signupModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="signupModalLabel" style="color: white">Sign Up</h3>

                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <!-- Your sign-up form elements go here -->
                                    <div class="mb-3 mb_new">
                                        <input type="text" class="form-control names_input" name="signupFirstName"
                                            placeholder="First Name">
                                        <input type="text" class="form-control names_input" name="signupLastName"
                                            placeholder="Last Name">
                                    </div>
                                    <div class="mb-3 ">
                                        <input type="text" class="form-control normal_input" name="signupUsername"
                                            placeholder="Username">
                                    </div>

                                    <div class="mb-3">
                                        <input type="password" class="form-control normal_input" name="signupPassword"
                                            placeholder="Password">
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" class="form-control normal_input" name="signupEmail"
                                            placeholder="Email">
                                    </div>

                                    <div style="width: 95%">
                                        <p style="color: gray">Address</p>
                                    </div>
                                    <div class="mb-3 mb_new">
                                        <input type="text" class="form-control address_input" name="signupStreet"
                                            placeholder="Street">
                                        <input type="text" class="form-control address_input" name="signupBarangay"
                                            placeholder="Barangay">
                                        <input type="text" class="form-control address_input" name="signupCity"
                                            placeholder="City">
                                    </div>
                                    <!-- Add more fields as needed -->
                                    <button type="submit" class="btn btn-primary" name="sign_up_btn_final"
                                        id="sign_up_btn_final">Create
                                        Account</button>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>




    </div>

</body>

</html>



<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>


<script>
function togglePasswordVisibility(passwordFieldId, iconId) {
    const passwordField = document.getElementById(passwordFieldId);
    const icon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.setAttribute("name", "eye-outline");
    } else {
        passwordField.type = "password";
        icon.setAttribute("name", "eye-off-outline");
    }
}
</script>