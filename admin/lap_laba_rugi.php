<?php

include 'config.php';
require('../assets/pdf/fpdf.php');

// load kop surat settings
$settings_file = __DIR__ . '/report_settings.json';
$settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : array();
$defaults = array('company_name'=>'KIOS MALASNGODING','phone'=>'0038XXXXXXX','address'=>'JL. KIOS MALASNGODING','website'=>'www.malasngoding.com','email'=>'malasngoding@gmail.com','logo'=>'malasngoding.png');
$settings = array_merge($defaults, $settings);

$pdf = new FPDF("L","cm","A4");

$pdf->SetMargins(2,1,1);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','B',11);
$logo_path = file_exists(__DIR__ . '/../logo/' . $settings['logo']) ? '../logo/' . $settings['logo'] : '../logo/malasngoding.png';
$pdf->Image($logo_path,1,1,2,2);
$pdf->SetX(4);            
$pdf->MultiCell(19.5,0.5,$settings['company_name'],0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'Telpon : ' . $settings['phone'],0,'L');    
$pdf->SetFont('Arial','B',10);
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,$settings['address'],0,'L');
$pdf->SetX(4);
$pdf->MultiCell(19.5,0.5,'website : ' . $settings['website'] . ' email : ' . $settings['email'],0,'L');
$pdf->Line(1,3.1,28.5,3.1);
$pdf->SetLineWidth(0.1);      
$pdf->Line(1,3.2,28.5,3.2);   
$pdf->SetLineWidth(0);
$pdf->ln(1);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,0.7,'Laporan Laba Rugi',0,0,'C');
$pdf->ln(1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,0.7,"Di cetak pada : ".date("D-d/m/Y"),0,0,'C');
$pdf->ln(1);
$dari = $_GET['dari'];
$sampai = $_GET['sampai'];
$pdf->Cell(6,0.7,"Periode : ".$dari ." s/d ".$sampai,0,0,'C');
$pdf->ln(1);

// Table header
$pdf->SetFont('Arial','B',9);
$pdf->Cell(1, 0.8, 'NO', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Tanggal', 1, 0, 'C');
$pdf->Cell(6, 0.8, 'Nama Barang', 1, 0, 'C');
$pdf->Cell(2, 0.8, 'Jumlah', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Harga Jual', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Modal/Satuan', 1, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Modal Total', 1, 0, 'C');
$pdf->Cell(3.5, 0.8, 'Total Jual', 1, 0, 'C');
$pdf->Cell(3, 0.8, 'Laba', 1, 1, 'C');

$pdf->SetFont('Arial','',9);

$no=1;

// Join barang_laku with barang to fetch modal
$query = mysql_query("SELECT bl.tanggal, bl.nama, bl.jumlah, bl.harga, bl.total_harga, bl.laba, b.modal 
    FROM barang_laku bl LEFT JOIN barang b ON bl.nama = b.nama 
    WHERE bl.tanggal >= '$dari' AND bl.tanggal <= '$sampai' ORDER BY bl.tanggal ASC");

$total_pendapatan = 0;
$total_modal = 0;
$total_laba = 0;

while($row = mysql_fetch_array($query)){
    $modal_satuan = isset($row['modal']) ? $row['modal'] : 0;
    $modal_total = $modal_satuan * $row['jumlah'];
    $pdf->Cell(1, 0.8, $no , 1, 0, 'C');
    $pdf->Cell(3, 0.8, $row['tanggal'],1, 0, 'C');
    $pdf->Cell(6, 0.8, $row['nama'],1, 0, 'C');
    $pdf->Cell(2, 0.8, $row['jumlah'], 1, 0,'C');
    $pdf->Cell(3, 0.8, "Rp. ".number_format($row['harga'])." ,-", 1, 0,'C');
    $pdf->Cell(3, 0.8, "Rp. ".number_format($modal_satuan)." ,-", 1, 0,'C');
    $pdf->Cell(3.5, 0.8, "Rp. ".number_format($modal_total)." ,-",1, 0, 'C');
    $pdf->Cell(3.5, 0.8, "Rp. ".number_format($row['total_harga'])." ,-",1, 0, 'C');
    $pdf->Cell(3, 0.8, "Rp. ".number_format($row['laba'])." ,-", 1, 1,'C');

    $total_pendapatan += $row['total_harga'];
    $total_modal += $modal_total;
    $total_laba += $row['laba'];

    $no++;
}

// Totals
$pdf->SetFont('Arial','B',9);
$pdf->Cell(18.5, 0.8, "Total Pendapatan", 1, 0,'C');
$pdf->Cell(3.5, 0.8, "Rp. ".number_format($total_pendapatan)." ,-", 1, 1,'C');

$pdf->Cell(18.5, 0.8, "Total Modal", 1, 0,'C');
$pdf->Cell(3.5, 0.8, "Rp. ".number_format($total_modal)." ,-", 1, 1,'C');

$pdf->Cell(18.5, 0.8, "Total Laba (Pendapatan - Modal)", 1, 0,'C');
$pdf->Cell(3.5, 0.8, "Rp. ".number_format($total_pendapatan - $total_modal)." ,-", 1, 1,'C');

$pdf->Output("laporan_labarugi.pdf","I");

?>