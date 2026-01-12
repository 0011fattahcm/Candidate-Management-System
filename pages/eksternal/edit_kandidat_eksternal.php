<?php
session_start(); // Memulai session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../../db.php';
// Koneksi ke database

// Validasi apakah ID kandidat ada di URL dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data kandidat dari database
    $query = "SELECT * FROM kandidat WHERE id_kandidat = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);  // 'i' untuk integer
    $stmt->execute();
    $result = $stmt->get_result();
    $kandidat = $result->fetch_assoc();

    // Jika kandidat tidak ditemukan
    if (!$kandidat) {
        echo "<script>alert('Kandidat tidak ditemukan!'); window.history.back();</script>";
        exit();
    }

    // Ambil data riwayat pekerjaan
    $query_riwayat = "SELECT * FROM riwayat_pekerjaan WHERE kandidat_id = ?";
    $stmt_riwayat = $conn->prepare($query_riwayat);
    $stmt_riwayat->bind_param('i', $id);
    $stmt_riwayat->execute();
    $result_riwayat = $stmt_riwayat->get_result();
    $riwayat_pekerjaan = [];
    while ($row = $result_riwayat->fetch_assoc()) {
        $riwayat_pekerjaan[] = $row;
    }
} else {
    echo "<script>alert('ID kandidat tidak valid!'); window.history.back();</script>";
    exit();
}

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data POST
    $id = $_POST['id_kandidat'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat_lengkap = $_POST['alamat_lengkap'];
    $domisili = $_POST['domisili'];
    $golongan_darah = $_POST['golongan_darah'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $berat_badan = $_POST['berat_badan'];
    $pendidikan_smp = $_POST['pendidikan_smp'];
    $pendidikan_sma_smk = $_POST['pendidikan_sma_smk'];
    $jurusan_sma_smk = $_POST['jurusan_sma_smk'];
    $pendidikan_sarjana = $_POST['pendidikan_sarjana'];
    $jurusan_sarjana = $_POST['jurusan_sarjana'];
    $pendidikan_magister = $_POST['pendidikan_magister'];
    $jurusan_magister = $_POST['jurusan_magister'];
    $pendidikan_sd = $_POST['pendidikan_sd'];
    $nomor_hp = $_POST['nomor_hp'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $jenis_kandidat = $_POST['jenis_kandidat'];
    $status_administrasi = $_POST['status_administrasi'];
    $tanggal_daftar = $_POST['tanggal_daftar'];
    $tanggal_lolos = $_POST['tanggal_lolos'];

    // Upload file pas foto jika ada
    $pas_foto = $kandidat['pas_foto'];
    if (!empty($_FILES['pas_foto']['name'])) {
        $target_dir = "../../uploads/pas_foto/";
        $target_file = $target_dir . basename($_FILES["pas_foto"]["name"]);
        move_uploaded_file($_FILES["pas_foto"]["tmp_name"], $target_file);
        $pas_foto = $_FILES["pas_foto"]["name"];
    }

    // Upload files lainnya
    $cv = $kandidat['cv'];
    if (!empty($_FILES['cv']['name'])) {
        $target_dir = "../../uploads/cv/";
        $target_file = $target_dir . basename($_FILES["cv"]["name"]);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $target_file);
        $cv = $_FILES["cv"]["name"];
    }

    $ssw = $kandidat['ssw'];
    if (!empty($_FILES['ssw']['name'])) {
        $target_dir = "../../uploads/ssw/";
        $target_file = $target_dir . basename($_FILES["ssw"]["name"]);
        move_uploaded_file($_FILES["ssw"]["tmp_name"], $target_file);
        $ssw = $_FILES["ssw"]["name"];
    }

    $sertifikat_magang = $kandidat['sertifikat_magang'];
    if (!empty($_FILES['sertifikat_magang']['name'])) {
        $target_dir = "../../uploads/sertifikat_magang/";
        $target_file = $target_dir . basename($_FILES["sertifikat_magang"]["name"]);
        move_uploaded_file($_FILES["sertifikat_magang"]["tmp_name"], $target_file);
        $sertifikat_magang = $_FILES["sertifikat_magang"]["name"];
    }

    $paspor = $kandidat['paspor'];
    if (!empty($_FILES['paspor']['name'])) {
        $target_dir = "../../uploads/paspor/";
        $target_file = $target_dir . basename($_FILES["paspor"]["name"]);
        move_uploaded_file($_FILES["paspor"]["tmp_name"], $target_file);
        $paspor = $_FILES["paspor"]["name"];
    }

    $jlpt_jft = $kandidat['jlpt_jft'];
    if (!empty($_FILES['jlpt_jft']['name'])) {
        $target_dir = "../../uploads/jlpt_jft/";
        $target_file = $target_dir . basename($_FILES["jlpt_jft"]["name"]);
        move_uploaded_file($_FILES["jlpt_jft"]["tmp_name"], $target_file);
        $jlpt_jft = $_FILES["jlpt_jft"]["name"];
    }

    // Query update
    $query = "UPDATE kandidat SET 
                pas_foto = ?, 
                nama_lengkap = ?, 
                nama_ayah = ?, 
                nama_ibu = ?, 
                tanggal_lahir = ?, 
                alamat_lengkap = ?,
                domisili = ?,  
                golongan_darah = ?, 
                tinggi_badan = ?, 
                berat_badan = ?, 
                pendidikan_smp = ?, 
                pendidikan_sma_smk = ?, 
                jurusan_sma_smk = ?, 
                pendidikan_sarjana = ?, 
                jurusan_sarjana = ?, 
                pendidikan_magister = ?, 
                jurusan_magister = ?, 
                pendidikan_sd = ?, 
                nomor_hp = ?, 
                email = ?, 
                jenis_kelamin = ?, 
                agama = ?, 
                jenis_kandidat = ?, 
                status_administrasi = ?, 
                tanggal_daftar = ?, 
                tanggal_lolos = ?, 
                cv = ?, 
                ssw = ?, 
                sertifikat_magang = ?, 
                paspor = ?, 
                jlpt_jft = ? 
              WHERE id_kandidat = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        'sssssssddssssssssssssssssssssssi',
        $pas_foto,
        $nama_lengkap,
        $nama_ayah,
        $nama_ibu,
        $tanggal_lahir,
        $alamat_lengkap,
        $golongan_darah,
        $tinggi_badan,
        $berat_badan,
        $pendidikan_smp,
        $pendidikan_sma_smk,
        $jurusan_sma_smk,
        $pendidikan_sarjana,
        $jurusan_sarjana,
        $pendidikan_magister,
        $jurusan_magister,
        $pendidikan_sd,
        $nomor_hp,
        $email,
        $domisili,
        $jenis_kelamin,
        $agama,
        $jenis_kandidat,
        $status_administrasi,
        $tanggal_daftar,
        $tanggal_lolos,
        $cv,
        $ssw,
        $sertifikat_magang,
        $paspor,
        $jlpt_jft,
        $id
    );

    // Proses riwayat pekerjaan jika ada perubahan
    if (isset($_POST['id'])) {
        $riwayat_ids = $_POST['id'];
        for ($i = 0; $i < count($riwayat_ids); $i++) {
            $id_riwayat = $riwayat_ids[$i];
            $nama_perusahaan = $_POST['nama_perusahaan'][$i];
            $jenis_pekerjaan = $_POST['jenis_pekerjaan'][$i];
            $tgl_masuk = $_POST['tgl_masuk'][$i];
            $tgl_selesai = $_POST['tgl_selesai'][$i];

            // Update riwayat pekerjaan berdasarkan ID riwayat
            $query_riwayat = "UPDATE riwayat_pekerjaan SET 
                            nama_perusahaan = ?, 
                            jenis_pekerjaan = ?, 
                            tgl_masuk = ?, 
                            tgl_selesai = ? 
                            WHERE id = ?";
            $stmt_riwayat = $conn->prepare($query_riwayat);
            $stmt_riwayat->bind_param('ssssi', $nama_perusahaan, $jenis_pekerjaan, $tgl_masuk, $tgl_selesai, $id_riwayat);
            $stmt_riwayat->execute();
        }
    }

    // Eksekusi query dan cek hasilnya
    if ($stmt->execute()) {
        echo "<script>alert('Data kandidat berhasil diperbarui!'); window.location.href = 'eksternal_list.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data kandidat!'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kandidat Eksternal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        let workExperienceCount = document.querySelectorAll(".work-experience-entry").length;

        function addWorkExperienceField(data = {
            nama_perusahaan: "",
            jenis_pekerjaan: "",
            tgl_mulai: "",
            tgl_selesai: ""
        }) {
            if (workExperienceCount >= 5) {
                alert("Maksimal 5 riwayat pekerjaan.");
                return;
            }

            const container = document.getElementById("work-experience-container");
            const div = document.createElement("div");
            div.classList.add("work-experience-entry", "mb-4");

            div.innerHTML = `
        <div class="flex space-x-4">
            <input type="text" name="nama_perusahaan[]" value="${data.nama_perusahaan}" placeholder="Nama Perusahaan" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <input type="text" name="jenis_pekerjaan[]" value="${data.jenis_pekerjaan}" placeholder="Jenis Pekerjaan" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <input type="date" name="tgl_masuk[]" value="${data.tgl_mulai}" placeholder="Tanggal Masuk" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <input type="date" name="tgl_selesai[]" value="${data.tgl_selesai}" placeholder="Tanggal Selesai" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button type="button" onclick="removeWorkExperienceField(this)" class="text-red-500 font-semibold">Hapus</button>
        </div>
        `;
            container.appendChild(div);
            workExperienceCount++;
        }

        function removeWorkExperienceField(button) {
            const div = button.parentNode.parentNode;
            div.remove();
            workExperienceCount--;
        }

        window.onload = function() {
            const workExperiences = <?php echo json_encode($kandidat['work_experiences'] ?? []); ?>;

            workExperiences.forEach(exp => addWorkExperienceField({
                nama_perusahaan: exp.nama_perusahaan || "",
                jenis_pekerjaan: exp.jenis_pekerjaan || "",
                tgl_mulai: exp.tgl_mulai || "",
                tgl_selesai: exp.tgl_selesai || ""
            }));
        }
    </script>


</head>

<body class="bg-gray-100">
    <?php include '../../components/sidebar.php'; ?>
    <div class="ml-64 p-8">
        <div class="flex flex-wrap justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Edit Data Kandidat Internal</h1>
            <button onclick="history.back()" class=" bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                Kembali
            </button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6 p-6 bg-white shadow-md rounded-md">
            <input type="hidden" name="id_kandidat" value="<?php echo $kandidat['id_kandidat']; ?>">

            <div>
                <label for="pas_foto" class="block text-sm font-medium text-gray-700">Pas Foto</label>
                <input type="file" id="pas_foto" name="pas_foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <img src="../../uploads/pas_foto/<?php echo $kandidat['pas_foto']; ?>" alt="Foto Kandidat" class="mt-4 h-24 w-24 object-cover rounded-md shadow-md">
            </div>

            <div>
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $kandidat['nama_lengkap']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div>
                <label for="nama_ayah" class="block text-sm font-medium">Nama Ayah</label>
                <input type="text" id="nama_ayah" name="nama_ayah"
                    value="<?php echo $kandidat['nama_ayah']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="nama_ibu" class="block text-sm font-medium">Nama Ibu</label>
                <input type="text" id="nama_ibu" name="nama_ibu"
                    value="<?php echo $kandidat['nama_ibu']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="tanggal_lahir" class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                    value="<?php echo $kandidat['tanggal_lahir']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div>
                <label for="golongan_darah" class="block text-sm font-medium">Golongan Darah</label>
                <input type="text" id="golongan_darah" name="golongan_darah"
                    value="<?php echo $kandidat['golongan_darah']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="jenis_kelamin" class="block text-sm font-medium"">Jenis Kelamin</label>
                <select id=" jenis_kelamin" name="jenis_kelamin" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Laki-laki" <?php echo ($kandidat['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo ($kandidat['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
            </div>

            <div>
                <label for="agama" class="block text-sm font-medium">Agama</label>
                <select id="agama" name="agama" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Islam" <?php echo ($kandidat['agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
                    <option value="Kristen" <?php echo ($kandidat['agama'] == 'Kristen') ? 'selected' : ''; ?>>Kristen</option>
                    <option value="Katolik" <?php echo ($kandidat['agama'] == 'Katolik') ? 'selected' : ''; ?>>Katolik</option>
                    <option value="Hindu" <?php echo ($kandidat['agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
                    <option value="Buddha" <?php echo ($kandidat['agama'] == 'Buddha') ? 'selected' : ''; ?>>Buddha</option>
                    <option value="Konghucu" <?php echo ($kandidat['agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu</option>
                </select>
            </div>

            <div>
                <label for="tinggi_badan" class="block text-sm font-medium">Tinggi Badan (cm)</label>
                <input type="number" id="tinggi_badan" name="tinggi_badan"
                    value="<?php echo $kandidat['tinggi_badan']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="berat_badan" class="block text-sm font-medium">Berat Badan (kg)</label>
                <input type="number" id="berat_badan" name="berat_badan"
                    value="<?php echo $kandidat['berat_badan']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="pendidikan_sd" class="block text-sm font-medium">Pendidikan SD</label>
                <input type="text" id="pendidikan_sd" name="pendidikan_sd"
                    value="<?php echo $kandidat['pendidikan_sd']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="pendidikan_smp" class="block text-sm font-medium">Pendidikan SMP</label>
                <input type="text" id="pendidikan_smp" name="pendidikan_smp"
                    value="<?php echo $kandidat['pendidikan_smp']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="pendidikan_sma_smk" class="block text-sm font-medium">Pendidikan SMA/SMK</label>
                <input type="text" id="pendidikan_sma_smk" name="pendidikan_sma_smk"
                    value="<?php echo $kandidat['pendidikan_sma_smk']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="jurusan_sma_smk" class="block text-sm font-medium">Jurusan SMA/SMK</label>
                <input type="text" id="jurusan_sma_smk" name="jurusan_sma_smk"
                    value="<?php echo $kandidat['jurusan_sma_smk']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="pendidikan_sarjana" class="block text-sm font-medium">Pendidikan Sarjana</label>
                <input type="text" id="pendidikan_sarjana" name="pendidikan_sarjana"
                    value="<?php echo $kandidat['pendidikan_sarjana']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="jurusan_sarjana" class="block text-sm font-medium">Jurusan Sarjana</label>
                <input type="text" id="jurusan_sarjana" name="jurusan_sarjana"
                    value="<?php echo $kandidat['jurusan_sarjana']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="pendidikan_magister" class="block text-sm font-medium">Pendidikan Magister</label>
                <input type="text" id="pendidikan_magister" name="pendidikan_magister"
                    value="<?php echo $kandidat['pendidikan_magister']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="jurusan_magister" class="block text-sm font-medium">Jurusan Magister</label>
                <input type="text" id="jurusan_magister" name="jurusan_magister"
                    value="<?php echo $kandidat['jurusan_magister']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <!-- Bagian Riwayat Pekerjaan -->
            <div class="mt-6">
                <h2 class="text-xl mb-2 font-semibold">Riwayat Pekerjaan</h2>

                <!-- Kontainer untuk menampilkan riwayat pekerjaan yang ada dari PHP -->
                <?php if (!empty($riwayat_pekerjaan)) { ?>
                    <?php foreach ($riwayat_pekerjaan as $index => $riwayat) { ?>
                        <!-- Cek apakah $riwayat memiliki kunci id_riwayat_pekerjaan -->
                        <div class="work-experience-entry mb-4">
                            <input type="hidden" name="id[]" value="<?php echo isset($riwayat['id']) ? htmlspecialchars($riwayat['id']) : ''; ?>">
                            <div class="flex space-x-4">
                                <input type="text" name="nama_perusahaan[]"
                                    value="<?php echo isset($riwayat['nama_perusahaan']) ? htmlspecialchars($riwayat['nama_perusahaan']) : ''; ?>"
                                    placeholder="Nama Perusahaan" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <input type="text" name="jenis_pekerjaan[]"
                                    value="<?php echo isset($riwayat['jenis_pekerjaan']) ? htmlspecialchars($riwayat['jenis_pekerjaan']) : ''; ?>"
                                    placeholder="Jenis Pekerjaan" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <input type="date" name="tgl_masuk[]"
                                    value="<?php echo isset($riwayat['tgl_masuk']) ? htmlspecialchars($riwayat['tgl_masuk']) : ''; ?>"
                                    placeholder="Tanggal Masuk" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <input type="date" name="tgl_selesai[]"
                                    value="<?php echo isset($riwayat['tgl_selesai']) ? htmlspecialchars($riwayat['tgl_selesai']) : ''; ?>"
                                    placeholder="Tanggal Selesai" class="shadow appearance-none border rounded w-1/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Belum ada riwayat pekerjaan yang tersimpan.</p>
                <?php } ?>

            </div>

            <div>
                <label for="nomor_hp" class="block text-sm font-medium">Nomor HP</label>
                <input type="text" id="nomor_hp" name="nomor_hp"
                    value="<?php echo $kandidat['nomor_hp']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email"
                    value="<?php echo $kandidat['email']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="domisili" class="block text-sm font-medium"">Domisili Saat Ini</label>
                <select id=" domisili" name="domisili" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Indonesia" <?php echo ($kandidat['domisili'] == 'Indonesia') ? 'selected' : ''; ?>>Indonesia</option>
                    <option value="Jepang" <?php echo ($kandidat['domisili'] == 'Jepang') ? 'selected' : ''; ?>>Jepang</option>
                    </select>
            </div>

            <div>
                <label for="alamat_lengkap" class="block text-sm font-medium">Alamat Lengkap</label>
                <textarea id="alamat_lengkap" name="alamat_lengkap"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $kandidat['alamat_lengkap']; ?></textarea>
            </div>

            <div>
                <label for="jenis_kandidat" class="block text-sm font-medium">Jenis Kandidat</label>
                <select id="jenis_kandidat" name="jenis_kandidat" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="internal" <?php echo ($kandidat['jenis_kandidat'] == 'internal') ? 'selected' : ''; ?>>internal</option>
                    <option value="eksternal" <?php echo ($kandidat['jenis_kandidat'] == 'eksternal') ? 'selected' : ''; ?>>eksternal</option>
                </select>
            </div>

            <div>
                <label for="status_administrasi" class="block text-sm font-medium">Status Administrasi</label>
                <select id="status_administrasi" name="status_administrasi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Pending" <?php echo ($kandidat['status_administrasi'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Lolos" <?php echo ($kandidat['status_administrasi'] == 'Lolos') ? 'selected' : ''; ?>>Lolos</option>
                    <option value="Tidak Lolos" <?php echo ($kandidat['status_administrasi'] == 'Tidak Lolos') ? 'selected' : ''; ?>>Tidak Lolos</option>
                </select>
            </div>

            <div>
                <label for="tanggal_daftar" class="block text-sm font-medium">Tanggal Daftar</label>
                <input type="date" id="tanggal_daftar" name="tanggal_daftar"
                    value="<?php echo $kandidat['tanggal_daftar']; ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div>
                <label for="tanggal_lolos" class="block text-sm font-medium">Tanggal Lolos</label>
                <input type="date" id="tanggal_lolos" name="tanggal_lolos"
                    value="<?php echo $kandidat['tanggal_lolos']; ?>" -
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div>
                <label for="cv" class="block text-sm font-medium">CV</label>
                <input type="file" id="cv" name="cv" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($kandidat['cv']): ?>
                    <p class="mt-1 text-sm text-gray-500">File saat ini: <?php echo $kandidat['cv']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="ssw" class="block text-sm font-medium">SSW</label>
                <input type="file" id="ssw" name="ssw" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($kandidat['ssw']): ?>
                    <p class="mt-1 text-sm text-gray-500">File saat ini: <?php echo $kandidat['ssw']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="sertifikat_magang" class="block text-sm font-medium">Sertifikat Magang</label>
                <input type="file" id="sertifikat_magang" name="sertifikat_magang" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($kandidat['sertifikat_magang']): ?>
                    <p class="mt-1 text-sm text-gray-500">File saat ini: <?php echo $kandidat['sertifikat_magang']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="paspor" class="block text-sm font-medium">Paspor</label>
                <input type="file" id="paspor" name="paspor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($kandidat['paspor']): ?>
                    <p class="mt-1 text-sm text-gray-500">File saat ini: <?php echo $kandidat['paspor']; ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label for="jlpt_jft" class="block text-sm font-medium">JLPT/JFT</label>
                <input type="file" id="jlpt_jft" name="jlpt_jft" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <?php if ($kandidat['jlpt_jft']): ?>
                    <p class="mt-1 text-sm text-gray-500">File saat ini: <?php echo $kandidat['jlpt_jft']; ?></p>
                <?php endif; ?>
            </div>


            <div>
                <button type="submit" class="mt-4 w-full bg-green-500 text-white font-bold py-2 rounded-md">
                    Update Data Kandidat
                </button>
            </div>
        </form>
    </div>
</body>

</html>