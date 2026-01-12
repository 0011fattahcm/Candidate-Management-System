<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
ob_start(); // Start output buffering
include '../../components/Sidebar.php';

// Koneksi database
include '../../db.php';

// Ambil ID kandidat dari URL
$id_kandidat = isset($_GET['id_kandidat']) ? $_GET['id_kandidat'] : null;

if (!$id_kandidat) {
    echo "ID Kandidat tidak ditemukan.";
    exit();
}

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catatan = $_POST['catatan'];
    $status_interview = $_POST['status_interview'];
    $tanggal_interview = $_POST['tanggal_interview'];

    // Query untuk menyimpan data interview
    $query = "INSERT INTO interview (id_kandidat, catatan, status_interview, tanggal_interview) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Check if prepare failed
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param('isss', $id_kandidat, $catatan, $status_interview, $tanggal_interview);

    if ($stmt->execute()) {
        // Redirect ke halaman interview_list.php setelah berhasil
        header('Location: interview_list.php');
        exit();
    } else {
        echo "Gagal menambahkan data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Interview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="ml-64 p-8">
        <div class="container mx-auto px-4 py-8">
            <div class="flex mb-5 flex-wrap justify-between">
                <h1 class="text-3xl font-bold text-gray-800">Form Input Data Interview</h1>
                <button onclick="history.back()" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Kembali
                </button>
            </div>
            <form action="tambah_interview.php?id_kandidat=<?= htmlspecialchars($id_kandidat); ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <input type="hidden" name="id_kandidat" value="<?= htmlspecialchars($id_kandidat); ?>">

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="catatan">Catatan</label>
                    <textarea id="catatan" name="catatan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal_interview">Tanggal Interview</label>
                    <input type="date" id="tanggal_interview" name="tanggal_interview" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required />
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status_interview">Status Interview</label>
                    <select id="status_interview" name="status_interview" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Pending">Pending</option>
                        <option value="Lolos">Lolos</option>
                        <option value="Tidak Lolos">Tidak Lolos</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Tambah Interview
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
ob_end_flush(); // Flush the output buffer
?>