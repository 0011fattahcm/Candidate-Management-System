<?php
// lihat_kandidat_api.php

// Include file koneksi database
include '../../db.php';
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

header('Content-Type: application/json'); // Header untuk format JSON
header('Access-Control-Allow-Origin: *');

// Validasi apakah parameter 'id_kandidat' dikirim dan valid
if (isset($_GET['id_kandidat']) && is_numeric($_GET['id_kandidat'])) {
    $id = intval($_GET['id_kandidat']); // Pastikan ID adalah integer

    try {
        // Query untuk mengambil data kandidat
        $query = "
            SELECT 
                id_kandidat, pas_foto, nama_lengkap, email, nomor_hp, 
                nama_ayah, nama_ibu, tanggal_lahir, alamat_lengkap, 
                golongan_darah, tinggi_badan, berat_badan, pendidikan_sd, 
                pendidikan_smp, pendidikan_sma_smk, jurusan_sma_smk, 
                pendidikan_sarjana, jurusan_sarjana, pendidikan_magister, 
                jurusan_magister, jenis_kelamin, agama, cv, ssw, 
                sertifikat_magang, paspor, jlpt_jft
            FROM kandidat 
            WHERE id_kandidat = ?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Periksa apakah data ditemukan
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $baseUrl = 'http://localhost/candidate-management-jeca/uploads/'; // URL dasar

            // Fungsi untuk sanitasi file
            function sanitizeFilePath($file)
            {
                return $file ? basename($file) : null;
            }

            // Format URL dokumen
            $data['cv'] = $data['cv'] ? $baseUrl . 'cv/' . sanitizeFilePath($data['cv']) : null;
            $data['ssw'] = $data['ssw'] ? $baseUrl . 'ssw/' . sanitizeFilePath($data['ssw']) : null;
            $data['sertifikat_magang'] = $data['sertifikat_magang'] ? $baseUrl . 'sertifikat/' . sanitizeFilePath($data['sertifikat_magang']) : null;
            $data['paspor'] = $data['paspor'] ? $baseUrl . 'paspor/' . sanitizeFilePath($data['paspor']) : null;
            $data['jlpt_jft'] = $data['jlpt_jft'] ? $baseUrl . 'jlpt_jft/' . sanitizeFilePath($data['jlpt_jft']) : null;

            // Query riwayat pekerjaan
            $query_riwayat = "
                SELECT 
                    nama_perusahaan, jenis_pekerjaan, tgl_masuk, tgl_selesai
                FROM riwayat_pekerjaan 
                WHERE kandidat_id = ?";

            $stmt_riwayat = $conn->prepare($query_riwayat);
            $stmt_riwayat->bind_param('i', $id);
            $stmt_riwayat->execute();
            $result_riwayat = $stmt_riwayat->get_result();

            // Array untuk data riwayat pekerjaan
            $data['riwayat_pekerjaan'] = [];
            while ($row = $result_riwayat->fetch_assoc()) {
                $data['riwayat_pekerjaan'][] = $row;
            }

            echo json_encode(['success' => true, 'data' => $data], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data kandidat tidak ditemukan']);
        }

        // Tutup statement
        $stmt_riwayat->close();
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID kandidat tidak valid atau tidak disediakan']);
}

// Tutup koneksi
$conn->close();
