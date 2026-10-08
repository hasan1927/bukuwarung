<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Buku Warung</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                </ul>
            </div>
        </div>
    </nav>
<!-- Tambah Catatan Buku Warung -->
<div class="container mt-5">
    <h1 class="text-center">Tambah Catatan Buku Warung</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="proses_tambah.php" class="mb-4">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                    <input type="text" class="form-control" name="nama_barang" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga:</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok:</label>
                    <input type="number" class="form-control" name="stok" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
            <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
</body>
