<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $inputPassword = $_POST["password"];
    
    $_SESSION['form_data'] = [
        'username' => $username
    ];

    # cek apakah username ada
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    # store result and bind
    $stmt->store_result();

    // jika user ditemukan
    if($stmt->num_rows == 1) {
        $stmt->bind_result($id, $dbUsername, $dbHashedPassword, $role);
        $stmt->fetch();

        // verifikasi password
        if(password_verify($inputPassword, $dbHashedPassword)) {
            // true
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $dbUsername;
            $_SESSION['role'] = $role;
            $_SESSION['success'] = "Login berhasil!! Selamat Datang $dbUsername!";
            header("Location: ../dashboard.php");
            exit();
        } else {
            // false
            $_SESSION['error'] = 'Password salah. Silahkan coba lagi';
            header("Location: ../login.php");
            exit();
        }
    } else {
        // username tidak ditemukan
        $_SESSION['error'] = 'Username tidak ditemukan.';
        header('Location: ../login.php');
        exit();
    }

    $stmt->close();
}
?> 