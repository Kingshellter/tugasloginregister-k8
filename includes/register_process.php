<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $_SESSION['form_data'] = [
        'username' => $username,
        'email' => $email,
    ];

    //Ketika password tidak sama
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Konfirmasi password tidak cocok.";
        header("Location: ../register.php");
        exit();
    }

    $checkUsername = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();
    $checkUsername->store_result();

    //Ketika username sudah ada
    if ($checkUsername->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan. Silakan pilih yang lain.";
        $checkUsername->close();
        header("Location: ../register.php");
        exit();
    }
    $checkUsername->close();

    //Password Hashed
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertUser = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $role = 'user';
    $insertUser->bind_param("ssss", $username, $email, $hashedPassword, $role);

    //Ketika register berhasil
    if ($insertUser->execute()) {
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        $insertUser->close();
        header("Location: ../login.php");
        exit();
    //Ketika register gagal
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi: " . $insertUser->error;
        $insertUser->close();
        header("Location: ../register.php");
        exit();
    }
}
?>