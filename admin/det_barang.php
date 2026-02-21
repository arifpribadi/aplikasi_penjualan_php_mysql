<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128230;</span>
		Detail Barang
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
		<h3>&#128230; <?php echo htmlspecialchars($d['nama']); ?></h3>
		<div class="d-flex gap-8">
			<a href="edit.php?id=<?php echo $d['id']; ?>" class="btn-modern btn-warning-modern" style="padding:6px 12px; font-size:12px;">&#9998; Edit</a>
		</div>
	</div>
	<div class="card-body">
		<table class="table-modern">
			<tbody>
				<tr>
					<td style="width:40%; color:#64748b; font-weight:500;">Nama Barang</td>
					<td style="font-weight:600;"><?php echo htmlspecialchars($d['nama']); ?></td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Jenis</td>
					<td><?php echo htmlspecialchars($d['jenis']); ?></td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Suplier</td>
					<td><?php echo htmlspecialchars($d['suplier']); ?></td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Harga Modal</td>
					<td class="fw-600">Rp <?php echo number_format($d['modal']); ?>,-</td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Harga Jual</td>
					<td class="fw-600 text-primary-color">Rp <?php echo number_format($d['harga']); ?>,-</td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Jumlah Stok</td>
					<td>
						<?php 
						$stok_class = $d['jumlah'] <= 3 ? 'badge-danger' : ($d['jumlah'] <= 10 ? 'badge-warning' : 'badge-success');
						echo "<span class='badge-modern $stok_class'>".$d['jumlah']." unit</span>";
						?>
					</td>
				</tr>
				<tr>
					<td style="color:#64748b; font-weight:500;">Sisa</td>
					<td><?php echo $d['sisa']; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php 
}
?>

<?php include 'footer.php'; ?>
