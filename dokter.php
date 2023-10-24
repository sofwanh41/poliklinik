<?php
include("koneksi.php");
?>
<div class="container mt-5 mb-5">
    <h3>Form Dokter</h3>
    <form method="POST" action="aksi_dokter.php">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat">
        </div>
        <div class="mb-3">
            <label for="nomor_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <h3 class="mt-5">Daftar Dokter</h3>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($mysqli, "SELECT * FROM dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['nomor_hp'] ?></td>
                    <td>
                        <a class="btn btn-warning" href="index.php?page=dokter_edit&id=<?php
                                                                                        echo $data['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="aksi_dokter.php?action=delete&id=<?php echo $data['id'] ?>">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>