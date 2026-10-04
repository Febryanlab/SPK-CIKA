<?php
require '../vendor/fpdf/fpdf.php';
include '../config/koneksi.php';

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(30, 64, 175);
$pdf->Cell(0, 10, 'PT CIKA MULIA MULTIMEDIA', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'LAPORAN HASIL PENGELOMPOKAN WILAYAH PENGIRIMAN', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Metode TOPSIS — Tanggal: ' . date('d F Y'), 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFillColor(56, 189, 248);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 8, 'Rank', 1, 0, 'C', true);
$pdf->Cell(60, 8, 'Nama Pelanggan', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Kota', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Skor', 1, 0, 'C', true);
$pdf->Cell(55, 8, 'Zona', 1, 1, 'C', true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$q = mysqli_query($koneksi, "SELECT h.*, p.nama_pelanggan, p.kota
  FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
while($r = mysqli_fetch_assoc($q)){
    $pdf->Cell(15, 8, $r['ranking'], 1, 0, 'C');
    $pdf->Cell(60, 8, $r['nama_pelanggan'], 1);
    $pdf->Cell(40, 8, $r['kota'], 1);
    $pdf->Cell(35, 8, number_format($r['skor_topsis'], 4), 1, 0, 'C');
    $pdf->Cell(55, 8, $r['zona'], 1, 1, 'C');
}
$pdf->Output('D', 'Laporan_TOPSIS_Cika_' . date('Ymd') . '.pdf');
?>