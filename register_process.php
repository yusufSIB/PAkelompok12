<!-- register_process.php -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost", "id22148748_culex", "Culex@123", "id22148748_my_database");

    $username = $koneksi->real_escape_string($_POST['username']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $password = $koneksi->real_escape_string($_POST['password']);

    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = $koneksi->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($koneksi->query($insert_query) === TRUE) {
            header("Location: login.php");
        } else {
            echo "Error: " . $koneksi->error;
        }
    }

    $koneksi->close();
}
?>

