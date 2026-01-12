<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
// Koneksi ke database
include '../../db.php';

// Ambil nomor halaman dari query string (default ke 1 jika tidak ada)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 20; // Batas data per halaman
$offset = ($page - 1) * $limit;

// Query untuk mengambil kandidat dengan status_administrasi 'Lolos' dan pagination
$query = "
    SELECT 
        k.id_kandidat,
        k.nama_lengkap AS nama_kandidat,
        k.pas_foto,
        k.tanggal_daftar,
        k.jenis_kandidat,
        IFNULL(i.tanggal_interview, 'Belum Terjadwal') AS tanggal_interview,
        IFNULL(i.catatan, 'Belum ada catatan') AS catatan,
        IFNULL(i.status_interview, 'Pending') AS status_interview,
        i.id_interview
    FROM 
        kandidat k
    LEFT JOIN 
        interview i ON i.id_kandidat = k.id_kandidat
    WHERE 
        k.status_administrasi = 'Lolos'
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($query);

// Hitung total data untuk pagination
$totalQuery = "SELECT COUNT(*) AS total FROM kandidat WHERE status_administrasi = 'Lolos'";
$totalResult = $conn->query($totalQuery);
$totalData = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Interview</title>

    <!-- Muat CSS lokal dan Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Interview</h1>
        </div>

        <div class="overflow-auto max-h-[500px] bg-white shadow-md rounded">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="py-3 px-6">Nama Kandidat</th>
                        <th class="py-3 px-6">Pas Foto</th>
                        <th class="py-3 px-6">Tanggal Daftar</th>
                        <th class="py-3 px-6">Tanggal Interview</th>
                        <th class="py-3 px-6">Jenis Kandidat</th>
                        <th class="py-3 px-6">Catatan</th>
                        <th class="py-3 px-6">Status Interview</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-6"><?= htmlspecialchars($row['nama_kandidat']); ?></td>
                            <td class="py-3 px-6 text-center">
                                <img src="../../uploads/pas_foto/<?= htmlspecialchars($row['pas_foto']); ?>"
                                    alt="Pas Foto" class="w-12 h-12 rounded-full mx-auto object-cover">
                            </td>
                            <td class="py-3 px-6 text-center"><?= htmlspecialchars($row['tanggal_daftar']); ?></td>
                            <td class="py-3 px-6 text-center"><?= htmlspecialchars($row['tanggal_interview']); ?></td>
                            <td class="py-3 px-6"><?= htmlspecialchars($row['jenis_kandidat']); ?></td>
                            <td class="py-3 px-6"><?= htmlspecialchars($row['catatan']); ?></td>
                            <td class="py-3 px-6 text-center">
                                <span class="
                                    <?= $row['status_interview'] === 'Lolos' ? 'bg-green-500' : ($row['status_interview'] === 'Tidak Lolos' ? 'bg-red-500' : 'bg-yellow-500'); ?>
                                    text-white px-2 py-1 rounded">
                                    <?= htmlspecialchars($row['status_interview']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <?php if ($row['id_interview']): ?>
                                    <a href="edit_interview.php?id=<?= $row['id_interview']; ?>"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                                        Edit
                                    </a>
                                <?php else: ?>
                                    <a href="tambah_interview.php?id_kandidat=<?= $row['id_kandidat']; ?>"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
                                        Tambah
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end mt-4">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i; ?>"
                    class="px-3 py-2 mx-1 <?= $i == $page ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-700'; ?> 
                   rounded">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>

    <?php $conn->close(); ?>
</body>

</html>