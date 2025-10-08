<?php
session_start();

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_username($username) {
    return preg_match('/^[A-Za-z0-9_]{3,20}$/', $username);
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

function generate_captcha() {
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    $_SESSION['captcha'] = $num1 + $num2;
    return "What is $num1 + $num2?";
}

function verify_captcha($input) {
    return isset($_SESSION['captcha']) && $_SESSION['captcha'] == $input;
}
?>
