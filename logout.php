<?php
session_set_cookie_params([
    'httponly' => true,     
    'secure' => !$isLocal,     
    'samesite' => 'Strict'  
]);
session_start();

// Hapus semua session variables, destroy the session, lalu redirect ke halaman login
session_unset();
session_destroy();

header("location: login.php");
exit;
?> 