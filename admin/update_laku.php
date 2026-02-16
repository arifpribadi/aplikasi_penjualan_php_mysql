<?php 
include 'config.php';

$id = mysql_real_escape_string($_POST['id']);
$tgl = mysql_real_escape_string($_POST['tgl']);
$nama = mysql_real_escape_string($_POST['nama']);
$harga = mysql_real_escape_string($_POST['harga']);
$jumlah = mysql_real_escape_string($_POST['jumlah']);

// get existing sale record
$old = mysql_query("select * from barang_laku where id='$id'") or die(mysql_error());
$r = mysql_fetch_array($old);
$old_nama = $r['nama'];
$old_jumlah = $r['jumlah'];

// return old quantity to stock
$a = mysql_query("select jumlah from barang where nama='$old_nama'");
$b = mysql_fetch_array($a);
$kembalikan = $b['jumlah'] + $old_jumlah;
mysql_query("update barang set jumlah='$kembalikan' where nama='$old_nama'");

// deduct new quantity from selected product
$dt = mysql_query("select * from barang where nama='$nama'");
$data = mysql_fetch_array($dt);
$sisa = $data['jumlah'] - $jumlah;
mysql_query("update barang set jumlah='$sisa' where nama='$nama'");

$modal = $data['modal'];
$laba = $harga - $modal;
$labaa = $laba * $jumlah;
$total_harga = $harga * $jumlah;

mysql_query("update barang_laku set tanggal='$tgl', nama='$nama', jumlah='$jumlah', harga='$harga', total_harga='$total_harga', laba='$labaa' where id='$id'") or die(mysql_error());
header("location:barang_laku.php");

?>