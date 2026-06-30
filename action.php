<?php

require_once "config.php";

$action = $_POST['action'] ?? '';

// check what action is requested
// login?
// signup?

if ($action == "login") {
    login();
} else if ($action == "signup") {
    signup();
}

// validate login
function login() {
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $findEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $findEmail);

    $user = mysqli_fetch_assoc($result);

    if (!$user) {
        echo "account does not exist";
    } else {
        if ($user['password'] == $password) echo "login successful";
        else echo "incorrect password";
    }
}

// add new account
function signup() {
    global $conn;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // check for duplicates
    $findEmail = "SELECT * FROM users WHERE email = '$email'";
    $duplicate = mysqli_query($conn, $findEmail);
    $user = mysqli_fetch_assoc($duplicate);

    if ($user) {
        echo "account already exists";
        return;
    }

    $addUser = "INSERT INTO users (name, email, password)
    VALUES ('$name', '$email', '$password')";

    $result = mysqli_query($conn, $addUser);

    if ($result) echo "signup successful";
    else echo "signup unsuccessful";
}

?>