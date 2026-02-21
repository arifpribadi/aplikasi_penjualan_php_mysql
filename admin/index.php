<?php 
include 'header.php';
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#127968;</span>
		Dashboard
	</h2>
	<span class="text-muted" style="font-size:13px;">Selamat datang, <strong><?php echo htmlspecialchars($_SESSION['uname']); ?></strong></span>
</div>

<!-- STAT CARDS -->
<div class="stat-grid">
	<?php
	$total_barang = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cnt FROM barang"));
	$total_terjual = mysql_fetch_array(mysql_query("SELECT COUNT(*) as cnt FROM barang_laku"));
	$total_modal = mysql_fetch_array(mysql_query("SELECT SUM(modal) as total FROM barang"));
	$total_laba = mysql_fetch_array(mysql_query("SELECT SUM(laba) as total FROM barang_laku"));
	?>
	<div class="stat-card">
		<div class="stat-icon blue">&#128230;</div>
		<div class="stat-info">
			<h4><?php echo $total_barang['cnt']; ?></h4>
			<p>Total Jenis Barang</p>
		</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon green">&#128179;</div>
		<div class="stat-info">
			<h4><?php echo $total_terjual['cnt']; ?></h4>
			<p>Total Transaksi</p>
		</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon orange">&#128181;</div>
		<div class="stat-info">
			<h4 style="font-size:16px;">Rp <?php echo number_format($total_modal['total']); ?></h4>
			<p>Total Modal</p>
		</div>
	</div>
	<div class="stat-card">
		<div class="stat-icon purple">&#128200;</div>
		<div class="stat-info">
			<h4 style="font-size:16px;">Rp <?php echo number_format($total_laba['total']); ?></h4>
			<p>Total Laba</p>
		</div>
	</div>
</div>

<!-- RECENT TRANSACTIONS & CALENDAR -->
<div style="display:grid; grid-template-columns: 1fr 300px; gap:16px; flex-wrap:wrap;">
	<div class="card">
		<div class="card-header">
			<h3>&#128203; Transaksi Terbaru</h3>
			<a href="barang_laku.php" class="btn-modern btn-primary-modern" style="font-size:12px; padding:6px 12px;">Lihat Semua</a>
		</div>
		<div class="card-body" style="padding:0;">
			<table class="table-modern" style="width:100%;">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Total Harga</th>
						<th>Laba</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$recent = mysql_query("SELECT * FROM barang_laku ORDER BY tanggal DESC LIMIT 8");
					while($r = mysql_fetch_array($recent)){
						echo "<tr>";
						echo "<td><span class='badge-modern badge-info'>".$r['tanggal']."</span></td>";
						echo "<td>".$r['nama']."</td>";
						echo "<td>".$r['jumlah']."</td>";
						echo "<td class='fw-600'>Rp ".number_format($r['total_harga']).",-</td>";
						echo "<td class='text-success-color fw-600'>Rp ".number_format($r['laba']).",-</td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="card">
		<div class="card-header">
			<h3>&#128197; Kalender</h3>
		</div>
		<div class="card-body" style="padding:12px;">
			<div id="kalender"></div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$("#kalender").datepicker({
		inline: true,
		showOtherMonths: true
	});
});
</script>

<?php 
include 'footer.php';
?>
