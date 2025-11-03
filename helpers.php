<?php
// helpers.php
if (session_status() === PHP_SESSION_NONE) session_start();

function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php'); exit;
    }
}
function is_role($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}
function sanitize($v) {
    return htmlspecialchars(trim($v));
}
function json_response($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
