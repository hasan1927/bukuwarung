<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan path ini benar
require ('koneksi.php');
if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    // Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "portaldb");

    // Cek apakah email ada di database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Email ditemukan, buat token dan kirim email
        $token = bin2hex(random_bytes(50));
        $updateQuery = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        mysqli_query($koneksi, $updateQuery);

        // Kirim email reset password
        $mail = new PHPMailer(true);
        $mail = new PHPMailer(true);
        try {
            // Mengatur PHPMailer untuk menggunakan SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
                $mail->SMTPAuth = true;
                $mail->Username = 'hasanthalib417@gmail.com'; // Email Anda
                $mail->Password = 'kivarobjqmlqiegt'; // Password email Anda
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;


        
            // Penerima dan pengaturan lainnya
            $mail->setFrom('hasanthalib417@gmail.com', 'Reset Sandi');
            $mail->addAddress($email); // Alamat email penerima
            $mail->isHTML(true);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    /* Basic email styling */
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                        margin: 0;
                    }
                    .email-container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        border-radius: 10px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        padding: 40px;
                    }
                    .card {
                        background-color: #ffffff;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        padding: 30px;
                        text-align: center;
                        transition: box-shadow 0.3s ease;
                    }
                    .card:hover {
                        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                    }
                    .card h2 {
                        color: #333333;
                        font-size: 24px;
                        margin-bottom: 20px;
                        font-weight: bold;
                    }
                    .card p {
                        color: #666666;
                        font-size: 16px;
                        margin-bottom: 20px;
                    }
                    .button {
                        display: inline-block;
                        padding: 12px 24px;
                        background-color: #007BFF;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 16px;
                        margin-top: 15px;
                        transition: background-color 0.3s ease;
                    }
                    .button:hover {
                        background-color: #0056b3;
                    }
                    .footer {
                        text-align: center;
                        color: #888888;
                        font-size: 12px;
                        margin-top: 30px;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="card">
                        <h2>Password Reset Request</h2>
                        <p>Hi there,</p>
                        <p>Kami telah menerima permintaan untuk mereset kata sandi Anda. Silakan klik tautan di bawah ini untuk mereset kata sandi Anda:</p>
                        <a href="http://localhost/bukuwarung/reset_password.php?token=$token" class="button">Reset Password</a>
                        <p>Jika Anda tidak melakukan permintaan untuk mereset kata sandi, harap abaikan email ini.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; 2024 Bukuwarung. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
            ';
            

            $mail->send();
            $email_sent = true;  // Set email_sent ke true jika email berhasil dikirim
            } catch (Exception $e) {
                $email_sent = false;  // Set email_sent ke false jika ada kesalahan
            }
        } else {
            $email_sent = false; // Email tidak ditemukan
        }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h2 class="text-center mb-4">Lupa Password</h2>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="forgot_password">Kirim Email Reset Password</button>
                    <p class="text-center mt-3">Sudah punya akun? <a href="login.php">klik disini</a></p>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($email_sent)): ?>
        <script type="text/javascript">
            // Cek apakah email terkirim
            <?php if ($email_sent): ?>
                alert("Email untuk reset password telah dikirim. Cek inbox atau folder spam Anda.");
            <?php else: ?>
                alert("Terjadi kesalahan. Email tidak ditemukan.");
            <?php endif; ?>
        </script>
    <?php endif; ?>
</body>
</html>
