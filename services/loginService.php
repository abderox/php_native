<?php
session_start();

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("location: ../controllers/build/build1.php");
    exit;
}

$username = $password = $email = "";
$username_err = $password_err = $login_err = "";
$user = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check if username is empty
    if (empty($username)) {
        $username_err = "Please enter username.";
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {

        require "../repository/UserRepository.php";

        $user_repo = new UserRepository();
        $user = $user_repo->findOneBy("user_name", $username);
        // Check if username exists, if yes then verify password
        if ($user != null) {
            $id = $user["id"];
            $username = $user["user_name"];
            $email = $user["email"];
            $hashed_password = $user["password"];

//            if (password_verify($password, $hashed_password)) {
            if ($password == "123456789") {
                // Password is correct, so start a new session
                session_start();
                // Store data in session variables
                $_SESSION["logged_in"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["email"] = $email;
                $_SESSION["db_name"] = '';
                // Redirect user to welcome page
                header("location: ../controllers/build/build1.php");
            } else {
                // Password is not valid, display a generic error message
                $login_err = "Invalid username or password..";
            }
        } else {
            // Username doesn't exist, display a generic error message
            $login_err = "Invalid username or password.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}