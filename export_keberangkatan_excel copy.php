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

// Ambil parameter tanggal dari form
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : null;

if (!$start_date || !$end_date) {
    die("Tanggal awal dan akhir harus ditentukan.");
}

// Buat instance Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan header kolom
$sheet->setCellValue('A1', 'Nama Lengkap')
    ->setCellValue('B1', 'Perusahaan')
    ->setCellValue('C1', 'TSK')
    ->setCellValue('D1', 'Daerah')
    ->setCellValue('E1', 'Jenis Pekerjaan')
    ->setCellValue('F1', 'Tanggal Keberangkatan')
    ->setCellValue('G1', 'Informasi Tambahan');

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
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

// Query untuk mengambil data berdasarkan tanggal keberangkatan
$query = "
    SELECT 
        k.nama_lengkap, 
        b.perusahaan, 
        b.tsk, 
        b.daerah, 
        b.jenis_pekerjaan, 
        b.tanggal_keberangkatan, 
        b.informasi_tambahan 
    FROM 
        keberangkatan b
    JOIN 
        kandidat k ON b.id_kandidat = k.id_kandidat 
    WHERE 
        b.tanggal_keberangkatan BETWEEN '$start_date' AND '$end_date'
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
        ->setCellValue("B$rowNumber", $row['perusahaan'])
        ->setCellValue("C$rowNumber", $row['tsk'])
        ->setCellValue("D$rowNumber", $row['daerah'])
        ->setCellValue("E$rowNumber", $row['jenis_pekerjaan'])
        ->setCellValue("F$rowNumber", $row['tanggal_keberangkatan'])
        ->setCellValue("G$rowNumber", $row['informasi_tambahan']);

    // Menambahkan border ke sel data
    $sheet->getStyle("A$rowNumber:G$rowNumber")->applyFromArray([
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
foreach (range('A', 'G') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Buat file Excel dan kirim ke browser untuk diunduh
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"Data_Keberangkatan_{$start_date}_to_{$end_date}.xlsx\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
