<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database");
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']);

    $query = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();   
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: homepage.php");
        exit(); 
    } else {
        $_SESSION['error'] = "Username atau password salah.";
        header("Location: login.php");
        exit(); 
    }

    // Tutup koneksi
    $koneksi->close();
}
?>
