<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include '../../db.php'; // Koneksi database

// Fungsi untuk mengambil jumlah kandidat internal dan eksternal
function getKandidatByType($jenis, $month, $year)
{
    global $conn;
    $query = "SELECT COUNT(*) AS count FROM kandidat 
              WHERE jenis_kandidat = '$jenis' 
              AND MONTH(tanggal_daftar) = '$month' 
              AND YEAR(tanggal_daftar) = '$year'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'] ?? 0;
}

// Fungsi untuk mengambil jumlah kandidat interview
function getInterviewCount($month, $year)
{
    global $conn;
    $query = "SELECT COUNT(*) AS count FROM interview 
              WHERE MONTH(tanggal_interview) = '$month' 
              AND YEAR(tanggal_interview) = '$year'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'] ?? 0;
}

// Fungsi untuk mengambil jumlah keberangkatan
function getKeberangkatanCount($month, $year)
{
    global $conn;
    $query = "SELECT COUNT(*) AS count FROM keberangkatan 
              WHERE MONTH(tanggal_keberangkatan) = '$month' 
              AND YEAR(tanggal_keberangkatan) = '$year'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    return $data['count'] ?? 0;
}

// Ambil data dari Januari hingga Desember untuk tahun saat ini
$currentYear = date('Y');
$months = range(1, 12);

$labels = [];
$internalCounts = [];
$eksternalCounts = [];
$interviewCounts = [];
$keberangkatanCounts = [];

foreach ($months as $month) {
    $labels[] = date('F', mktime(0, 0, 0, $month, 1)); // Nama bulan
    $internalCounts[] = getKandidatByType('internal', $month, $currentYear);
    $eksternalCounts[] = getKandidatByType('eksternal', $month, $currentYear);
    $interviewCounts[] = getInterviewCount($month, $currentYear);
    $keberangkatanCounts[] = getKeberangkatanCount($month, $currentYear);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">
    <?php include '../../components/Sidebar.php'; ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl mb-5 font-bold text-gray-800">Dashboard</h1>

        <div class="container mt-10 bg-sky-500 mx-auto my-4">
            <!-- Card Selamat Datang -->
            <div class="shadow-md rounded-lg p-6 mb-">
                <h2 class="text-2xl font-semibold text-center text-white mb-4">Selamat Datang!</h2>
                <p class="text-white">Selamat datang di sistem manajemen kandidat <span class="font-bold">Japan Educational Cooperation Association</span>. Anda dapat melihat informasi kandidat, wawancara, dan keberangkatan di sini. Semoga Anda memiliki pengalaman yang produktif!</p>
            </div>
        </div>

        <h1 class="text-3xl mt-8 mb-5 text-center font-bold">Data Statistik Sistem</h1>
        <div class="grid grid-cols-2 gap-4 mt-8">
            <div class="bg-white shadow-md rounded p-8">
                <h2 class="flex items-center py-6 text-3xl font-semibold space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                    </svg>
                    <span>Kandidat Internal</span>
                </h2>
                <p class="text-gray-700 text-2xl font-bold">Jumlah: <?= array_sum($internalCounts) ?> Kandidat</p>
                <canvas id="internalChart" class="mt-4"></canvas>
            </div>

            <div class="bg-white shadow-md rounded p-8">
                <h2 class="flex items-center py-6 text-3xl font-semibold space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                    <span>Kandidat Eksternal</span>
                </h2>
                <p class="text-gray-700 text-2xl font-bold">Jumlah: <?= array_sum($eksternalCounts) ?> Kandidat</p>
                <canvas id="eksternalChart" class="mt-4"></canvas>
            </div>

            <div class="bg-white shadow-md rounded p-8">
                <h2 class="flex items-center py-6 text-3xl font-semibold space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                        <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
                    </svg>
                    <span>Kandidat Interview</span>
                </h2>
                <p class="text-gray-700 text-2xl font-bold">Jumlah: <?= array_sum($interviewCounts) ?> Kandidat</p>
                <canvas id="interviewChart" class="mt-4"></canvas>
            </div>

            <div class="bg-white shadow-md rounded p-8">
                <h2 class="flex items-center py-6 text-3xl font-semibold space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                        <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                    </svg>
                    <span>Keberangkatan</span>
                </h2>
                <p class="text-gray-700 text-2xl font-bold">Jumlah: <?= array_sum($keberangkatanCounts) ?> Kandidat</p>
                <canvas id="keberangkatanChart" class="mt-4"></canvas>
            </div>
        </div>
    </div>

    <script>
        const labels = <?= json_encode($labels) ?>;

        const configChart = (label, data, bgColor, borderColor) => ({
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: label
                    }
                }
            },
        });

        new Chart(document.getElementById('internalChart'), configChart(
            'Grafik Kandidat Internal', <?= json_encode($internalCounts) ?>,
            'rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 1)'
        ));
        new Chart(document.getElementById('eksternalChart'), configChart(
            'Grafik Kandidat Eksternal', <?= json_encode($eksternalCounts) ?>,
            'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 1)'
        ));
        new Chart(document.getElementById('interviewChart'), configChart(
            'Grafik Kandidat Interview', <?= json_encode($interviewCounts) ?>,
            'rgba(75, 192, 192, 0.2)', 'rgba(75, 192, 192, 1)'
        ));
        new Chart(document.getElementById('keberangkatanChart'), configChart(
            'Grafik Kandidat Keberangkatan', <?= json_encode($keberangkatanCounts) ?>,
            'rgba(255, 206, 86, 0.2)', 'rgba(255, 206, 86, 1)'
        ));
    </script>
</body>

</html>