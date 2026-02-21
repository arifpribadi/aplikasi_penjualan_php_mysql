<?php
session_start();
include 'cek.php';
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>KIOS MALASNGODING</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../assets/js/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/modern.css">
	<script type="text/javascript" src="../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-ui/jquery-ui.js"></script>
</head>
<body>
<div class="admin-wrapper">

	<!-- SIDEBAR -->
	<aside class="sidebar" id="sidebar">
		<div class="sidebar-brand">
			<div class="brand-icon">&#128722;</div>
			<div class="brand-text">
				<h3>KIOS</h3>
				<span>Malasngoding</span>
			</div>
		</div>

		<div class="sidebar-user">
			<?php 
			$use = $_SESSION['uname'];
			$fo = mysql_query("select foto from admin where uname='$use'");
			$f = mysql_fetch_array($fo);
			if($f && $f['foto'] && file_exists("foto/".$f['foto'])){
				echo '<img class="user-avatar" src="foto/'.$f['foto'].'" alt="Avatar">';
			} else {
				echo '<div class="user-avatar-placeholder">&#128100;</div>';
			}
			?>
			<div class="user-info">
				<h4><?php echo htmlspecialchars($_SESSION['uname']); ?></h4>
				<span>Administrator</span>
			</div>
		</div>

		<nav class="sidebar-nav">
			<div class="nav-section-title">Menu Utama</div>
			<a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='index.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#127968;</span> Dashboard
			</a>
			<a href="barang.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='barang.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#128230;</span> Data Barang
			</a>
			<a href="barang_laku.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='barang_laku.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#128179;</span> Entry Penjualan
			</a>

			<div class="nav-section-title" style="margin-top:8px;">Laporan</div>
			<a href="lap_laba_rugi_form.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='lap_laba_rugi_form.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#128202;</span> Laba Rugi
			</a>

			<div class="nav-section-title" style="margin-top:8px;">Pengaturan</div>
			<a href="report_settings.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='report_settings.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#9881;</span> Pengaturan Kop
			</a>
			<a href="ganti_foto.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='ganti_foto.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#128247;</span> Ganti Foto
			</a>
			<a href="ganti_pass.php" class="<?php echo basename($_SERVER['PHP_SELF'])=='ganti_pass.php' ? 'active' : ''; ?>">
				<span class="nav-icon">&#128274;</span> Ganti Password
			</a>

			<div class="nav-section-title" style="margin-top:8px;"></div>
			<a href="logout.php" style="color:#f87171;">
				<span class="nav-icon">&#128682;</span> Logout
			</a>
		</nav>
	</aside>

	<!-- MAIN CONTENT -->
	<div class="main-content">

		<!-- TOPBAR -->
		<header class="topbar">
			<div class="topbar-left">
				<button class="topbar-btn" id="sidebarToggle" style="display:none;">
					&#9776;
				</button>
				<span class="topbar-title">
					<?php
					$page = basename($_SERVER['PHP_SELF']);
					$titles = [
						'index.php' => 'Dashboard',
						'barang.php' => 'Data Barang',
						'barang_laku.php' => 'Entry Penjualan',
						'lap_laba_rugi_form.php' => 'Laporan Laba Rugi',
						'report_settings.php' => 'Pengaturan Kop',
						'ganti_foto.php' => 'Ganti Foto',
						'ganti_pass.php' => 'Ganti Password',
						'edit.php' => 'Edit Barang',
						'det_barang.php' => 'Detail Barang',
						'edit_laku.php' => 'Edit Penjualan',
					];
					echo isset($titles[$page]) ? $titles[$page] : 'Admin Panel';
					?>
				</span>
			</div>
			<div class="topbar-right">
				<?php 
				$periksa_notif = mysql_query("select count(*) as cnt from barang where jumlah <=3");
				$notif_row = mysql_fetch_array($periksa_notif);
				$notif_count = $notif_row['cnt'];
				?>
				<a href="#" class="topbar-btn" data-toggle="modal" data-target="#modalpesan" title="Notifikasi Stok">
					&#128276;
					<?php if($notif_count > 0): ?>
					<span class="badge-dot"></span>
					<?php endif; ?>
				</a>
				<div class="topbar-user">
					<span style="font-size:20px;">&#128100;</span>
					<span class="user-name"><?php echo htmlspecialchars($_SESSION['uname']); ?></span>
				</div>
			</div>
		</header>

		<!-- NOTIFICATION MODAL -->
		<div id="modalpesan" class="modal fade modal-modern">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">&#128276; Notifikasi Stok</h4>
					</div>
					<div class="modal-body">
						<?php 
						$periksa = mysql_query("select * from barang where jumlah <=3");
						$found = false;
						while($q = mysql_fetch_array($periksa)){	
							if($q['jumlah'] <= 3){
								$found = true;
								echo "<div class='stock-warning'><span class='warning-icon'>&#9888;</span> Stok <strong>".$q['nama']."</strong> tersisa <strong>".$q['jumlah']."</strong> unit. Segera pesan ulang!</div>";
							}
						}
						if(!$found){
							echo "<div class='alert-modern alert-success'><span>&#10003;</span> Semua stok barang dalam kondisi aman.</div>";
						}
						?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn-modern btn-secondary-modern" data-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>

		<!-- PAGE CONTENT START -->
		<div class="page-content">
