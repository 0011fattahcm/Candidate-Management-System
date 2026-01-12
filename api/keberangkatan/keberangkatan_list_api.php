<?php
include '../../db.php'; // Koneksi database
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");

    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Batas jumlah data per halaman
$offset = ($page - 1) * $limit;

// Query untuk mengambil data keberangkatan dengan kandidat status interview 'Lolos'
$query = "
    SELECT k.id_keberangkatan, k.id_kandidat, k.perusahaan, k.tsk, k.daerah, 
           k.jenis_pekerjaan, k.tanggal_keberangkatan, k.informasi_tambahan, 
           kd.nama_lengkap 
    FROM keberangkatan k
    JOIN kandidat kd ON k.id_kandidat = kd.id 
    WHERE kd.status_interview = 'Lolos'
    LIMIT $limit OFFSET $offset
";

$result = mysqli_query($conn, $query);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Hitung total halaman
$countQuery = "
    SELECT COUNT(*) as total 
    FROM keberangkatan k
    JOIN kandidat kd ON k.id_kandidat = kd.id
    WHERE kd.status_interview = 'Lolos'
";
$countResult = mysqli_query($conn, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

// Mengirimkan response dalam bentuk JSON
echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
