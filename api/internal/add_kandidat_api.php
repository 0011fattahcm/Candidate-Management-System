<?php
require '../../db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $golongan_darah = $_POST['golongan_darah'];
    $tinggi_badan = (float) $_POST['tinggi_badan'];
    $berat_badan = (float) $_POST['berat_badan'];
    $pendidikan_sd = $_POST['pendidikan_sd'];
    $pendidikan_smp = $_POST['pendidikan_smp'];
    $pendidikan_sma_smk = $_POST['pendidikan_sma_smk'];
    $jurusan_sma_smk = $_POST['jurusan_sma_smk'];
    $pendidikan_sarjana = $_POST['pendidikan_sarjana'];
    $jurusan_sarjana = $_POST['jurusan_sarjana'];
    $pendidikan_magister = $_POST['pendidikan_magister'] ?? null;
    $jurusan_magister = $_POST['jurusan_magister'] ?? null;
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $jenis_kandidat = "internal";
    $status_administrasi = "Pending";

    // Konfigurasi direktori upload
    $uploadDir = '../../uploads/';
    $uploadPaths = [
        'pas_foto' => $uploadDir . 'pas_foto/',
        'cv' => $uploadDir . 'cv/',
        'ssw' => $uploadDir . 'ssw/',
        'sertifikat_magang' => $uploadDir . 'magang/',
        'paspor' => $uploadDir . 'paspor/',
        'jlpt_jft' => $uploadDir . 'jlpt_jft/'
    ];

    function uploadFile($fileInput, $destination)
    {
        if (isset($_FILES[$fileInput]) && $_FILES[$fileInput]['error'] === 0) {
            $fileName = basename($_FILES[$fileInput]['name']);
            $targetPath = $destination . $fileName;

            if (!is_dir($destination)) {
                mkdir($destination, 0777, true);
            }

            if (move_uploaded_file($_FILES[$fileInput]['tmp_name'], $targetPath)) {
                return $targetPath;
            } else {
                die(json_encode(["status" => "error", "message" => "Gagal mengunggah $fileInput."]));
            }
        } else {
            return null;
        }
    }

    $pas_foto_path = uploadFile('pas_foto', $uploadPaths['pas_foto']);
    $cv_path = uploadFile('cv', $uploadPaths['cv']);
    $ssw_path = uploadFile('ssw', $uploadPaths['ssw']);
    $magang_path = uploadFile('sertifikat_magang', $uploadPaths['sertifikat_magang']);
    $paspor_path = uploadFile('paspor', $uploadPaths['paspor']);
    $jlpt_jft_path = uploadFile('jlpt_jft', $uploadPaths['jlpt_jft']);

    // Query SQL untuk kandidat
    $sql = "INSERT INTO kandidat (
        pas_foto, nama_lengkap, nama_ayah, nama_ibu, tanggal_lahir, alamat_lengkap, 
        golongan_darah, tinggi_badan, berat_badan, pendidikan_sd, pendidikan_smp, 
        pendidikan_sma_smk, jurusan_sma_smk, pendidikan_sarjana, jurusan_sarjana, 
        pendidikan_magister, jurusan_magister, nomor_hp, email, jenis_kelamin, agama, 
        jenis_kandidat, status_administrasi, tanggal_daftar, cv, ssw, 
        sertifikat_magang, paspor, jlpt_jft
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'sssssssddsssssssssssssssssss',
        $pas_foto_path,
        $nama_lengkap,
        $nama_ayah,
        $nama_ibu,
        $tanggal_lahir,
        $alamat_lengkap,
        $golongan_darah,
        $tinggi_badan,
        $berat_badan,
        $pendidikan_sd,
        $pendidikan_smp,
        $pendidikan_sma_smk,
        $jurusan_sma_smk,
        $pendidikan_sarjana,
        $jurusan_sarjana,
        $pendidikan_magister,
        $jurusan_magister,
        $nomor_hp,
        $email,
        $jenis_kelamin,
        $agama,
        $jenis_kandidat,
        $status_administrasi,
        $cv_path,
        $ssw_path,
        $magang_path,
        $paspor_path,
        $jlpt_jft_path
    );

    if ($stmt->execute()) {
        $kandidat_id = $stmt->insert_id;

        // Uraikan (decode) data riwayat pekerjaan yang diterima dari form
        $riwayat_pekerjaan = json_decode($_POST['riwayat_pekerjaan'], true) ?? [];

        foreach ($riwayat_pekerjaan as $pekerjaan) {
            // Pastikan setiap kolom ada dalam data riwayat pekerjaan
            if (isset($pekerjaan['nama_perusahaan'], $pekerjaan['jenis_pekerjaan'], $pekerjaan['tgl_masuk'], $pekerjaan['tgl_selesai'])) {
                $nama_perusahaan = $pekerjaan['nama_perusahaan'];
                $jenis_pekerjaan = $pekerjaan['jenis_pekerjaan'];
                $tgl_masuk = $pekerjaan['tgl_masuk'];
                $tgl_selesai = $pekerjaan['tgl_selesai'];

                $sql_pekerjaan = "INSERT INTO riwayat_pekerjaan (kandidat_id, nama_perusahaan, jenis_pekerjaan, tgl_masuk, tgl_selesai) VALUES (?, ?, ?, ?, ?)";
                $stmt_pekerjaan = $conn->prepare($sql_pekerjaan);
                $stmt_pekerjaan->bind_param('issss', $kandidat_id, $nama_perusahaan, $jenis_pekerjaan, $tgl_masuk, $tgl_selesai);
                $stmt_pekerjaan->execute();
            }
        }

        echo json_encode(["status" => "success", "message" => "Data kandidat dan riwayat pekerjaan berhasil ditambahkan."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menambahkan data: " . $stmt->error]);
    }


    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Metode tidak diizinkan."]);
}
