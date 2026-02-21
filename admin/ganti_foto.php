<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128247;</span>
		Ganti Foto Profil
	</h2>
</div>

<?php 
if(isset($_GET['pesan'])){
	$pesan = mysql_real_escape_string($_GET['pesan']);
	if($pesan == "oke"){
		echo "<div class='alert-modern alert-success mb-16'><span>&#10003;</span> Foto profil berhasil diubah!</div>";
	}
}
?>

<div class="card" style="max-width:500px;">
	<div class="card-header">
		<h3>&#128247; Upload Foto Baru</h3>
	</div>
	<div class="card-body">
		<form action="ganti_foto_act.php" method="post" enctype="multipart/form-data" class="form-modern">
			<input name="user" type="hidden" value="<?php echo htmlspecialchars($_SESSION['uname']); ?>">
			<div class="form-group">
				<label>Pilih Foto</label>
				<input name="foto" type="file" style="padding:8px; border:1.5px solid #e2e8f0; border-radius:8px; width:100%; font-family:inherit; font-size:13px;">
				<p style="font-size:12px; color:#64748b; margin-top:6px;">Format: JPG, PNG, GIF. Ukuran maksimal 2MB.</p>
			</div>
			<div class="d-flex gap-8" style="margin-top:8px;">
				<input type="submit" class="btn-modern btn-primary-modern" value="&#10003; Upload Foto">
				<input type="reset" class="btn-modern btn-danger-modern" value="Reset">
			</div>
		</form>
	</div>
</div>

<?php 
include 'footer.php';
?>
