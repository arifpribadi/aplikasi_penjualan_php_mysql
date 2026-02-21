<?php include 'header.php'; ?>

<?php 
$periksa = mysql_query("select * from barang where jumlah <=3");
while($q = mysql_fetch_array($periksa)){	
	if($q['jumlah'] <= 3){	
		?>	
		<script>
		$(document).ready(function(){
			$('.notif-bell').css("color","#ef4444");
		});
		</script>
		<?php
	}
}
?>

<?php 
$per_hal = 10;
$jumlah_record = mysql_query("SELECT COUNT(*) from barang");
$jum = mysql_result($jumlah_record, 0);
$halaman = ceil($jum / $per_hal);
$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $per_hal;
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128230;</span>
		Data Barang
	</h2>
	<div class="d-flex gap-8">
		<a href="lap_barang.php" target="_blank" class="btn-modern btn-secondary-modern">
			&#128438; Cetak
		</a>
		<button data-toggle="modal" data-target="#myModal" class="btn-modern btn-primary-modern">
			&#43; Tambah Barang
		</button>
	</div>
</div>

<!-- STOCK WARNINGS -->
<?php 
$periksa2 = mysql_query("select * from barang where jumlah <=3");
while($q = mysql_fetch_array($periksa2)){	
	echo "<div class='stock-warning'><span class='warning-icon'>&#9888;</span> Stok <strong>".$q['nama']."</strong> tersisa <strong>".$q['jumlah']."</strong> unit. Segera pesan ulang!</div>";
}
?>

<!-- STATS ROW -->
<div style="display:flex; gap:12px; margin-bottom:20px; flex-wrap:wrap;">
	<div style="background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px 20px; display:flex; align-items:center; gap:10px; box-shadow:0 1px 3px rgba(0,0,0,0.08);">
		<span style="font-size:20px;">&#128230;</span>
		<div>
			<div style="font-size:18px; font-weight:700; color:#1e293b;"><?php echo $jum; ?></div>
			<div style="font-size:11px; color:#64748b;">Total Barang</div>
		</div>
	</div>
	<div style="background:white; border:1px solid #e2e8f0; border-radius:8px; padding:12px 20px; display:flex; align-items:center; gap:10px; box-shadow:0 1px 3px rgba(0,0,0,0.08);">
		<span style="font-size:20px;">&#128196;</span>
		<div>
			<div style="font-size:18px; font-weight:700; color:#1e293b;"><?php echo $halaman; ?></div>
			<div style="font-size:11px; color:#64748b;">Halaman</div>
		</div>
	</div>
</div>

<!-- SEARCH -->
<div class="card mb-24">
	<div class="card-body" style="padding:16px;">
		<form action="cari_act.php" method="get">
			<div class="search-bar" style="max-width:400px;">
				<span class="search-icon">&#128269;</span>
				<input type="text" name="cari" placeholder="Cari nama atau jenis barang...">
				<button type="submit" class="btn-modern btn-primary-modern" style="padding:6px 14px; font-size:12px;">Cari</button>
			</div>
		</form>
	</div>
</div>

<!-- TABLE -->
<div class="card">
	<div class="card-body" style="padding:0;">
		<table class="table-modern">
			<thead>
				<tr>
					<th style="width:50px;">No</th>
					<th>Nama Barang</th>
					<th>Harga Jual</th>
					<th>Jumlah Stok</th>
					<th style="width:200px;">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(isset($_GET['cari'])){
					$cari = mysql_real_escape_string($_GET['cari']);
					$brg = mysql_query("select * from barang where nama like '$cari' or jenis like '$cari'");
				}else{
					$brg = mysql_query("select * from barang limit $start, $per_hal");
				}
				$no = 1;
				while($b = mysql_fetch_array($brg)){
					$stok_class = $b['jumlah'] <= 3 ? 'badge-danger' : ($b['jumlah'] <= 10 ? 'badge-warning' : 'badge-success');
					?>
					<tr>
						<td class="text-muted"><?php echo $no++ ?></td>
						<td>
							<div style="font-weight:500;"><?php echo $b['nama'] ?></div>
						</td>
						<td class="fw-600">Rp <?php echo number_format($b['harga']) ?>,-</td>
						<td>
							<span class="badge-modern <?php echo $stok_class; ?>"><?php echo $b['jumlah'] ?> unit</span>
						</td>
						<td>
							<div class="d-flex gap-8">
								<a href="det_barang.php?id=<?php echo $b['id']; ?>" class="btn-modern btn-info-modern" style="padding:5px 10px; font-size:12px;">Detail</a>
								<a href="edit.php?id=<?php echo $b['id']; ?>" class="btn-modern btn-warning-modern" style="padding:5px 10px; font-size:12px;">Edit</a>
								<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus.php?id=<?php echo $b['id']; ?>' }" class="btn-modern btn-danger-modern" style="padding:5px 10px; font-size:12px; cursor:pointer;">Hapus</a>
							</div>
						</td>
					</tr>		
					<?php 
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4" style="font-weight:600; color:#64748b;">&#128181; Total Modal Keseluruhan</td>
					<td>
						<?php 
						$x = mysql_query("select sum(modal) as total from barang");	
						$xx = mysql_fetch_array($x);			
						echo "<span style='font-size:15px; font-weight:700; color:#4f46e5;'>Rp ".number_format($xx['total']).",-</span>";		
						?>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<!-- PAGINATION -->
<?php if($halaman > 1): ?>
<div class="pagination-modern mt-16">
	<?php 
	for($x = 1; $x <= $halaman; $x++){
		$active = ($page == $x) ? 'active' : '';
		echo "<a href='?page=$x' class='$active'>$x</a>";
	}
	?>
</div>
<?php endif; ?>

<!-- MODAL TAMBAH BARANG -->
<div id="myModal" class="modal fade modal-modern">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">&#43; Tambah Barang Baru</h4>
			</div>
			<form action="tmb_brg_act.php" method="post" class="form-modern">
				<div class="modal-body">
					<div class="form-group">
						<label>Nama Barang</label>
						<input name="nama" type="text" placeholder="Nama Barang ..">
					</div>
					<div class="form-group">
						<label>Jenis</label>
						<input name="jenis" type="text" placeholder="Jenis Barang ..">
					</div>
					<div class="form-group">
						<label>Suplier</label>
						<input name="suplier" type="text" placeholder="Suplier ..">
					</div>
					<div class="form-group">
						<label>Harga Modal</label>
						<input name="modal" type="text" placeholder="Modal per unit">
					</div>	
					<div class="form-group">
						<label>Harga Jual</label>
						<input name="harga" type="text" placeholder="Harga Jual per unit">
					</div>	
					<div class="form-group">
						<label>Jumlah</label>
						<input name="jumlah" type="text" placeholder="Jumlah">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-modern btn-secondary-modern" data-dismiss="modal">Batal</button>
					<input type="submit" class="btn-modern btn-primary-modern" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<?php 
include 'footer.php';
?>
