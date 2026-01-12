<?php
// Koneksi ke database
include('db.php');
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");

    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_kandidat = $_POST['id_kandidat'];
    $perusahaan = $_POST['perusahaan'];
    $jadwal_interview = $_POST['jadwal_interview'];
    $hasil_interview = $_POST['hasil_interview'];
    $catatan = $_POST['catatan'];

    // Query untuk menambah data interview
    $query = "INSERT INTO interview (id_kandidat, perusahaan, jadwal_interview, hasil_interview, catatan) 
              VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('issss', $id_kandidat, $perusahaan, $jadwal_interview, $hasil_interview, $catatan);

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
        echo "Data interview berhasil ditambahkan.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
