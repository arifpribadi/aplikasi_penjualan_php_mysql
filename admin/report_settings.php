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
    echo "<div class='alert alert-success'>Pengaturan tersimpan.</div>";
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

<div class="col-md-10">
    <h3><span class="glyphicon glyphicon-cog"></span>  Pengaturan Kop Surat</h3>
    <form method="post" enctype="multipart/form-data" style="max-width:720px">
        <div class="form-group">
            <label>Nama Perusahaan</label>
            <input class="form-control" name="company_name" value="<?php echo htmlspecialchars($settings['company_name']); ?>">
        </div>
        <div class="form-group">
            <label>Telepon</label>
            <input class="form-control" name="phone" value="<?php echo htmlspecialchars($settings['phone']); ?>">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input class="form-control" name="address" value="<?php echo htmlspecialchars($settings['address']); ?>">
        </div>
        <div class="form-group">
            <label>Website</label>
            <input class="form-control" name="website" value="<?php echo htmlspecialchars($settings['website']); ?>">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" name="email" value="<?php echo htmlspecialchars($settings['email']); ?>">
        </div>
        <div class="form-group">
            <label>Logo saat ini</label>
            <div>
                <img src="../logo/<?php echo htmlspecialchars($settings['logo']); ?>" style="max-height:80px">
            </div>
        </div>
        <div class="form-group">
            <label>Unggah logo (opsional)</label>
            <input type="file" name="logo" accept="image/*">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
