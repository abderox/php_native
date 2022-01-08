<?php
//
//// Define variables and initialize with empty values
//$username = $password = $confirm_password = $email = "";
//$username_err = $password_err = $confirm_password_err = $email_err = "";
//
//// Processing form data when form is submitted
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//
//    require "../repository/UserRepository.php";
//    $user_repo = new UserRepository();
//    $username = trim($_POST["username"]);
//
//    // Validate username
//    if (empty($username)) {
//        $username_err = "Please enter a username.";
//    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
//        $username_err = "Username can only contain letters, numbers, and underscores.";
//    } else {
//        $user = $user_repo->findOneBy("user_name", $username);
//        // Check if username exists, if yes then verify password
//        if ($user != null) {
//            $username_err = "This username is already taken.";
//        }
//    }
//
//
//// Validate password
//    if (empty(trim($_POST["password"]))) {
//        $password_err = "Please enter a password.";
//    } elseif (strlen(trim($_POST["password"])) < 6) {
//        $password_err = "Password must have atleast 6 characters.";
//    } else {
//        $password = trim($_POST["password"]);
//    }
//
//// Validate confirm password
//    if (empty(trim($_POST["confirm_password"]))) {
//        $confirm_password_err = "Please confirm password.";
//    } else {
//        $confirm_password = $_POST["confirm_password"];
//        if (empty($password_err) && ($password != $confirm_password)) {
//            $confirm_password_err = "Password did not match.";
//        }
//    }
//
//// Check input errors before inserting in database
//    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
//
//        $hash_password = password_hash($password, PASSWORD_DEFAULT);
//
//        $new_user = $user_repo->addUser($username, $email, $password);
//    }
//}


// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require "../repository/UserRepository.php";
    $user_repo = new UserRepository();
    $username = trim($_POST["username"]);

    // Validate username
    if (empty($username)) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $user = $user_repo->findOneBy("user_name", $username);
        // Check if username exists, if yes then verify password
        if ($user != null) {
            $username_err = "This username is already taken.";
        }
    }


// Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

// Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

// Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $new_user = $user_repo->addUser($username, $email, $hash_password);
    }
}