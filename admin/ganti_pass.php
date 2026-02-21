<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128274;</span>
		Ganti Password
	</h2>
</div>

<?php 
if(isset($_GET['pesan'])){
	$pesan = mysql_real_escape_string($_GET['pesan']);
	if($pesan == "gagal"){
		echo "<div class='alert-modern alert-danger mb-16'><span>&#9888;</span> Password gagal diganti! Periksa kembali password lama Anda.</div>";
	}else if($pesan == "tdksama"){
		echo "<div class='alert-modern alert-warning mb-16'><span>&#9888;</span> Password baru dan konfirmasi tidak sesuai. Silahkan ulangi.</div>";
	}else if($pesan == "oke"){
		echo "<div class='alert-modern alert-success mb-16'><span>&#10003;</span> Password berhasil diubah!</div>";
	}
}
?>

<div class="card" style="max-width:500px;">
	<div class="card-header">
		<h3>&#128274; Ubah Password Akun</h3>
	</div>
	<div class="card-body">
		<form action="ganti_pass_act.php" method="post" class="form-modern">
			<input name="user" type="hidden" value="<?php echo htmlspecialchars($_SESSION['uname']); ?>">
			<div class="form-group">
				<label>Password Lama</label>
				<input name="lama" type="password" placeholder="Masukkan password lama...">
			</div>
			<div class="form-group">
				<label>Password Baru</label>
				<input name="baru" type="password" placeholder="Masukkan password baru...">
			</div>
			<div class="form-group">
				<label>Konfirmasi Password Baru</label>
				<input name="ulang" type="password" placeholder="Ulangi password baru...">
			</div>
			<div class="d-flex gap-8" style="margin-top:8px;">
				<input type="submit" class="btn-modern btn-primary-modern" value="&#10003; Simpan Password">
				<input type="reset" class="btn-modern btn-danger-modern" value="Reset">
			</div>
		</form>
	</div>
</div>

<?php 
include 'footer.php';
?>
