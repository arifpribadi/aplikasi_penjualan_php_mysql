<?php include 'header.php'; ?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#128179;</span>
		Data Penjualan
	</h2>
	<div class="d-flex gap-8">
		<?php 
		if(isset($_GET['tanggal'])){
			$tanggal = mysql_real_escape_string($_GET['tanggal']);
			$tg = "lap_barang_laku.php?tanggal='$tanggal'";
			echo "<a href='$tg' target='_blank' class='btn-modern btn-secondary-modern'>&#128438; Cetak</a>";
		}
		?>
		<button data-toggle="modal" data-target="#myModal" class="btn-modern btn-primary-modern">
			&#43; Entry Penjualan
		</button>
	</div>
</div>

<!-- FILTER BY DATE -->
<div class="card mb-24">
	<div class="card-body" style="padding:16px;">
		<form action="" method="get">
			<div class="d-flex align-center gap-12" style="flex-wrap:wrap;">
				<label style="font-size:13px; font-weight:500; color:#1e293b; white-space:nowrap;">&#128197; Filter Tanggal:</label>
				<div class="search-bar" style="min-width:220px;">
					<span class="search-icon">&#128197;</span>
					<select name="tanggal" class="form-control" onchange="this.form.submit()" style="border:none; outline:none; font-size:13.5px; font-family:inherit; background:transparent; width:100%; color:#1e293b;">
						<option value="">Semua Tanggal</option>
						<?php 
						$pil = mysql_query("select distinct tanggal from barang_laku order by tanggal desc");
						while($p = mysql_fetch_array($pil)){
							$selected = (isset($_GET['tanggal']) && $_GET['tanggal'] == $p['tanggal']) ? 'selected' : '';
							echo "<option $selected>".$p['tanggal']."</option>";
						}
						?>			
					</select>
				</div>
				<?php if(isset($_GET['tanggal']) && $_GET['tanggal']): ?>
				<span class="badge-modern badge-info">Menampilkan: <?php echo htmlspecialchars($_GET['tanggal']); ?></span>
				<a href="barang_laku.php" class="btn-modern btn-secondary-modern" style="padding:5px 10px; font-size:12px;">&#10005; Reset</a>
				<?php endif; ?>
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
					<th>Tanggal</th>
					<th>Nama Barang</th>
					<th>Harga /pc</th>
					<th>Total Harga</th>
					<th>Jumlah</th>
					<th>Laba</th>
					<th style="width:150px;">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(isset($_GET['tanggal']) && $_GET['tanggal']){
					$tanggal = mysql_real_escape_string($_GET['tanggal']);
					$brg = mysql_query("select * from barang_laku where tanggal like '$tanggal' order by tanggal desc");
				}else{
					$brg = mysql_query("select * from barang_laku order by tanggal desc");
				}
				$no = 1;
				while($b = mysql_fetch_array($brg)){
					?>
					<tr>
						<td class="text-muted"><?php echo $no++ ?></td>
						<td><span class="badge-modern badge-info"><?php echo $b['tanggal'] ?></span></td>
						<td style="font-weight:500;"><?php echo $b['nama'] ?></td>
						<td>Rp <?php echo number_format($b['harga']) ?>,-</td>
						<td class="fw-600">Rp <?php echo number_format($b['total_harga']) ?>,-</td>
						<td><?php echo $b['jumlah'] ?> unit</td>
						<td class="text-success-color fw-600">Rp <?php echo number_format($b['laba']) ?>,-</td>
						<td>
							<div class="d-flex gap-8">
								<a href="edit_laku.php?id=<?php echo $b['id']; ?>" class="btn-modern btn-warning-modern" style="padding:5px 10px; font-size:12px;">Edit</a>
								<a onclick="if(confirm('Apakah anda yakin ingin menghapus data ini ??')){ location.href='hapus_laku.php?id=<?php echo $b['id']; ?>&jumlah=<?php echo $b['jumlah'] ?>&nama=<?php echo $b['nama']; ?>' }" class="btn-modern btn-danger-modern" style="padding:5px 10px; font-size:12px; cursor:pointer;">Hapus</a>
							</div>
						</td>
					</tr>
					<?php 
				}
				?>
			</tbody>
			<?php if(isset($_GET['tanggal']) && $_GET['tanggal']): ?>
			<tfoot>
				<?php 
				$tanggal = mysql_real_escape_string($_GET['tanggal']);
				$x = mysql_query("select sum(total_harga) as total, sum(laba) as total_laba from barang_laku where tanggal='$tanggal'");	
				$xx = mysql_fetch_array($x);
				?>
				<tr>
					<td colspan="4" style="font-weight:600; color:#64748b;">&#128181; Total Pemasukan</td>
					<td colspan="4" style="font-size:15px; font-weight:700; color:#4f46e5;">Rp <?php echo number_format($xx['total']); ?>,-</td>
				</tr>
				<tr>
					<td colspan="4" style="font-weight:600; color:#64748b;">&#128200; Total Laba</td>
					<td colspan="4" style="font-size:15px; font-weight:700; color:#10b981;">Rp <?php echo number_format($xx['total_laba']); ?>,-</td>
				</tr>
			</tfoot>
			<?php endif; ?>
		</table>
	</div>
