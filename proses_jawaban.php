<?php
session_start();
    if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "my_database");
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['jawaban'])) {
        $question_id = $_POST['question_id'];
        $jawaban = $koneksi->real_escape_string($_POST['jawaban']); 
        if (!empty($jawaban)) {
            $sql = "INSERT INTO answers (answer, question_id, user_id) VALUES ('$jawaban', '$question_id','$user_id')";
            if ($koneksi->query($sql) === TRUE) {
                header("Location: homepage.php");
                exit; 
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }
        } else {
            header("Location: homepage.php");
            exit;
        }
    } else {
        header("Location: homepage.php");
        exit;
    }
    $koneksi->close();
} else {
    header("Location: homepage.php");
    exit();
}
?>
