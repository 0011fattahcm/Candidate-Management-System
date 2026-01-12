<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../db.php'; // Koneksi database

// Ambil id_keberangkatan dari URL jika ada
$id_keberangkatan = isset($_GET['id_keberangkatan']) ? $_GET['id_keberangkatan'] : null;

// Ambil data keberangkatan berdasarkan id_keberangkatan
$query = "SELECT * FROM keberangkatan WHERE id_keberangkatan = '$id_keberangkatan'";
$result = mysqli_query($conn, $query);
$dataKeberangkatan = mysqli_fetch_assoc($result);

function uploadFile($file, $target_dir)
{
    if ($file['error'] === UPLOAD_ERR_OK) {
        $target_file = $target_dir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            return basename($file['name']);
        }
    }
    return null;
}

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

    // Direktori upload
    $mcu_dir = "../../uploads/mcu/";
    $kontrak_kerja_dir = "../../uploads/kontrak_kerja/";

    // Upload file MCU dan kontrak kerja
    $mcu = uploadFile($_FILES['mcu'], $mcu_dir) ?? $dataKeberangkatan['mcu'];
    $kontrak_kerja = uploadFile($_FILES['kontrak_kerja'], $kontrak_kerja_dir) ?? $dataKeberangkatan['kontrak_kerja'];

    // Query untuk mengupdate data keberangkatan
    $updateQuery = "
        UPDATE keberangkatan
        SET 
            id_kandidat = '$id_kandidat',
            perusahaan = '$perusahaan',
            tsk = '$tsk',
            daerah = '$daerah',
            jenis_pekerjaan = '$jenis_pekerjaan',
            tanggal_keberangkatan = '$tanggal_keberangkatan',
            informasi_tambahan = '$informasi_tambahan',
            mcu = '$mcu',
            kontrak_kerja = '$kontrak_kerja'
        WHERE id_keberangkatan = '$id_keberangkatan'
    ";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Data keberangkatan berhasil diperbarui!";
        header("Location: keberangkatan_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Keberangkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Keberangkatan</h1>

        <form action="" method="POST" enctype="multipart/form-data" class="mt-6 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <input type="hidden" name="id_kandidat" value="<?= $dataKeberangkatan['id_kandidat'] ?? '' ?>">

            <div class="mb-4">
                <label for="perusahaan" class="block text-gray-700 text-sm font-bold mb-2">Perusahaan</label>
                <input type="text" name="perusahaan" id="perusahaan" value="<?= $dataKeberangkatan['perusahaan'] ?? '' ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tsk" class="block text-gray-700 text-sm font-bold mb-2">TSK</label>
                <input type="text" name="tsk" id="tsk" value="<?= $dataKeberangkatan['tsk'] ?? '' ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="daerah" class="block text-gray-700 text-sm font-bold mb-2">Daerah</label>
                <input type="text" name="daerah" id="daerah" value="<?= $dataKeberangkatan['daerah'] ?? '' ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="jenis_pekerjaan" class="block text-gray-700 text-sm font-bold mb-2">Jenis Pekerjaan</label>
                <input type="text" name="jenis_pekerjaan" id="jenis_pekerjaan" value="<?= $dataKeberangkatan['jenis_pekerjaan'] ?? '' ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="tanggal_keberangkatan" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Keberangkatan</label>
                <input type="date" name="tanggal_keberangkatan" id="tanggal_keberangkatan" value="<?= $dataKeberangkatan['tanggal_keberangkatan'] ?? '' ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="informasi_tambahan" class="block text-gray-700 text-sm font-bold mb-2">Informasi Tambahan</label>
                <textarea name="informasi_tambahan" id="informasi_tambahan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= $dataKeberangkatan['informasi_tambahan'] ?? '' ?></textarea>
            </div>

            <div>
                <label for="mcu" class="block text-gray-700 text-sm font-bold mb-2">MCU</label>
                <input type="file" id="mcu" name="mcu" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php if (!empty($dataKeberangkatan['mcu'])): ?>
                    <p>File saat ini:
                        <a href="../../uploads/mcu/<?= $dataKeberangkatan['mcu'] ?>" target="_blank" class="text-blue-500 underline">
                            <?= $dataKeberangkatan['mcu'] ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <div>
                <label for="kontrak_kerja" class="block text-gray-700 text-sm font-bold mb-2">Kontrak Kerja</label>
                <input type="file" id="kontrak_kerja" name="kontrak_kerja" class="mt-1 block w-full border-gray-300 rounded-md">
                <?php if (!empty($dataKeberangkatan['kontrak_kerja'])): ?>
                    <p>File saat ini:
                        <a href="../../uploads/kontrak_kerja/<?= $dataKeberangkatan['kontrak_kerja'] ?>" target="_blank" class="text-blue-500 underline">
                            <?= $dataKeberangkatan['kontrak_kerja'] ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Perbarui</button>
                <a href="keberangkatan_list.php" class="text-blue-500 hover:text-blue-700">Kembali</a>
            </div>
    </div>
    </form>
    </div>
</body>

</html>