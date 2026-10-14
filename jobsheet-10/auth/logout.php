<?php
if (session_start() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
header('Location: login.php');
exit;