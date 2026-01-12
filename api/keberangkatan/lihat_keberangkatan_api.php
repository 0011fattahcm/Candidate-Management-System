<?php
include '../../db.php';
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");


    exit();
}

$id_keberangkatan = $_GET['id_keberangkatan'];
$response = ["success" => false, "data" => null];

if ($id_keberangkatan) {
    $query = "
        SELECT k.perusahaan, k.tsk, k.daerah, k.jenis_pekerjaan, k.mcu, k.kontrak_kerja,
               d.pas_foto, d.nama_lengkap, d.tanggal_lahir, d.tanggal_daftar
        FROM keberangkatan AS k
        JOIN kandidat AS d ON k.id_kandidat = d.id_kandidat
        WHERE k.id_keberangkatan = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_keberangkatan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $response["success"] = true;
        $response["data"] = $result->fetch_assoc();
    }
}

echo json_encode($response);
