<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../db.php'; // Koneksi database

// Ambil id_kandidat dari URL jika ada
$id_kandidat = isset($_GET['id_kandidat']) ? $_GET['id_kandidat'] : null;

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_kandidat = $_POST['id_kandidat'];
    $perusahaan = $_POST['perusahaan'];
    $tsk = $_POST['tsk'];
    $daerah = $_POST['daerah'];
    $jenis_pekerjaan = $_POST['jenis_pekerjaan'];
    $tanggal_keberangkatan = $_POST['tanggal_keberangkatan'];
    $informasi_tambahan = $_POST['informasi_tambahan'];

    // Konfigurasi direktori upload
    $uploadDir = '../../uploads/';
    $uploadPaths = [
        'mcu' => $uploadDir . 'mcu/',
        'kontrak_kerja' => $uploadDir . 'kontrak_kerja/',
    ];

    // Fungsi upload file
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

    // Upload file
    $mcu = uploadFile('mcu', $uploadPaths['mcu']);
    $kontrak_kerja = uploadFile('kontrak_kerja', $uploadPaths['kontrak_kerja']);

    // Query untuk menambahkan data keberangkatan
    $query = "
        INSERT INTO keberangkatan (id_kandidat, perusahaan, tsk, daerah, jenis_pekerjaan, tanggal_keberangkatan, mcu, kontrak_kerja, informasi_tambahan)
        VALUES ('$id_kandidat', '$perusahaan', '$tsk', '$daerah', '$jenis_pekerjaan', '$tanggal_keberangkatan', '$mcu', '$kontrak_kerja', '$informasi_tambahan')
    ";

    if (mysqli_query($conn, $query)) {
        echo "Data keberangkatan berhasil ditambahkan!";
        // Redirect ke halaman list keberangkatan setelah berhasil
        header("Location: keberangkatan_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Ambil data kandidat berdasarkan id_kandidat untuk mengisi form
$kandidatQuery = "SELECT * FROM kandidat WHERE id_kandidat = '$id_kandidat'";
$kandidatResult = mysqli_query($conn, $kandidatQuery);
$kandidatData = mysqli_fetch_assoc($kandidatResult);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Keberangkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Keberangkatan untuk <?= $kandidatData['nama_lengkap'] ?? 'Kandidat Tidak Ditemukan' ?></h1>

        <form action="" method="POST" enctype="multipart/form-data" class="mt-6 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id_kandidat" value="<?= $kandidatData['id_kandidat'] ?? '' ?>">

            <div class="mb-4">
                <label for="perusahaan" class="block text-gray-700 text-sm font-bold mb-2">Perusahaan</label>
                <input type="text" name="perusahaan" id="perusahaan" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tsk" class="block text-gray-700 text-sm font-bold mb-2">TSK</label>
                <input type="text" name="tsk" id="tsk" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="daerah" class="block text-gray-700 text-sm font-bold mb-2">Daerah</label>
                <input type="text" name="daerah" id="daerah" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="jenis_pekerjaan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Pekerjaan</label>
                <input type="text" name="jenis_pekerjaan" id="jenis_pekerjaan" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tanggal_keberangkatan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Keberangkatan</label>
                <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="informasi_tambahan" class="block text-gray-700 text-sm font-bold mb-2">Informasi Tambahan</label>
                <textarea name="informasi_tambahan" id="informasi_tambahan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Dokumen MCU (pdf, docx, xlsx)</label>
                <input type="file" name="mcu" accept=".pdf, .docx, .xlsx" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700">Dokumen Kontrak Kerja (pdf, docx, xlsx)</label>
                <input type="file" name="kontrak_kerja" accept=".pdf, .docx, .xlsx" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Tambah
                </button>
                <a href="keberangkatan_list.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
            </div>
        </form>
    </div>
</body>

</html>