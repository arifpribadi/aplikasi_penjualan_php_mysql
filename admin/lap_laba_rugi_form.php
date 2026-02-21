<?php
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128202;</span>
		Laporan Laba Rugi
	</h2>
</div>

<div class="card" style="max-width:500px;">
	<div class="card-header">
		<h3>&#128202; Pilih Periode Laporan</h3>
	</div>
	<div class="card-body">
		<form action="lap_laba_rugi.php" method="get" target="_blank" class="form-modern">
			<div class="form-group">
				<label>Dari Tanggal</label>
				<input type="text" id="dari" name="dari" autocomplete="off" value="<?php echo date('Y/m/d', strtotime('-30 days')); ?>">
			</div>
			<div class="form-group">
				<label>Sampai Tanggal</label>
				<input type="text" id="sampai" name="sampai" autocomplete="off" value="<?php echo date('Y/m/d'); ?>">
			</div>
			<div style="margin-top:8px;">
				<input type="submit" class="btn-modern btn-primary-modern" value="&#128438; Cetak Laporan">
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#dari,#sampai').datepicker({dateFormat: 'yy/mm/dd'});
});
</script>

<?php
include 'footer.php';
?>
