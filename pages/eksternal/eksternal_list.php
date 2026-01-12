<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");

    exit();
}
include '../../components/Sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kandidat Eksternal</title>

    <!-- Muat CSS lokal -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Muat jQuery dari CDN -->
    <script src="../../public/js/jquery-3.671.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="ml-64 p-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Kandidat Eksternal</h1>
            <a href="../eksternal/add_kandidat_eksternal.php"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Tambah Kandidat
            </a>
        </div>

        <form action="../../export_eksternal_excel.php" method="GET" class="space-y-4 mt-5 bg-gray-200 p-4 rounded-md shadow-sm">
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

        <!-- Table Section -->
        <div class="mt-6 overflow-auto max-h-[500px] bg-white shadow-md rounded">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-left text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6">Preview Foto</th>
                        <th class="py-3 px-6">Nama Lengkap</th>
                        <th class="py-3 px-6">Tanggal Lahir</th>
                        <th class="py-3 px-6">Tanggal Daftar</th>
                        <th class="py-3 px-6">Status</th>
                        <th class="py-3 px-6">Tanggal Lolos</th>
                        <th class="py-3 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody id="kandidatTable" class="text-gray-700 text-sm"></tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-end mt-4" id="pagination"></div>
    </div>

    <!-- Popup Hapus -->
    <div id="popupHapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <p class="text-lg font-semibold mb-4">Apakah Anda yakin ingin menghapus <span id="namaKandidatPopup" class="font-bold"></span>?</p>
            <div class="flex justify-center space-x-4">
                <button id="confirmDelete" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded">Hapus</button>
                <button id="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk mengambil data kandidat
        function fetchKandidat(page = 1) {
            $.ajax({
                url: '../../api/eksternal/eksternal_list_api.php',
                type: 'GET',
                data: {
                    page: page
                },
                success: function(response) {
                    let kandidatHTML = '';
                    response.data.forEach(function(kandidat) {
                        kandidatHTML += `
                            <tr class="border-b hover:bg-gray-100">
                                <td class="py-3 px-6">
                                    <img src="../../uploads/pas_foto/${kandidat.pas_foto}" 
                                         alt="Foto" class="h-12 w-12 rounded-full object-cover">
                                </td>
                                <td class="py-3 px-6">${kandidat.nama_lengkap}</td>
                                <td class="py-3 px-6">${kandidat.tanggal_lahir}</td>
                                <td class="py-3 px-6">${kandidat.tanggal_daftar}</td>
                                <td class="py-3 px-6 font-semibold text-white text-center rounded
                                    ${kandidat.status_administrasi === 'Pending' ? 'bg-blue-500' : 
                                      kandidat.status_administrasi === 'Lolos' ? 'bg-green-500' : 
                                      'bg-red-500'}">
                                    ${kandidat.status_administrasi}
                                </td>
                                <td class="py-3 px-6">${kandidat.tanggal_lolos}</td>
                                <td class="py-3 px-6">
                                    <a href="see_kandidat_eksternal.php?id=${kandidat.id}" class="text-blue-500 hover:underline">Lihat</a> |
                                    <a href="edit_kandidat_eksternal.php?id=${kandidat.id}" class="text-green-500 hover:underline">Edit</a> |
                                    <a href="#" class="text-red-500 hover:underline" onclick="showPopup('${kandidat.id}', '${kandidat.nama_lengkap}')">Hapus</a>
                                </td>
                            </tr>`;
                    });

                    $('#kandidatTable').html(kandidatHTML);

                    // Buat pagination
                    let paginationHTML = '';
                    for (let i = 1; i <= response.totalPages; i++) {
                        paginationHTML += `
                            <a href="#" class="px-3 py-2 mx-1 
                                ${i == response.currentPage ? 'bg-blue-500 text-white' : 'bg-gray-300 text-gray-700'} 
                                rounded" onclick="fetchKandidat(${i})">
                                ${i}
                            </a>`;
                    }
                    $('#pagination').html(paginationHTML);
                },
                error: function() {
                    alert('Gagal mengambil data kandidat.');
                }
            });
        }

        // Fungsi untuk menghapus kandidat
        function showPopup(id, nama) {
            kandidatIdToDelete = id;
            $('#namaKandidatPopup').text(nama);
            $('#popupHapus').removeClass('hidden');
        }

        $('#confirmDelete').click(function() {
            if (kandidatIdToDelete) {
                $.ajax({
                    type: 'POST',
                    url: '../../api/internal/delete_kandidat_api.php',
                    data: {
                        id: kandidatIdToDelete
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Kandidat berhasil dihapus');
                            fetchKandidat();
                            $('#popupHapus').addClass('hidden');
                        } else {
                            alert('Gagal: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Terjadi kesalahan. Coba lagi.');
                    }
                });
            }
        });

        $('#cancelDelete').click(function() {
            $('#popupHapus').addClass('hidden');
            kandidatIdToDelete = null;
        });
        // Ambil data kandidat saat halaman dimuat
        $(document).ready(function() {
            fetchKandidat();
        });
    </script>
</body>

</html>