<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../db.php'; // Koneksi database

// Ambil ID dari URL
$id_interview = $_GET['id'];

// Ambil data interview berdasarkan ID
$query = "SELECT * FROM interview WHERE id_interview = $id_interview";
$result = mysqli_query($conn, $query);
$interviewData = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_kandidat = $_POST['id_kandidat'];
    $status_interview = $_POST['status_interview'];
    $catatan = $_POST['catatan'];
    $tanggal_interview = $_POST['tanggal_interview'];
    // Ambil data lain sesuai dengan kolom di tabel interview

    // Update data interview
    $updateQuery = "UPDATE interview SET id_kandidat = '$id_kandidat', status_interview = '$status_interview', catatan = '$catatan', tanggal_interview = '$tanggal_interview' WHERE id_interview = $id_interview";
    mysqli_query($conn, $updateQuery);

    // Redirect ke halaman list interview setelah berhasil
    header('Location: interview_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Interview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>
    <div class="ml-64 p-8">
        <form action="" method="POST" class="bg-white rounded-md shadow-md mt-8 space-y-6">
            <div class="flex flex-wrap p-4 justify-between">
                <h1 class="text-3xl font-bold text-gray-800">Edit Data Interview</h1>
                <button onclick="history.back()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Kembali
                </button>
            </div>
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="id_kandidat">ID Kandidat</label>
                <input type="text" name="id_kandidat" value="<?= $interviewData['id_kandidat'] ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal_interview">Tanggal Interview</label>
                <input type="date" name="tanggal_interview" value="<?= $interviewData['tanggal_interview'] ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status_interview">Status Interview</label>
                <select name="status_interview" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Pending" <?= $interviewData['status_interview'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Tidak Lolos" <?= $interviewData['status_interview'] == 'Tidak Lolos' ? 'selected' : '' ?>>Tidak Lolos</option>
                    <option value="Lolos" <?= $interviewData['status_interview'] == 'Lolos' ? 'selected' : '' ?>>Lolos</option>
                </select>
            </div>
            <div class="p-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="catatan">Catatan</label>
                <input type="text" name="catatan" value="<?= $interviewData['catatan'] ?>" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <!-- Tambahkan input lainnya sesuai dengan kebutuhan -->
            <div class="flex items-center p-6 justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update
                </button>
                <a href="interview_list.php" class="text-blue-500 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</body>

</html>