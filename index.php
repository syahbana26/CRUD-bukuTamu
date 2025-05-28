<?php 

    //koneksikan ke database
  $conn = mysqli_connect("localhost", "root", "", "db_tamu");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>

   <div class="container mt-5">
    <h1 class="fw-bold text-center mb-4">📋 Data Tamu</h1>

    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Keperluan</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            $data = mysqli_query($conn, "SELECT * FROM tb_buku_tamu ORDER BY waktu_kunjungan DESC");
                            foreach ($data as $tamu): 
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($tamu['nama']); ?></td>
                            <td><?= htmlspecialchars($tamu['instansi']); ?></td>
                            <td><?= htmlspecialchars($tamu['keperluan']); ?></td>
                            <td><?= $tamu['waktu_kunjungan']; ?></td>
                            <td class="text-center">
                                <a href="?edit=<?= $tamu['id']; ?>" class="btn btn-sm btn-warning">
                                    ✏️ Ubah
                                </a>
                                <a href="?hapus=<?= $tamu['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    🗑️ Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <!-- end table -->

    <!-- start hapus data tamu -->
     <?php 
        if(isset($_GET['hapus'])){
            $id = $_GET['hapus'];
            $sql = mysqli_query($conn, "DELETE FROM tb_buku_tamu WHERE id='$id'");

        }
     ?>
    <!-- end hapus data tamu -->

    <!-- start tambah data tamu -->
     <?php 
            // ketika tombol Tambah di klik
            if(isset($_POST['tambah'])){
                $nama = $_POST['nama'];
                $instansi = $_POST['instansi'];
                $keperluan = $_POST['keperluan'];

                date_default_timezone_set('Asia/Jakarta');

                $waktu_kunjungan = date('Y-m-d H:i:s'); // hasil akan sesuai jam lokal (WIB)
        

                mysqli_query($conn, "INSERT INTO tb_buku_tamu(nama, instansi, keperluan, waktu_kunjungan) 
                VALUES ('$nama', '$instansi', '$keperluan', '$waktu_kunjungan')");
                
            }
         ?>
    <!-- end tambah data -->
    
    <!-- start form tambah data -->
   <div class="container mt-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h3 class="fw-bold mb-4">Tambah Data Tamu</h3>
        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="col-md-6">
                    <label for="instansi" class="form-label">Instansi</label>
                    <input type="text" class="form-control" id="instansi" name="instansi">
                </div>
            </div>
            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan</label>
                <textarea class="form-control" id="keperluan" name="keperluan" rows="3" required></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" name="tambah" class="btn btn-success px-4">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- end form tambah data -->

    <!-- start update data -->
        <?php 
        
        $nama = $instansi =$keperluan =$waktu_kunjungan = "";
        if(isset($_GET['edit'])){
            $id = $_GET['edit'];
            $sql = mysqli_query($conn, "SELECT * FROM tb_buku_tamu WHERE id='$id'");
            $hasil = mysqli_fetch_assoc($sql);

            $nama = $hasil['nama'];
            $instansi = $hasil['instansi'];
            $keperluan = $hasil['keperluan'];
            $waktu_kunjungan = $hasil['waktu_kunjungan'];
        }

        if(isset($_POST['ubah'])) {
            $nama = $_POST['nama'];
            $instansi = $_POST['instansi'];
            $keperluan = $_POST['keperluan'];
            $waktu_kunjungan = $_POST['waktu_kunjungan'];

            mysqli_query($conn, "UPDATE tb_buku_tamu SET nama='$nama',
            instansi='$instansi', keperluan='$keperluan', waktu_kunjungan='$waktu_kunjungan' WHERE id='$id'");
                
        }
        ?>

        <!-- start form ubah data -->
<div class="container-sm mt-5">
    <div class="card p-4 shadow rounded-4">
        <h2 class="fw-bold mb-4">Ubah Data Tamu</h2>
        <form action="" method="post">
          <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" id="nama" class="form-control" name="nama" required value="<?= $nama ?>">
            </div>
            <div class="mb-3">
                <label for="instansi" class="form-label">Instansi</label>
                <input type="text" id="instansi" class="form-control" name="instansi" value="<?= $instansi ?>">
            </div>
            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan</label>
                <input type="text" id="keperluan" class="form-control" name="keperluan" required value="<?= $keperluan ?>">
            </div>
            <div class="mb-3">
                <label for="waktu" class="form-label">Waktu Kunjungan</label>
                <input type="text" id="waktu" class="form-control" name="waktu_kunjungan" value="<?= $waktu_kunjungan ?>" readonly>
            </div>
            <div class="text-end">
                <button type="submit" name="ubah" class="btn btn-success">Ubah</button>
            </div>
        </form>
    </div>
</div>

        <!-- end form ubah data -->
    <!-- end update data -->

    
</body>
</html>