<?php
include("koneksi.php");
?>
<div class="container mt-4">
    <h3>Form Pasien</h3>
    <form method="POST" action="aksi_pasien.php">
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
    <h3 class="mt-5">Daftar Pasien</h3>
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
            $result = mysqli_query($mysqli, "SELECT * FROM pasien");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['nomor_hp'] ?></td>
                    <td>
                        <a class="btn btn-warning" href="index.php?page=pasien_edit&id=<?php
                                                                                        echo $data['id']; ?>">Edit</a>
                        <a class="btn btn-danger" href="aksi_pasien.php?action=delete&id=<?php echo $data['id'] ?>">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
periksa.php
<?php
include("koneksi.php");
// Mengambil data dokter dan pasien untuk dropdown
$dokters = mysqli_query($mysqli, "SELECT * FROM dokter");
$pasiens = mysqli_query($mysqli, "SELECT * FROM pasien");
if (!$dokters || !$pasiens) {
    die("Error fetching data: " . $mysqli->error);
}
?>
<div class="container mt-4">
    <h3>Form Periksa</h3>
    <form method="POST" action="aksi_periksa.php">
        <div class="mb-3">
            <label for="id_dokter" class="form-label">Dokter</label>
            <select class="form-control" id="id_dokter" name="id_dokter">
                <?php
                while ($dokter = mysqli_fetch_assoc($dokters)) {
                    echo "<option value='" . $dokter['id'] . "'>" . $dokter['nama'] .
                        "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_pasien" class="form-label">Pasien</label>
            <select class="form-control" id="id_pasien" name="id_pasien">
                <?php
                while ($pasien = mysqli_fetch_assoc($pasiens)) {
                    echo "<option value='" . $pasien['id'] . "'>" . $pasien['nama'] .
                        "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
            <input type="date" class="form-control" id="tanggal_periksa" name="tanggal_periksa">
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    <div class="container mt-5">
        <h3>Data Pemeriksaan</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Nama Dokter</th>
                    <th>Tanggal Periksa</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT pr.id, p.nama AS nama_pasien, d.nama AS nama_dokter, 
pr.tanggal_periksa, pr.catatan 
 FROM periksa pr 
JOIN pasien p ON pr.id_pasien = p.id 
 JOIN dokter d ON pr.id_dokter = d.id 
 ORDER BY pr.tanggal_periksa DESC";
                $result = mysqli_query($mysqli, $query);
                if (!$result) {
                    die("Error fetching examination data: " . $mysqli->error);
                }
                $no = 1;
                while ($data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $data['nama_pasien'] . "</td>";
                    echo "<td>" . $data['nama_dokter'] . "</td>";
                    echo "<td>" . $data['tanggal_periksa'] . "</td>";
                    echo "<td>" . $data['catatan'] . "</td>";
                    echo "<td>";
                    echo "<a href='index.php?page=periksa_edit&id=" . $data['id'] . "' 
class='btn btn-warning btn-sm'>Edit</a> ";
                    echo "<a href='aksi_periksa.php?action=delete&id=" . $data['id'] . "' 
class='btn btn-danger btn-sm'>Hapus</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>