</div>

<!-- MODAL ENTRY PENJUALAN -->
<div id="myModal" class="modal fade modal-modern">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">&#43; Entry Penjualan Baru</h4>
			</div>
			<form action="barang_laku_act.php" method="post" class="form-modern">
				<div class="modal-body">
					<div class="form-group">
						<label>Tanggal Penjualan</label>
						<input name="tgl" type="text" id="tgl" autocomplete="off" placeholder="Pilih tanggal...">
					</div>
					<div class="form-group">
						<label>Daftar Barang <span class="text-muted" style="font-weight:400;">(bisa tambah lebih dari 1)</span></label>
						<div style="overflow-x:auto;">
							<table class="table-modern" id="items_table" style="min-width:500px;">
								<thead>
									<tr>
										<th>Nama Barang</th>
										<th>Harga Jual /unit</th>
										<th>Jumlah</th>
										<th style="width:80px;">Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr class="item-row">
										<td>
											<select class="form-control" name="nama[]" style="border:1.5px solid #e2e8f0; border-radius:8px; padding:8px 10px; font-size:13px; width:100%;">
												<?php 
												$brg = mysql_query("select * from barang");
												while($b = mysql_fetch_array($brg)){
													echo '<option value="'.$b['nama'].'">'.$b['nama'].'</option>';
												}
												?>
											</select>
										</td>
										<td><input name="harga[]" type="text" placeholder="Harga" autocomplete="off"></td>
										<td><input name="jumlah[]" type="text" placeholder="Jumlah" autocomplete="off"></td>
										<td><button type="button" class="btn-modern btn-danger-modern remove-row" style="padding:5px 10px; font-size:12px;">&#10005;</button></td>
									</tr>
								</tbody>
							</table>
						</div>
						<button type="button" id="add_row" class="btn-modern btn-secondary-modern" style="margin-top:10px;">
							&#43; Tambah Baris
						</button>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-modern btn-secondary-modern" data-dismiss="modal">Batal</button>
					<input type="reset" class="btn-modern btn-danger-modern" value="Reset">
					<input type="submit" class="btn-modern btn-primary-modern" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#tgl").datepicker({dateFormat : 'yy/mm/dd'}); 

	$('#add_row').on('click', function(){
		var row = $('.item-row:first').clone();
		row.find('input').val('');
		$('#items_table tbody').append(row);
	});

	$(document).on('click', '.remove-row', function(){
		if($('#items_table tbody tr').length > 1){
			$(this).closest('tr').remove();
		}
	});
});
</script>

<?php include 'footer.php'; ?>
