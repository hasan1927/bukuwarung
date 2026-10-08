<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</head>
<div class="container mt-5">
    <h1 class="text-center">Edit Catatan Buku Warung</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php
            include 'koneksi.php';
            $id = $_GET['id'];
            $query = "SELECT * FROM buku_warung WHERE id=$id";
            $result = mysqli_query($koneksi, $query);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            ?>
            <form method="POST" action="proses_edit.php" class="mb-4">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang:</label>
                    <input type="text" class="form-control" name="nama_barang" value="<?php echo $row['nama_barang']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga:</label>
                    <input type="number" class="form-control" name="harga" value="<?php echo $row['harga']; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok:</label>
                    <input type="number" class="form-control" name="stok" value="<?php echo $row['stok']; ?>" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            <?php
            } else {
                echo "Data tidak ditemukan.";
            }
            ?>
            <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
