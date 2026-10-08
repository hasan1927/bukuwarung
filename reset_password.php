<?php
session_start();
$error = '';
$success = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "portaldb");

    // Cek token di database
    $query = "SELECT * FROM users WHERE reset_token='$token'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        if (isset($_POST['reset'])) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $query = "UPDATE users SET password='$new_password', reset_token=NULL WHERE reset_token='$token'";
            if (mysqli_query($koneksi, $query)) {
                $success = "Password Anda telah berhasil direset. Anda akan diarahkan ke halaman login dalam 10 detik.";
            } else {
                $error = "Gagal mereset password.";
            }
        }
    } else {
        $error = "Token tidak valid atau tidak ditemukan.";
    }
} else {
    $error = "Token tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        // Redirect setelah 3 detik jika ada pesan sukses
        window.onload = function() {
            var successMessage = "<?php echo $success; ?>";
            if (successMessage) {
                setTimeout(function() {
                    window.location.href = "login.php"; // Ubah "login.php" sesuai dengan halaman login Anda
                }, 3000); // 3 detik
            }
        };
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reset Password</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (!$success): ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="reset">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
