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
    <title>Lihat Kandidat</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../public/js/jquery-3.671.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="ml-64 p-8">

        <div class="flex flex-wrap justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Detail Kandidat</h1>
            <button onclick="history.back()" class=" bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Kembali
            </button>
        </div>

        <div id="detailKandidat" class="mt-6 bg-white p-6 shadow-md rounded">

            <table class="min-w-full border border-gray-200 shadow-lg rounded-lg overflow-hidden">
                <!-- Section: Biodata -->
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="4">Biodata</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Foto</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3">
                            <img id="fotoKandidat" src="" alt="Foto Kandidat" class="h-auto p-3 max-w-[100px] object-cover rounded-md">
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nama Lengkap</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="namaLengkap"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nama Ayah</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="namaAyah"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nama Ibu</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="namaIbu"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Lahir</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="tanggalLahir"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jenis Kelamin</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="jenisKelamin"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Agama</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="agama"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Golongan Darah</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="golonganDarah"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tinggi Badan</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="tinggiBadan"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Berat Badan</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="beratBadan"></td>
                    </tr>
                </tbody>

                <!-- Section: Pendidikan -->
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="4">Pendidikan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pendidikan SD</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="pendidikanSD"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pendidikan SMP</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="pendidikanSMP"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pendidikan SMA/SMK</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="pendidikanSMA"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jurusan SMA/SMK</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="jurusanSMA"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pendidikan Sarjana</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="pendidikanSarjana"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jurusan Sarjana</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="jurusanSarjana"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Pendidikan Magister</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="pendidikanMagister"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jurusan Magister</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="jurusanMagister"></td>
                    </tr>
                </tbody>

                <!-- Section: Riwayat Pekerjaan -->
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="4">Pengalaman Kerja</th>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nama Perusahaan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Jenis Pekerjaan</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Masuk</strong></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Tanggal Selesai</strong></td>
                    </tr>
                </thead>
                <tbody id="riwayatPekerjaanSection">
                    <!-- Data Riwayat Pekerjaan akan ditambahkan di sini -->
                </tbody>

                <!-- Section: Kontak -->
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="4">Kontak</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Domisili Saat Ini</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="domisili"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Alamat</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="alamat"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Email</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="email"></td>
                        <td class="border border-gray-300 py-3 px-3"><strong>Nomor HP</strong></td>
                        <td class="border border-gray-300 py-3 px-3" id="nomorHP"></td>
                    </tr>
                </tbody>

                <!-- Section: Upload File -->
                <thead>
                    <tr>
                        <th class="bg-gray-100 text-left py-4 px-3 text-2xl font-bold border-b border-gray-300" colspan="4">Dokumen</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>CV</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="cv">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" id="btnCV">Lihat CV</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>SSW</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="ssw">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" id="btnSSW">Lihat SSW</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Sertifikat Magang</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="sertifikatMagang">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" id="btnSertifikat">Lihat Sertifikat Magang</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>Paspor</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="paspor">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" id="btnPaspor">Lihat Paspor</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 py-3 px-3"><strong>JLPT/JFT</strong></td>
                        <td class="border border-gray-300 py-3 px-3" colspan="3" id="jlptJft">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded" id="btnJLPT">Lihat Sertifikat JLPT/JFT</button>
                        </td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

    <script>
        // Fungsi untuk mengambil detail kandidat
        function getKandidatDetail() {
            const urlParams = new URLSearchParams(window.location.search);
            const kandidatId = urlParams.get('id');

            if (!kandidatId || isNaN(kandidatId)) {
                alert('ID Kandidat tidak valid!');
                return;
            }

            $.ajax({
                url: `../../api/eksternal/lihat_kandidat_api.php?id_kandidat=${kandidatId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        $('#fotoKandidat').attr('src', `../../uploads/pas_foto/${data.pas_foto}`);
                        $('#namaLengkap').text(data.nama_lengkap);
                        $('#email').text(data.email);
                        $('#nomorHP').text(data.nomor_hp);
                        $('#namaAyah').text(data.nama_ayah);
                        $('#namaIbu').text(data.nama_ibu);
                        $('#tanggalLahir').text(data.tanggal_lahir);
                        $('#alamat').text(data.alamat_lengkap);
                        $('#domisili').text(data.domisili);
                        $('#golonganDarah').text(data.golongan_darah);
                        $('#tinggiBadan').text(data.tinggi_badan);
                        $('#beratBadan').text(data.berat_badan);
                        $('#pendidikanSD').text(data.pendidikan_sd);
                        $('#pendidikanSMP').text(data.pendidikan_smp);
                        $('#pendidikanSMA').text(data.pendidikan_sma_smk);
                        $('#jurusanSMA').text(data.jurusan_sma_smk);
                        $('#pendidikanSarjana').text(data.pendidikan_sarjana);
                        $('#jurusanSarjana').text(data.jurusan_sarjana);
                        $('#pendidikanMagister').text(data.pendidikan_magister);
                        $('#jurusanMagister').text(data.jurusan_magister);
                        $('#jenisKelamin').text(data.jenis_kelamin);
                        $('#agama').text(data.agama);

                        // Riwayat Pekerjaan
                        var riwayatPekerjaanHtml = '';
                        for (var i = 0; i < data.riwayat_pekerjaan.length; i++) {
                            riwayatPekerjaanHtml += `
                            <tr>
                                <td class="border border-gray-300 py-3 px-3">${data.riwayat_pekerjaan[i].nama_perusahaan}</td>
                                <td class="border border-gray-300 py-3 px-3">${data.riwayat_pekerjaan[i].jenis_pekerjaan}</td>
                                <td class="border border-gray-300 py-3 px-3">${data.riwayat_pekerjaan[i].tgl_masuk}</td>
                                <td class="border border-gray-300 py-3 px-3">${data.riwayat_pekerjaan[i].tgl_selesai}</td>
                            </tr>
                        `;
                        }
                        $('#riwayatPekerjaanSection').html(riwayatPekerjaanHtml);

                        // Update tombol dokumen jika file tersedia
                        $('#btnFOTO').click(() => {
                            if (data.pas_foto) {
                                window.open(data.pas_foto, '_blank');
                            } else {
                                alert('Pas Foto tidak tersedia.');
                            }
                        });
                        $('#btnCV').click(() => {
                            if (data.cv) {
                                window.open(data.cv, '_blank');
                            } else {
                                alert('CV tidak tersedia.');
                            }
                        });
                        $('#btnSSW').click(() => {
                            if (data.ssw) {
                                window.open(data.ssw, '_blank');
                            } else {
                                alert('SSW tidak tersedia.');
                            }
                        });
                        $('#btnSertifikat').click(() => {
                            if (data.sertifikat_magang) {
                                window.open(data.sertifikat_magang, '_blank');
                            } else {
                                alert('Sertifikat tidak tersedia.');
                            }
                        });
                        $('#btnPaspor').click(() => {
                            if (data.paspor) {
                                window.open(data.paspor, '_blank');
                            } else {
                                alert('Paspor tidak tersedia.');
                            }
                        });
                        $('#btnJLPT').click(() => {
                            if (data.jlpt_jft) {
                                window.open(data.jlpt_jft, '_blank');
                            } else {
                                alert('Dokumen JLPT tidak tersedia.');
                            }
                        });

                    } else {
                        alert('Data tidak ditemukan: ' + response.message);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Terjadi kesalahan saat mengambil data kandidat.');
                }
            });
        }

        // Panggil fungsi saat halaman siap
        $(document).ready(function() {
            getKandidatDetail();
        });
    </script>


</body>

</html>