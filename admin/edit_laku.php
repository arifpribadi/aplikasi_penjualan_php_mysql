<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#9998;</span>
		Edit Penjualan
	</h2>
	<a href="barang_laku.php" class="btn-modern btn-secondary-modern">&#8592; Kembali</a>
</div>

<?php
$id_brg = mysql_real_escape_string($_GET['id']);
$det = mysql_query("select * from barang_laku where id='$id_brg'") or die(mysql_error());
while($d = mysql_fetch_array($det)){
?>
<div class="card" style="max-width:600px;">
	<div class="card-header">
		<h3>&#128179; Data Penjualan</h3>
	</div>
	<div class="card-body">
		<form action="update_laku.php" method="post" class="form-modern">
			<input type="hidden" name="id" value="<?php echo $d['id'] ?>">
			<div class="form-group">
				<label>Tanggal</label>
				<input name="tgl" type="text" id="tgl" autocomplete="off" value="<?php echo $d['tanggal'] ?>">
			</div>
			<div class="form-group">
				<label>Nama Barang</label>
				<select name="nama" style="width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13.5px; font-family:inherit; color:#1e293b; background:white; outline:none;">
					<?php 
					$brg = mysql_query("select * from barang");
					while($b = mysql_fetch_array($brg)){
						$selected = ($d['nama'] == $b['nama']) ? 'selected' : '';
						echo "<option $selected value='".$b['nama']."'>".$b['nama']."</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label>Harga Jual /unit</label>
				<input type="text" name="harga" value="<?php echo $d['harga'] ?>">
			</div>
			<div class="form-group">
				<label>Jumlah</label>
				<input type="text" name="jumlah" value="<?php echo $d['jumlah'] ?>">
			</div>
			<div class="d-flex gap-8" style="margin-top:8px;">
				<input type="submit" class="btn-modern btn-primary-modern" value="&#10003; Simpan Perubahan">
				<a href="barang_laku.php" class="btn-modern btn-secondary-modern">Batal</a>
			</div>
		</form>
	</div>
</div>
<?php 
}
?>

<script type="text/javascript">
$(document).ready(function(){
	$('#tgl').datepicker({dateFormat: 'yy/mm/dd'});
});
</script>

<?php 
include 'footer.php';
?>
