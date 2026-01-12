<?php
// Autoload Composer agar semua library yang dibutuhkan PhpSpreadsheet tersedia
require 'vendor/autoload.php';

// Koneksi ke database
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Ambil parameter tanggal dari form (contoh tanggal lahir kandidat atau tanggal daftar)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if (!$start_date || !$end_date) {
    die("Tanggal awal dan akhir harus ditentukan.");
}

// Buat instance Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom untuk data kandidat internal
$sheet->setCellValue('A1', 'Nama Lengkap')
    ->setCellValue('B1', 'Nama Ayah')
    ->setCellValue('C1', 'Nama Ibu')
    ->setCellValue('D1', 'Tanggal Lahir')
    ->setCellValue('E1', 'Alamat')
    ->setCellValue('F1', 'Golongan Darah')
    ->setCellValue('G1', 'Tinggi Badan')
    ->setCellValue('H1', 'Berat Badan')
    ->setCellValue('I1', 'Pendidikan SD')
    ->setCellValue('J1', 'Pendidikan SMP')
    ->setCellValue('K1', 'Pendidikan SMA/SMK')
    ->setCellValue('L1', 'Jurusan SMA/SMK')
    ->setCellValue('M1', 'Pendidikan Sarjana')
    ->setCellValue('N1', 'Jurusan Sarjana')
    ->setCellValue('O1', 'Pendidikan Magister')
    ->setCellValue('P1', 'Jurusan Magister')
    ->setCellValue('Q1', 'Nomor HP')
    ->setCellValue('R1', 'Email')
    ->setCellValue('S1', 'Jenis Kelamin')
    ->setCellValue('T1', 'Agama')
    ->setCellValue('U1', 'Status Administrasi')
    ->setCellValue('V1', 'Tanggal Daftar')
;

// Styling untuk header
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['argb' => Color::COLOR_WHITE],
        'size' => 12,
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['argb' => '4F81BD'], // Warna header
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => Color::COLOR_BLACK],
        ],
    ],
];

// Terapkan styling ke header
$sheet->getStyle('A1:V1')->applyFromArray($headerStyle);

// Query untuk mengambil data kandidat dengan jenis_kandidat "internal" berdasarkan rentang tanggal
$query = "
    SELECT 
        nama_lengkap, 
        nama_ayah,
        nama_ibu, 
        tanggal_lahir, 
        alamat_lengkap, 
        golongan_darah, 
        tinggi_badan,
        berat_badan,  
        pendidikan_sd,
        pendidikan_smp,
        pendidikan_sma_smk,
        jurusan_sma_smk,
        pendidikan_sarjana,
        jurusan_sarjana,
        pendidikan_magister,
        jurusan_magister, 
        nomor_hp, 
        email,
        jenis_kelamin,
        agama,
        status_administrasi,
        tanggal_daftar 
    FROM 
        kandidat
    WHERE 
        jenis_kandidat = 'internal' AND
        tanggal_daftar BETWEEN '$start_date' AND '$end_date'
";

$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Tulis data ke spreadsheet mulai dari baris kedua setelah header
$rowNumber = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue("A$rowNumber", $row['nama_lengkap'])
        ->setCellValue("B$rowNumber", $row['nama_ayah'])
        ->setCellValue("C$rowNumber", $row['nama_ibu'])
        ->setCellValue("D$rowNumber", $row['tanggal_lahir'])
        ->setCellValue("E$rowNumber", $row['alamat_lengkap'])
        ->setCellValue("F$rowNumber", $row['golongan_darah'])
        ->setCellValue("G$rowNumber", $row['tinggi_badan'])
        ->setCellValue("H$rowNumber", $row['berat_badan'])
        ->setCellValue("I$rowNumber", $row['pendidikan_sd'])
        ->setCellValue("J$rowNumber", $row['pendidikan_smp'])
        ->setCellValue("K$rowNumber", $row['pendidikan_sma_smk'])
        ->setCellValue("L$rowNumber", $row['jurusan_sma_smk'])
        ->setCellValue("M$rowNumber", $row['pendidikan_sarjana'])
        ->setCellValue("N$rowNumber", $row['jurusan_sarjana'])
        ->setCellValue("O$rowNumber", $row['pendidikan_magister'])
        ->setCellValue("P$rowNumber", $row['jurusan_magister'])
        ->setCellValue("Q$rowNumber", $row['nomor_hp'])
        ->setCellValue("R$rowNumber", $row['email'])
        ->setCellValue("S$rowNumber", $row['jenis_kelamin'])
        ->setCellValue("T$rowNumber", $row['agama'])
        ->setCellValue("U$rowNumber", $row['status_administrasi'])
        ->setCellValue("V$rowNumber", $row['tanggal_daftar'])
    ;

    // Menambahkan border ke sel data
    $sheet->getStyle("A$rowNumber:V$rowNumber")->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
        ],
    ]);

    $rowNumber++;
}

// Menyesuaikan lebar kolom otomatis
foreach (range('A', 'V') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Buat file Excel dan kirim ke browser untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"Data_Kandidat_Internal_{$start_date}_to_{$end_date}.xlsx\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
