<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#9998;</span>
		Edit Barang
	</h2>
	<a href="barang.php" class="btn-modern btn-secondary-modern">&#8592; Kembali</a>
</div>

<?php
$id_brg = mysql_real_escape_string($_GET['id']);
$det = mysql_query("select * from barang where id='$id_brg'") or die(mysql_error());
while($d = mysql_fetch_array($det)){
?>
<div class="card" style="max-width:600px;">
	<div class="card-header">
		<h3>&#128230; Informasi Barang</h3>
	</div>
	<div class="card-body">
		<form action="update.php" method="post" class="form-modern">
			<input type="hidden" name="id" value="<?php echo $d['id'] ?>">
			<div class="form-group">
				<label>Nama Barang</label>
				<input type="text" name="nama" value="<?php echo htmlspecialchars($d['nama']) ?>">
			</div>
			<div class="form-group">
				<label>Jenis</label>
				<input type="text" name="jenis" value="<?php echo htmlspecialchars($d['jenis']) ?>">
			</div>
			<div class="form-group">
				<label>Suplier</label>
				<input type="text" name="suplier" value="<?php echo htmlspecialchars($d['suplier']) ?>">
			</div>
			<div class="form-group">
				<label>Harga Modal</label>
				<input type="text" name="modal" value="<?php echo $d['modal'] ?>">
			</div>
			<div class="form-group">
				<label>Harga Jual</label>
				<input type="text" name="harga" value="<?php echo $d['harga'] ?>">
			</div>
			<div class="form-group">
				<label>Jumlah Stok</label>
				<input type="text" name="jumlah" value="<?php echo $d['jumlah'] ?>">
			</div>
			<div class="d-flex gap-8" style="margin-top:8px;">
				<input type="submit" class="btn-modern btn-primary-modern" value="&#10003; Simpan Perubahan">
				<a href="barang.php" class="btn-modern btn-secondary-modern">Batal</a>
			</div>
		</form>
	</div>
</div>
<?php 
}
?>

<?php include 'footer.php'; ?>
