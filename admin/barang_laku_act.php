<?php
include 'config.php';

$tgl = mysql_real_escape_string($_POST['tgl']);

// support multiple items: nama[], harga[], jumlah[]
if (isset($_POST['nama']) && is_array($_POST['nama'])) {
	$names = $_POST['nama'];
	$prices = $_POST['harga'];
	$amounts = $_POST['jumlah'];

	for ($i = 0; $i < count($names); $i++) {
		$nama = mysql_real_escape_string($names[$i]);
		$harga = floatval($prices[$i]);
		$jumlah = intval($amounts[$i]);

		if ($nama === '' || $jumlah <= 0) continue;

		$dt = mysql_query("select * from barang where nama='$nama'") or die(mysql_error());
		$data = mysql_fetch_array($dt);
		if (!$data) continue;

		// update stock
		$sisa = $data['jumlah'] - $jumlah;
		if ($sisa < 0) $sisa = 0;
		mysql_query("update barang set jumlah='$sisa' where nama='$nama'");

		$modal = $data['modal'];
		$laba = $harga - $modal;
		$labaa = $laba * $jumlah;
		$total_harga = $harga * $jumlah;

		mysql_query("insert into barang_laku values(NULL,'$tgl','$nama','$jumlah','$harga','$total_harga','$labaa')") or die(mysql_error());
	}

} else {
	// fallback single item
	$nama = mysql_real_escape_string($_POST['nama']);
	$harga = floatval($_POST['harga']);
	$jumlah = intval($_POST['jumlah']);

	$dt = mysql_query("select * from barang where nama='$nama'") or die(mysql_error());
	$data = mysql_fetch_array($dt);
	$sisa = $data['jumlah'] - $jumlah;
	mysql_query("update barang set jumlah='$sisa' where nama='$nama'");

	$modal = $data['modal'];
	$laba = $harga - $modal;
	$labaa = $laba * $jumlah;
	$total_harga = $harga * $jumlah;
	mysql_query("insert into barang_laku values(NULL,'$tgl','$nama','$jumlah','$harga','$total_harga','$labaa')") or die(mysql_error());
}

header("location:barang_laku.php");

?>