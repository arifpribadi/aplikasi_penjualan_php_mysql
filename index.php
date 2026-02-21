<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>KIOS MALASNGODING - Login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/modern.css">
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<?php include 'admin/config.php'; ?>
</head>
<body>
<div class="login-wrapper">
	<div class="login-card">
		<div class="login-logo">
			<div class="logo-icon">&#128722;</div>
			<h2>KIOS MALASNGODING</h2>
			<p>Sistem Manajemen Penjualan</p>
		</div>

		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan'] == "gagal"){
				echo "<div class='alert-modern alert-danger'><span>&#9888;</span> Username atau Password salah. Silahkan coba lagi.</div>";
			}
		}
		?>

		<form action="login_act.php" method="post" class="login-form">
			<div class="form-group">
				<label>Username</label>
				<div class="input-wrapper">
					<span class="input-icon">&#128100;</span>
					<input type="text" name="uname" placeholder="Masukkan username" autocomplete="off" required>
				</div>
			</div>
			<div class="form-group">
				<label>Password</label>
				<div class="input-wrapper">
					<span class="input-icon">&#128274;</span>
					<input type="password" name="pass" placeholder="Masukkan password" required>
				</div>
			</div>
			<button type="submit" class="btn-login">Masuk &rarr;</button>
		</form>

		<p style="text-align:center; margin-top:20px; font-size:12px; color:#94a3b8;">
			&copy; 2024 Kios Malasngoding &mdash; <a href="http://www.malasngoding.com" style="color:#4f46e5; text-decoration:none;">malasngoding.com</a>
		</p>
	</div>
</div>
</body>
</html>
