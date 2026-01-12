<?php
$servername = "localhost"; // atau alamat server MySQL
$username = "root"; // ganti dengan username MySQL
$password = ""; // ganti dengan password MySQL
$dbname = "candidate_management"; // nama database 

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
