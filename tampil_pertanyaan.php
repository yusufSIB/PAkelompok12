<?php
// Mulai session
session_start();

// Buat koneksi ke database
$koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil pertanyaan dari tabel "questions" beserta informasi pengguna yang mengajukan
$query = "SELECT q.*, u.username AS asker_username 
          FROM questions q 
          LEFT JOIN users u ON q.user_id = u.id";
$result = $koneksi->query($query);

// Periksa apakah terdapat pertanyaan dalam hasil query
if ($result && $result->num_rows > 0) {
    // Jika ada, tampilkan pertanyaan beserta form untuk menjawab
    while ($row = $result->fetch_assoc()) {
        echo '<div class="pertanyaan">';
        echo '<p>Pertanyaan dari ' . $row["asker_username"] . ': ' . $row["question"] . '</p>';
        
        // Ambil ID pertanyaan
        $question_id = $row["id"];
        
        // Query untuk mengambil jawaban yang terkait dengan pertanyaan ini
        $query_answers = "SELECT a.*, u.username AS answerer_username 
                          FROM answers a 
                          LEFT JOIN users u ON a.user_id = u.id 
                          WHERE a.question_id = $question_id";
        $result_answers = $koneksi->query($query_answers);
        
        // Periksa apakah terdapat jawaban
        if ($result_answers && $result_answers->num_rows > 0) {
            // Jika ada, tampilkan jawaban
            while ($row_answer = $result_answers->fetch_assoc()) {
                echo '<div class="jawaban">';
                echo '<p>Jawaban dari ' . $row_answer["answerer_username"] . ': ' . $row_answer["answer"] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Belum ada jawaban untuk pertanyaan ini.</p>';
        }
        
        // Form untuk menjawab pertanyaan
        echo '<form action="proses_jawaban.php" method="POST">';
        echo '<input type="hidden" name="question_id" value="' . $question_id . '">';
        echo '<div class="form-group">';
        echo '<label for="jawaban">Jawaban Anda:</label>';
        echo '<textarea class="form-control" id="jawaban" name="jawaban" rows="3"></textarea>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Kirim Jawaban</button>';
        echo '</form>';
        
        echo '</div>';
    }
} else {
    // Jika tidak ada pertanyaan dalam tabel
    echo "Tidak ada pertanyaan.";
}

// Tutup koneksi
$koneksi->close();
?>
