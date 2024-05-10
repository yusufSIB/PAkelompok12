<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST['jawaban'])) {
    header("Location: homepage.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Periksa apakah question_id ada dalam $_POST
if (isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];
} else {
    // Jika tidak, arahkan pengguna kembali ke halaman utama
    header("Location: homepage.php");
    exit;
}

$jawaban = $koneksi->real_escape_string($_POST['jawaban']); 

if (empty($jawaban)) {
    header("Location: homepage.php");
    exit;
}

$sql = "INSERT INTO answers (answer, question_id, user_id) VALUES ('$jawaban', '$question_id', '$user_id')";

if ($koneksi->query($sql) === TRUE) {
    header("Location: homepage.php");
    exit; 
} else {
    echo "Error: " . $sql . "<br>" . $koneksi->error;
}

$koneksi->close();
?>
