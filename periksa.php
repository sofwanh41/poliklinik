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
Periksa_edit.php
<?php
include("koneksi.php");
// Inisialisasi variabel
$id = $id_dokter = $id_pasien = $tanggal_periksa = $catatan = '';
// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id_dokter = $_POST['id_dokter'];
    $id_pasien = $_POST['id_pasien'];
    $tanggal_periksa = $_POST['tanggal_periksa'];
    $catatan = $_POST['catatan'];
    $query = "UPDATE periksa SET id_dokter='$id_dokter', id_pasien='$id_pasien', 
tanggal_periksa='$tanggal_periksa', catatan='$catatan' WHERE id='$id'";
    if ($mysqli->query($query)) {
        header("Location: index.php?page=periksa");
    } else {
        die("Error: " . $query . "<br>" . $mysqli->error);
    }
}
// Cek apakah ada parameter ID di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Mengambil data pemeriksaan berdasarkan ID
    $query = "SELECT * FROM periksa WHERE id='$id'";
    $result = mysqli_query($mysqli, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $id_dokter = $data['id_dokter'];
        $id_pasien = $data['id_pasien'];
        $tanggal_periksa = $data['tanggal_periksa'];
        $catatan = $data['catatan'];
    } else {
        die("Data pemeriksaan tidak ditemukan.");
    }
}
// Ambil data dokter dan pasien untuk dropdown
$dokters = mysqli_query($mysqli, "SELECT * FROM dokter");
$pasiens = mysqli_query($mysqli, "SELECT * FROM pasien");
?>
<div class="container mt-4">
    <h3>Edit Pemeriksaan</h3>
    <form method="POST" action="periksa_edit.php">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <div class="mb-3">
            <label for="id_dokter" class="form-label">Dokter</label>
            <select class="form-control" id="id_dokter" name="id_dokter">
                <?php
                while ($dokter = mysqli_fetch_assoc($dokters)) {
                    $selected = ($dokter['id'] == $id_dokter) ? "selected" : "";
                    echo "<option value='" . $dokter['id'] . "' $selected>" .
                        $dokter['nama'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_pasien" class="form-label">Pasien</label>
            <select class="form-control" id="id_pasien" name="id_pasien">
                <?php
                while ($pasien = mysqli_fetch_assoc($pasiens)) {
                    $selected = ($pasien['id'] == $id_pasien) ? "selected" : "";
                    echo "<option value='" . $pasien['id'] . "' $selected>" .
                        $pasien['nama'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_periksa" class="form-label">Tanggal Periksa</label>
            <input type="date" class="form-control" id="tanggal_periksa" name="tanggal_periksa" value="<?= $tanggal_periksa; ?>">
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3"><?=
                                                                                $catatan; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>