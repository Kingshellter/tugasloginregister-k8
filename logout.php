<?php
session_start();

// Hapus semua session variables, destroy the session, lalu redirect ke halaman login
session_destroy();

header("location:.../login.php?pesan=logout");
exit;
?> 