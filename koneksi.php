<?php
$host = 'localhost'; 
$user = 'id22148748_culex'; 
$password = 'Culex@123'; 
$database = 'id22148748_my_database'; 

$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
