<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan path ini benar

if (isset($_POST['register'])) {
    $username = $_POST['username']; // Ambil username dari input
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(50));

    // Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "portaldb");

    // Cek apakah email sudah terdaftar
    $checkEmailQuery = "SELECT * FROM users WHERE email='$email'";
    $checkEmailResult = mysqli_query($koneksi, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.');</script>";
    } else {
        // Simpan pengguna ke database
        $query = "INSERT INTO users (username, email, password, verification_token) VALUES ('$username', '$email', '$password', '$token')";
        if (mysqli_query($koneksi, $query)) {
            // Kirim email verifikasi
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
                //Recipients
                $mail->setFrom('hasanthalib417@gmail.com', 'Aktivasi');
                $mail->addAddress($email);                                    // Add a recipient
            
                //Content
                $mail->isHTML(true);
$mail->Subject = 'Verifikasi Akun';

// Gunakan HTML untuk tampilan card
$mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Gaya umum untuk email */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .card {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .card-body p {
            font-size: 16px;
            color: #333333;
            margin-bottom: 20px;
        }
        .card-body a {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .card-body a:hover {
            background-color: #0056b3;
        }
        .card-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            padding: 10px;
            background-color: #f9f9f9;
            border-top: 1px solid #eeeeee;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            Verifikasi Akun Anda
        </div>
        <div class="card-body">
            <p>Terima kasih telah mendaftar di layanan kami. Klik tombol di bawah untuk memverifikasi akun Anda:</p>
            <a href="http://localhost/bukuwarung/verify.php?token=' . $token . '">Verifikasi Akun</a>
        </div>
        <div class="card-footer">
            Jika Anda tidak mendaftarkan akun ini, abaikan email ini.
        </div>
    </div>
</body>
</html>';

                
                $mail->send();
                echo "<script>alert('Email verifikasi telah dikirim.');</script>";
            } catch (Exception $e) {
                echo "<script>alert('Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}');</script>";
            }
            
        } else {
            echo "<script>alert('Gagal mendaftar: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100" style="background-color: #f0f0f0;">

    <div class="card">
        <h2 class="text-center mb-4">Registrasi</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Daftar</button>
            <p class="mt-3">Sudah punya akun? <a href="login.php">klik disini</a></p>
        </form>
    </div>

</body>
</html>
