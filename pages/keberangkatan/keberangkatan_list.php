<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../db.php'; // Koneksi database

// Fungsi untuk mengambil data kandidat yang status interviewnya 'Lolos' beserta data keberangkatan
function getKandidatKeberangkatan($conn, $page, $limit)
{
    $offset = ($page - 1) * $limit;

    $query = "
        SELECT 
            k.id_kandidat, 
            k.nama_lengkap, 
            k.pas_foto, 
            kb.id_keberangkatan, 
            kb.perusahaan, 
            kb.tsk, 
            kb.daerah, 
            kb.jenis_pekerjaan, 
            kb.tanggal_keberangkatan, 
            kb.informasi_tambahan
        FROM 
            kandidat k 
        JOIN 
            interview iv ON k.id_kandidat = iv.id_kandidat 
        LEFT JOIN 
            keberangkatan kb ON k.id_kandidat = kb.id_kandidat 
        WHERE 
            iv.status_interview = 'Lolos'
        LIMIT $limit OFFSET $offset
    ";

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Hitung total halaman
    $countQuery = "
        SELECT COUNT(*) as total 
        FROM 
            kandidat k 
        JOIN 
            interview iv ON k.id_kandidat = iv.id_kandidat 
        WHERE 
            iv.status_interview = 'Lolos'
    ";
    $countResult = mysqli_query($conn, $countQuery);
    $totalRows = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRows / $limit);

    return ['data' => $data, 'totalPages' => $totalPages];
}

// Ambil data kandidat dengan paginasi
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$kandidatData = getKandidatKeberangkatan($conn, $page, $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Keberangkatan</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Data Keberangkatan</h1>
        </div>

        <form action="../../export_keberangkatan_excel.php" method="GET" class="space-y-4 mt-5 bg-gray-200 p-4 rounded-md shadow-sm">
            <!-- Rentang Tanggal -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-600">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-600">Tanggal Akhir</label>
                    <input type="date" id="end_date" name="end_date" required
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                </div>
            </div>

            <!-- Tombol Export -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Export ke Excel
                </button>
            </div>
        </form>

        <div class="mt-6 overflow-auto max-h-[500px] bg-white shadow-md rounded">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6">Pas Foto</th>
                        <th class="py-3 px-6">Nama</th>
                        <th class="py-3 px-6">Perusahaan</th>
                        <th class="py-3 px-6">TSK</th>
                        <th class="py-3 px-6">Tanggal Keberangkatan</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kandidatData['data'] as $item): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-6">
                                <img src="../../uploads/pas_foto/<?= $item['pas_foto'] ?>" alt="Foto" class="h-12 w-12 rounded-full object-cover">
                            </td>
                            <td class="py-3 px-6"><?= $item['nama_lengkap'] ?></td>
                            <td class="py-3 px-6"><?= $item['perusahaan'] ?? 'Belum ada' ?></td>
                            <td class="py-3 px-6"><?= $item['tsk'] ?? 'Belum ada' ?></td>
                            <td class="py-3 px-6"><?= $item['tanggal_keberangkatan'] ?? 'Belum ada' ?></td>
                            <td class="py-3 px-6 text-center">
                                <a href="lihat_keberangkatan.php?id_kandidat=<?= $item['id_kandidat'] ?>" class="bg-green-500 mb-2 hover:bg-green-600 text-white py-1 px-4 rounded">
                                    Lihat
                                </a>

                                <?php if ($item['id_keberangkatan']): ?>
                                    <a href="edit_keberangkatan.php?id_keberangkatan=<?= $item['id_keberangkatan']; ?>"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 mb-2 rounded">
                                        Edit
                                    </a>
                                <?php else: ?>
                                    <a href="tambah_keberangkatan.php?id_kandidat=<?= $item['id_kandidat'] ?>" class="bg-green-500 mb-2 hover:bg-green-600 text-white py-1 px-4 rounded">
                                        Tambah
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <div class="flex justify-end mt-4">
            <?php for ($i = 1; $i <= $kandidatData['totalPages']; $i++): ?>
                <a href="?page=<?= $i ?>" class="px-3 py-2 mx-1 <?= $i == $page ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-700' ?> rounded">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</body>

</html>