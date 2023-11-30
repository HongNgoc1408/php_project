<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
} else {
    htmlspecialchars('Không đăng xuất thành công!');
}