<?php
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Koneksi ke database
    $koneksi = mysqli_connect("localhost", "root", "", "portaldb");

    // Verifikasi token di database
    $query = "SELECT * FROM users WHERE verification_token='$token'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        // Token valid, update status verifikasi
        $query = "UPDATE users SET is_verified=1, verification_token=NULL WHERE verification_token='$token'";
        if (mysqli_query($koneksi, $query)) {
            // Tampilkan alert sukses dan redirect
            echo '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Verifikasi Akun</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <script>
                    // Redirect setelah 3 detik ke login
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 3000);
                </script>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .container {
                        max-width: 500px;
                        width: 90%;
                        padding: 20px;
                        background-color: white;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                        text-align: center;
                    }
                    .alert {
                        padding: 15px;
                        background-color: #4caf50;
                        color: white;
                        border-radius: 5px;
                        font-size: 16px;
                        margin-bottom: 15px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="alert">
                        Akun Anda telah berhasil diverifikasi. Anda akan diarahkan ke halaman login dalam 3 detik.
                    </div>
                </div>
            </body>
            </html>';
        } else {
            echo '
            <script>
                alert("Gagal memverifikasi akun.");
                window.history.back();
            </script>';
        }
    } else {
        // Token tidak valid atau sudah digunakan
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Token Tidak Valid</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script>
                // Redirect setelah 3 detik ke halaman registrasi
                setTimeout(function() {
                    window.location.href = "register.php";
                }, 3000);
            </script>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .container {
                    max-width: 500px;
                    width: 90%;
                    padding: 20px;
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    text-align: center;
                }
                .alert {
                    padding: 15px;
                    background-color: #ff5722;
                    color: white;
                    border-radius: 5px;
                    font-size: 16px;
                    margin-bottom: 15px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="alert">
                    Token tidak valid atau sudah digunakan.
                </div>
                <p>Anda akan diarahkan ke halaman registrasi dalam 3 detik.</p>
            </div>
        </body>
        </html>';
    }
} else {
    // Token tidak ditemukan
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Token Tidak Ditemukan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            // Redirect setelah 3 detik ke halaman registrasi
            setTimeout(function() {
                window.location.href = "register.php";
            }, 3000);
        </script>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
            .container {
                max-width: 500px;
                width: 90%;
                padding: 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                text-align: center;
            }
            .alert {
                padding: 15px;
                background-color: #f44336;
                color: white;
                border-radius: 5px;
                font-size: 16px;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="alert">
                Token tidak ditemukan.
            </div>
            <p>Anda akan diarahkan ke halaman registrasi dalam 3 detik.</p>
        </div>
    </body>
    </html>';
}
?>
