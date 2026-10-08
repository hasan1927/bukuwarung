<?php
include 'koneksi.php';

// Inisialisasi variabel pencarian dan filter
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Query SQL untuk mengambil data berdasarkan kriteria pencarian dan filter
$query = "SELECT * FROM buku_warung";

if (!empty($keyword)) {
    $query .= " WHERE nama_barang LIKE '%$keyword%'";
    
    if (!empty($filter)) {
        if ($filter == 'harga') {
            $query .= " ORDER BY harga";
        } elseif ($filter == 'stok') {
            $query .= " ORDER BY stok";
        }
    }
}

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Buku Warung</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
       .help-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.help-button a {
    text-decoration: none;
}

.help-button i {
    font-size: 40px; /* Sesuaikan ukuran ikon sesuai keinginan Anda */
    color: #25d366; /* Warna WhatsApp */
}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Buku Warung</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tambah.php">Tambah Catatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Catatan Buku Warung</h1>
        <a href="tambah.php" class="btn btn-primary mb-3">Tambah Catatan</a>
        <form method="GET" action="index.php" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari Nama Barang" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="filter">
                        <option value="">Semua</option>
                        <option value="harga" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'harga') ? 'selected' : ''; ?>>Harga</option>
                        <option value="stok" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'stok') ? 'selected' : ''; ?>>Stok</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['nama_barang']."</td>";
                    echo "<td>".$row['harga']."</td>";
                    echo "<td>".$row['stok']."</td>";
                    echo "<td><a href='edit.php?id=".$row['id']."' class='btn btn-warning btn-sm'>Edit</a> | <a href='hapus.php?id=".$row['id']."' class='btn btn-danger btn-sm'>Hapus</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="help-button">
    <a href="https://wa.me/1234567890" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>



    <footer class="mt-5">
        <div class="container text-center">
            <p>&copy; <?php echo date("Y"); ?> Buku Warung</p>
        </div>
    </footer>

</body>
</html>
