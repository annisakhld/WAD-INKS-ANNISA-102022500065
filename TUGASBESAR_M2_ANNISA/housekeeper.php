<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $id               = $_POST['id_housekeeper'];
    $nama_staff       = $_POST['nama_staff'];
    $tugas_kebersihan = $_POST['tugas_kebersihan'];
    $area_penanganan  = $_POST['area_penanganan'];
    $no_hp            = $_POST['no_hp'];

    if ($id == "") {
        $query = "INSERT INTO housekeeper (nama_staff, tugas_kebersihan, area_penanganan, no_hp) 
                  VALUES ('$nama_staff', '$tugas_kebersihan', '$area_penanganan', '$no_hp')";
    } else {
        $query = "UPDATE housekeeper SET 
                  nama_staff='$nama_staff', tugas_kebersihan='$tugas_kebersihan', 
                  area_penanganan='$area_penanganan', no_hp='$no_hp' WHERE id_housekeeper='$id'";
    }
    mysqli_query($koneksi, $query);
    header("Location: housekeeper.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM housekeeper WHERE id_housekeeper='$id'");
    header("Location: housekeeper.php");
}

$edit_data = ['id_housekeeper' => '', 'nama_staff' => '', 'tugas_kebersihan' => '', 'area_penanganan' => '', 'no_hp' => ''];
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($koneksi, "SELECT * FROM housekeeper WHERE id_housekeeper='$id'");
    $edit_data = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modul Housekeeper - Sistem Manajemen Kos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Sidebar Navigasi Terintegrasi -->
    <div class="sidebar">
        <div class="brand">🏢 Manajemen Kos</div>
        <ul class="sidebar-menu">
            <li><a href="index.php">📊 Dashboard</a></li>
            <li><a href="kamar.php">🖈 Modul Kamar</a></li>
            <li><a href="penghuni.php">👥 Modul Penghuni</a></li>
            <li><a href="housekeeper.php" class="active">🧹 Modul Housekeeper</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Header Atas -->
        <div class="top-header">
            <div>
                <h1>Modul Housekeeper / Staff</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Kelola penjaga kos, tugas kebersihan, dan area penanganan.</p>
            </div>
            <div class="user-profile">
                <div class="user-avatar">A</div>
                <span style="font-size: 0.875rem; font-weight: 600;">Annisa / Admin</span>
            </div>
        </div>

        <!-- Form Input / Edit Data -->
        <form method="POST" action="">
            <input type="hidden" name="id_housekeeper" value="<?= $edit_data['id_housekeeper']; ?>">
            
            <label>Nama Staff:</label>
            <input type="text" name="nama_staff" value="<?= $edit_data['nama_staff']; ?>" required placeholder="Contoh: Agus Sutrisno">

            <label>Tugas Kebersihan:</label>
            <input type="text" name="tugas_kebersihan" value="<?= $edit_data['tugas_kebersihan']; ?>" placeholder="Contoh: Sapu/Ngepel, Service AC, Sampah" required>

            <label>Area Penanganan:</label>
            <input type="text" name="area_penanganan" value="<?= $edit_data['area_penanganan']; ?>" placeholder="Contoh: Lantai 1 & Parkiran" required>

            <label>Nomor HP:</label>
            <input type="text" name="no_hp" value="<?= $edit_data['no_hp']; ?>" required placeholder="Contoh: 085712345678">

            <button type="submit" name="simpan">Simpan Data Staff</button>
        </form>

        <!-- Tabel Data -->
        <h3 style="margin-bottom: 16px;">Daftar Staff Housekeeper</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Staff</th>
                    <th>Tugas Kebersihan</th>
                    <th>Area Penanganan</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $data = mysqli_query($koneksi, "SELECT * FROM housekeeper ORDER BY id_housekeeper DESC");
                while ($row = mysqli_fetch_assoc($data)) {
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><b><?= $row['nama_staff']; ?></b></td>
                    <td><?= $row['tugas_kebersihan']; ?></td>
                    <td><?= $row['area_penanganan']; ?></td>
                    <td><?= $row['no_hp']; ?></td>
                    <td>
                        <a href="housekeeper.php?edit=<?= $row['id_housekeeper']; ?>">Edit</a> | 
                        <a href="housekeeper.php?hapus=<?= $row['id_housekeeper']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

</body>
</html>