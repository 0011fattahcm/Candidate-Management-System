<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../db.php'; // Koneksi database

// Ambil id_kandidat dari URL jika ada
$id_kandidat = isset($_GET['id_kandidat']) ? $_GET['id_kandidat'] : null;

// Ambil data keberangkatan berdasarkan id_kandidat
$query = "
    SELECT k.*, b.perusahaan, b.tsk, b.daerah, b.jenis_pekerjaan, b.tanggal_keberangkatan, b.mcu, b.kontrak_kerja, b.informasi_tambahan
    FROM kandidat k
    LEFT JOIN keberangkatan b ON k.id_kandidat = b.id_kandidat
    WHERE k.id_kandidat = '$id_kandidat'
";

$result = mysqli_query($conn, $query);
$keberangkatanData = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Keberangkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="flex flex-wrap justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Detail Keberangkatan</h1>
            <button onclick="history.back()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Kembali
            </button>
        </div>

        <div id="detailKeberangkatan" class="mt-6 bg-white p-6 shadow-md rounded">
            <table class="min-w-full border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="2">Detail Keberangkatan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pas Foto</strong></td>
                        <td class="border border-gray-300 py-3 px-3">
                            <?php if (!empty($keberangkatanData['pas_foto'])): ?>
                                <img src="../../uploads/pas_foto/<?= $keberangkatanData['pas_foto'] ?>" alt="Pas Foto" class="max-w[80px] object-cover">
                            <?php else: ?>
                                Tidak ada pas foto
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nama Lengkap</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['nama_lengkap'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Daftar</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['tanggal_daftar'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Lahir</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['tanggal_lahir'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Alamat</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['alamat_lengkap'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Perusahaan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['perusahaan'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>TSK</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['tsk'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Daerah</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['daerah'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jenis Pekerjaan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['jenis_pekerjaan'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Keberangkatan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['tanggal_keberangkatan'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Informasi Tambahan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><?= $keberangkatanData['informasi_tambahan'] ?? 'Data tidak ditemukan' ?></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Dokumen MCU</strong></td>
                        <td class="border border-gray-300 py-3 px-3">
                            <?php if (!empty($keberangkatanData['mcu'])): ?>
                                <a href="<?= $keberangkatanData['mcu'] ?>" target="_blank" class="text-white bg-blue-700 p-2 shadow-md">Lihat Dokumen MCU</a>
                            <?php else: ?>
                                Tidak ada dokumen
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Dokumen Kontrak Kerja</strong></td>
                        <td class="border border-gray-300 py-3 px-3">
                            <?php if (!empty($keberangkatanData['kontrak_kerja'])): ?>
                                <a href="<?= $keberangkatanData['kontrak_kerja'] ?>" target="_blank" class="text-white bg-blue-700 p-2 shadow-md">Lihat Dokumen Kontrak Kerja</a>
                            <?php else: ?>
                                Tidak ada dokumen
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>