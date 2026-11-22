<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function wajib_login() {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit;
    }
}

function wajib_owner() {
    wajib_login();
    if (!isset($_SESSION['level']) || (int)$_SESSION['level'] !== 1) {
        header("Location: index.php?pesan=ditolak");
        exit;
    }
}