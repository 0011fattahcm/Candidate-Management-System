<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");

    exit();
}
include '../../components/Sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Kandidat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="ml-64 p-8">
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
            <div class="flex mb-5 flex-wrap justify-between">
                <h1 class="text-3xl font-bold text-gray-800">Form Input Kandidat Eksternal</h1>
                <button onclick="history.back()" class=" bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Kembali
                </button>
            </div>
            <form id="kandidatForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Informasi Pribadi -->
                <h2 class="text-xl font-bold mb-2">Biodata</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="nama_ayah" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="nama_ibu" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" min="0" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" min="0" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Agama</label>
                        <select name="agama" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Golongan Darah</label>
                    <select name="golongan_darah" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>

                <!-- Pendidikan -->
                <h2 class="text-xl font-bold mb-2">Pendidikan</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700">Pendidikan SD</label>
                        <input type="text" name="pendidikan_sd" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Pendidikan SMP</label>
                        <input type="text" name="pendidikan_smp" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Pendidikan SMA/SMK/MA</label>
                        <input type="text" name="pendidikan_sma_smk" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Jurusan SMA/SMK/MA</label>
                        <input type="text" name="jurusan_sma_smk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Pendidikan Sarjana</label>
                        <input type="text" name="pendidikan_sarjana" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Jurusan Sarjana</label>
                        <input type="text" name="jurusan_sarjana" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Pendidikan Magister</label>
                        <input type="text" name="pendidikan_magister" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Jurusan Magister</label>
                        <input type="text" name="jurusan_magister" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- Riwayat Pekerjaan -->
                <h3 class="text-xl font-bold mb-2">Riwayat Pekerjaan</h3>

                <div id="riwayatPekerjaanContainer">
                    <!-- Maksimal 5 entri riwayat pekerjaan -->
                    <template id="riwayatPekerjaanTemplate">
                        <div class="riwayat-pekerjaan">
                            <div class="grid mb-2 grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-gray-700">Nama Perusahaan</label>
                                    <input type="text" name="riwayat_pekerjaan[][nama_perusahaan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Jenis Pekerjaan</label>
                                    <input type="text" name="riwayat_pekerjaan[][jenis_pekerjaan]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Tanggal Masuk</label>
                                    <input type="date" name="riwayat_pekerjaan[][tgl_masuk]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                                </div>

                                <div>
                                    <label class="block font-medium text-gray-700">Tanggal Selesai</label>
                                    <input type="date" name="riwayat_pekerjaan[][tgl_selesai]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                                </div>

                                <button type="button" onclick="removeWorkExperienceField(this)" class="text-white bg-red-500 p-2 text-center font-semibold">Hapus</button>

                            </div>
                        </div>
                        <hr />
                    </template>
                    <button type="button" id="addRiwayatPekerjaanBtn" class="bg-blue-500 hover:bg-blue-600 mb-2 text-white py-2 px-4 rounded-md">Tambah Riwayat Pekerjaan</button>
                    <h1 class="text-sm text-gray-600 mb-3">*Maksimal 5 Pekerjaan. Kosongkan jika Anda tidak ingin menginput</h1>
                </div>


                <!-- Kontak -->
                <h2 class="text-xl font-bold mb-2">Kontak</h2>
                <div>
                    <label class="block font-medium text-gray-700">Domisili Saat Ini</label>
                    <select name="domisili" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Indonesia">Indonesia</option>
                        <option value="Jepang">Jepang</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat_lengkap" rows="3" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Nomor HP</label>
                    <input type="tel" name="nomor_hp" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <!-- Unggah Dokumen -->
                <h2 class="text-xl font-bold mb-2">Unggah Dokumen</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium text-gray-700">Pas Foto (jpg, jpeg, png)</label>
                        <input type="file" name="pas_foto" accept=".jpg, .jpeg, .png" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">CV (pdf, docx, xlsx)</label>
                        <input type="file" name="cv" accept=".pdf, .docx, .xlsx" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">SSW/SENMONKYU/3KYUU/HYOUKACHOSO (pdf, docx, xlsx)</label>
                        <input type="file" name="ssw" accept=".pdf, .docx, .xlsx" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Sertifikat Magang (pdf, docx, xlsx)</label>
                        <input type="file" name="sertifikat_magang" accept=".pdf, .docx, .xlsx" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">Paspor (pdf, docx, xlsx)</label>
                        <input type="file" name="paspor" accept=".pdf, .docx, .xlsx" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700">JLPT/JFT (pdf, docx, xlsx)</label>
                        <input type="file" name="jlpt_jft" accept=".pdf, .docx, .xlsx" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md">
                        Submit
                    </button>
                </div>
            </form>
            <!-- Pop-Up Notification -->
            <div id="popup" class="fixed top-5 right-5 p-4 rounded bg-green-500 text-white hidden">
                <span id="popupMessage"></span>
            </div>
        </div>
    </div>
    <script>
        const maxRiwayatPekerjaan = 5; // Maksimal 5 data riwayat pekerjaan
        let riwayatCount = 0;

        const form = document.getElementById('kandidatForm');
        const popup = document.getElementById('popup');
        const popupMessage = document.getElementById('popupMessage');
        const container = document.getElementById('riwayatPekerjaanContainer');
        const template = document.getElementById('riwayatPekerjaanTemplate').content;
        const addBtn = document.getElementById('addRiwayatPekerjaanBtn');

        // Event listener untuk menambah riwayat pekerjaan
        addBtn.addEventListener('click', () => {
            if (riwayatCount < maxRiwayatPekerjaan) {
                const clone = document.importNode(template, true);
                container.appendChild(clone);
                riwayatCount++;
            } else {
                alert('Maksimal 5 riwayat pekerjaan.');
            }
        });

        // Event listener untuk form submit
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const riwayatPekerjaanData = [];

            for (let i = 0; i < riwayatCount; i++) {
                const nama_perusahaan = formData.getAll(`riwayat_pekerjaan[][nama_perusahaan]`)[i];
                const jenis_pekerjaan = formData.getAll(`riwayat_pekerjaan[][jenis_pekerjaan]`)[i];
                const tgl_masuk = formData.getAll(`riwayat_pekerjaan[][tgl_masuk]`)[i];
                const tgl_selesai = formData.getAll(`riwayat_pekerjaan[][tgl_selesai]`)[i];

                if (nama_perusahaan || jenis_pekerjaan || tgl_masuk || tgl_selesai) {
                    riwayatPekerjaanData.push({
                        nama_perusahaan,
                        jenis_pekerjaan,
                        tgl_masuk,
                        tgl_selesai
                    });
                }
            }

            formData.append('riwayat_pekerjaan', JSON.stringify(riwayatPekerjaanData));

            try {
                const response = await fetch('http://localhost/candidate-management-jeca/api/eksternal/add_kandidat_api.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.status === 'success') {
                    showPopup(result.message, 'bg-green-500');
                    form.reset();
                    setTimeout(() => {
                        window.location.href = 'eksternal_list.php';
                    }, 2000);
                } else {
                    showPopup(result.message, 'bg-red-500');
                }
            } catch (error) {
                showPopup('Terjadi kesalahan. Silakan coba lagi.', 'bg-red-500');
            }
        });

        function removeWorkExperienceField(button) {
            const div = button.parentNode.parentNode;
            div.remove();
            workExperienceCount--;
        }

        // Fungsi untuk menampilkan pop-up notifikasi
        function showPopup(message, bgColor) {
            popupMessage.textContent = message;
            popup.className = `fixed top-5 right-5 p-4 rounded text-white ${bgColor} animate__animated animate__fadeIn`;

            setTimeout(() => {
                popup.className += ' hidden';
            }, 3000); // Pop-up hilang setelah 3 detik
        }
    </script>

</body>

</html>