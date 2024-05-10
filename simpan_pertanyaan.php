<?php
session_start();

if(isset($_SESSION['user_id']) && isset($_POST['questions'])) {
    // Koneksi ke database
    $koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database");
    // Periksa koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }
    
    // Escape string untuk mencegah serangan SQL injection
    $questions = $koneksi->real_escape_string($_POST['questions']);
    
    // Query SQL untuk menyimpan pertanyaan
    $sql = "INSERT INTO questions (questions) VALUES ('$questions')";

    if ($koneksi->query($sql) === TRUE) {
        echo "Pertanyaan berhasil disimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
    
    // Tutup koneksi
    $koneksi->close();
} else {
    echo "Pengguna tidak valid atau pertanyaan tidak tersedia.";
    // Atau redirect pengguna ke halaman yang sesuai
}
?>
