<?php
session_start();

// Cek apakah user sudah login
$host = 'localhost';     // Host database
$db = 'database_k8';   // Ganti dengan nama database kamu
$user = 'root';          // Username database
$pass = '';              // Password database

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah form login sudah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mencegah SQL Injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah user ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil, simpan data ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Login berhasil. Selamat datang, " . $user['username'];
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    $stmt->close();
}

$conn->close();
// Cek role user

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .dashboard-container {
            text-align: center;
            padding: 20px;
        }
        .welcome-message {
            margin-bottom: 20px;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        .logout-btn:hover {
            background-color: #d32f2f;
        }
        .admin-panel {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .admin-panel h3 {
            color: #1976d2;
            margin-bottom: 15px;
        }
        .admin-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #2196f3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 5px;
        }
        .admin-btn:hover {
            background-color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container dashboard-container">
            <h2>Selamat Datang</h2>
            <div class="welcome-message">
                <p>Halo, ?????</p>
                <p>Role: ?????</p>
                <p>Anda telah berhasil login ke sistem.</p>
            </div>

            <?php if ($isAdmin): ?>
            <div class="admin-panel">
                <h3>Admin Panel</h3>
                <a href="#" class="admin-btn">Kelola User</a>
                <a href="#" class="admin-btn">Lihat Log</a>
                <a href="#" class="admin-btn">Pengaturan</a>
            </div>
            <?php else: ?>
            <div class="user-panel">
                <p>Selamat datang di dashboard user.</p>
                <a href="#" class="admin-btn">Profil Saya</a>
                <a href="#" class="admin-btn">Ubah Password</a>
            </div>
            <?php endif; ?>

            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html> 