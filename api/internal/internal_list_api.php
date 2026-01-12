<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include '../../db.php';
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");

    exit();
}
// Pastikan koneksi berhasil
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Pagination
$limit = 20; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query untuk mendapatkan data kandidat internal dengan urutan terbaru
$query = "SELECT id_kandidat AS id, pas_foto, nama_lengkap, tanggal_lahir, tanggal_daftar, status_administrasi, tanggal_lolos 
          FROM kandidat 
          WHERE jenis_kandidat = 'internal' 
          ORDER BY tanggal_daftar DESC 
          LIMIT $limit OFFSET $offset";

$result = $conn->query($query);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    // Jika tidak ada data ditemukan
    echo json_encode([
        'error' => 'No data found',
        'data' => [],
        'totalPages' => 0,
        'currentPage' => $page
    ]);
    exit();
}

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) AS total FROM kandidat WHERE jenis_kandidat = 'internal'";
$totalResult = $conn->query($totalQuery);

// Validasi hasil query untuk total data
if (!$totalResult) {
    echo json_encode(['error' => 'Failed to count total data']);
    exit();
}

$totalData = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Response JSON
echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
