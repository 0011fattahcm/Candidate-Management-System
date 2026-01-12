<?php
// Include koneksi database
include '../../db.php';
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

// Set header response JSON
header('Content-Type: application/json');

// Inisialisasi response default
$response = ['success' => false, 'message' => 'Terjadi kesalahan'];

// Periksa apakah metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil ID kandidat dari request
    $id = $_POST['id'] ?? null;

    if ($id) {
        // Persiapkan query untuk menghapus kandidat berdasarkan ID
        $query = "DELETE FROM kandidat WHERE id_kandidat = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            // Binding parameter ID dan eksekusi query
            $stmt->bind_param('i', $id);

            if ($stmt->execute()) {
                // Berhasil menghapus kandidat
                $response['success'] = true;
                $response['message'] = 'Kandidat berhasil dihapus';
            } else {
                // Gagal menghapus data kandidat
                $response['message'] = 'Gagal menghapus kandidat: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            // Gagal mempersiapkan query
            $response['message'] = 'Query gagal dipersiapkan';
        }
    } else {
        // ID kandidat tidak ditemukan dalam request
        $response['message'] = 'ID kandidat tidak ditemukan';
    }
} else {
    // Metode request tidak valid
    $response['message'] = 'Metode request tidak valid';
}

// Tutup koneksi dan kirim respons JSON
$conn->close();
echo json_encode($response);
