<?php
session_start(); // Mulai session

$koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database"); // Menggunakan nama database yang baru, yaitu "my_database"

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $koneksi->real_escape_string($_GET['search']); // Escape input untuk mencegah SQL Injection

    $query = "SELECT * FROM questions WHERE question LIKE '%$search%' AND id NOT IN (SELECT question_id FROM answers)"; // Menggunakan tabel jawaban yang benar, yaitu "answers"
} else {
    $query = "SELECT * FROM questions WHERE id NOT IN (SELECT question_id FROM answers)"; // Menggunakan tabel jawaban yang benar, yaitu "answers"
}

$result = $koneksi->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="pertanyaan">';
        echo '<p>Pertanyaan: ' . $row["question"] . '</p>';
        echo '<form action="proses_jawaban.php" method="POST">';
        echo '<input type="hidden" name="question_id" value="' . $row["id"] . '">';
        echo '<div class="form-group">';
        echo '<label for="jawaban">Jawaban Anda:</label>';
        echo '<textarea class="form-control" name="jawaban" rows="3"></textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Kirim Jawaban</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "Tidak ada pertanyaan yang ditemukan.";
}

$koneksi->close();
?>
