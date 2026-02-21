<?php
include 'header.php';

$settings_file = __DIR__ . '/report_settings.json';
$settings = file_exists($settings_file) ? json_decode(file_get_contents($settings_file), true) : array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = $_POST['company_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $website = $_POST['website'] ?? '';
    $email = $_POST['email'] ?? '';

    // handle logo upload
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = __DIR__ . '/../logo/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fname = basename($_FILES['logo']['name']);
        $target = $uploadDir . $fname;
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
            $settings['logo'] = $fname;
        }
    }

    $settings['company_name'] = $company_name;
    $settings['phone'] = $phone;
    $settings['address'] = $address;
    $settings['website'] = $website;
    $settings['email'] = $email;

    file_put_contents($settings_file, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $saved = true;
}

// ensure defaults exist
$defaults = array(
    'company_name' => 'KIOS MALASNGODING',
    'phone' => '0038XXXXXXX',
    'address' => 'JL. KIOS MALASNGODING',
    'website' => 'www.malasngoding.com',
    'email' => 'malasngoding@gmail.com',
    'logo' => 'malasngoding.png'
);
$settings = array_merge($defaults, $settings);
?>

<div class="page-header">
	<h2>
		<span class="page-icon">&#9881;</span>
		Pengaturan Kop Surat
	</h2>
</div>

<?php if(isset($saved)): ?>
<div class="alert-modern alert-success mb-16"><span>&#10003;</span> Pengaturan berhasil disimpan!</div>
<?php endif; ?>

<div class="card" style="max-width:600px;">
	<div class="card-header">
		<h3>&#9881; Informasi Perusahaan</h3>
	</div>
	<div class="card-body">
		<form method="post" enctype="multipart/form-data" class="form-modern">
			<div class="form-group">
				<label>Nama Perusahaan</label>
				<input name="company_name" value="<?php echo htmlspecialchars($settings['company_name']); ?>">
			</div>
			<div class="form-group">
				<label>Telepon</label>
				<input name="phone" value="<?php echo htmlspecialchars($settings['phone']); ?>">
			</div>
			<div class="form-group">
				<label>Alamat</label>
				<input name="address" value="<?php echo htmlspecialchars($settings['address']); ?>">
			</div>
			<div class="form-group">
				<label>Website</label>
				<input name="website" value="<?php echo htmlspecialchars($settings['website']); ?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input name="email" value="<?php echo htmlspecialchars($settings['email']); ?>">
			</div>
			<div class="form-group">
				<label>Logo Saat Ini</label>
				<div style="margin-top:8px; padding:12px; background:#f8fafc; border-radius:8px; border:1px solid #e2e8f0;">
					<img src="../logo/<?php echo htmlspecialchars($settings['logo']); ?>" style="max-height:80px; max-width:200px;" onerror="this.style.display='none'">
				</div>
			</div>
			<div class="form-group">
				<label>Upload Logo Baru <span class="text-muted" style="font-weight:400;">(opsional)</span></label>
				<input type="file" name="logo" accept="image/*" style="padding:8px; border:1.5px solid #e2e8f0; border-radius:8px; width:100%; font-family:inherit; font-size:13px;">
			</div>
			<div style="margin-top:8px;">
				<button type="submit" class="btn-modern btn-primary-modern">&#10003; Simpan Pengaturan</button>
			</div>
		</form>
	</div>
</div>

<?php include 'footer.php'; ?>
