<?php
include '../layout/header.php';
require '../HillCipher/enkripsi.php';

session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: ../index.php");
    exit;
}
?>
<html>

<head>
</head>

<body>

    <?php
    $a = !empty($_GET['a']) ? $_GET['a'] : "reset";
    $id_obat = !empty($_GET['id']) ? $_GET['id'] : " ";
    $kdb = koneksidatabase();
    $a = @$_GET["a"];
    $sql = @$_POST["sql"];
    switch ($sql) {
        case "insert":
            sql_insert($kunci);
            break;
        case "update":
            sql_update($kunci);
            break;
        case "delete":
            sql_delete();
            break;
    }
    switch ($a) {
        case "reset":
            curd_read($kunci);
            break;
        case "tambah":
            curd_create();
            break;
        case "edit":
            curd_update($id_obat);
            break;
        case "hapus":
            curd_delete($id_obat);
            break;
        default:
            curd_read($kunci);
            break;
    }
    mysqli_close($kdb);
    function curd_read($kunci)
    {
        global $kdb;
        if (isset($_POST["cari2"])) {
            $cari = enkripsiHillCipher($_POST["cari"], $kunci);
            $cariNonEnkripsi = "%" . $_POST["cari"] . "%";
            $query = "SELECT * from obat where Nama_Obat LIKE ? 
                      or Jenis_Obat LIKE ?";

            // Buat prepared statement
            $stmt = mysqli_prepare($kdb, $query);

            // Periksa apakah prepared statement berhasil dibuat
            if ($stmt) {
                // Binding parameter dan eksekusi prepared statement
                $param = "%" . $cari . "%";
                mysqli_stmt_bind_param($stmt, "ss", $param, $cariNonEnkripsi);
                mysqli_stmt_execute($stmt);

                // Mengambil hasil
                $hasil = mysqli_stmt_get_result($stmt);
            } else {
                // Penanganan kesalahan jika prepared statement gagal
                die(mysqli_error($kdb));
            }
        } else {
            $hasil = sql_select();
        }
        $i = 1;
    ?>
        <center>
            <H3> MASTER DATA OBAT </H3>
            <br><br><br>
            <ul class="bagan">
                <li class="area_tmbhdta"><a href="obat.php?a=tambah" class="btn btn-warning" style="margin-left: 5px;">+ Tambah Data </a></li>
                <li class="area_cari">
                    <form class="d-flex " role="search" action="" method="post">
                        <input class="form-control me-2" type="text" name="cari" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-info" type="submit" name="cari2" value="cari">Search</button>
                    </form>
                </li>
            </ul>
        </center>
        <center>
            <form action="" method="post">
                <table class="table table-bordered">
                    <tr>
                        <td>No</td>
                        <td>Nama Obat</td>
                        <td>Jenis Obat</td>
                        <td>HARGA</td>
                        <td>STOK</td>
                        <td>Aksi</td>

                    </tr>
                    <?php
                    require_once '../HillCipher/dekripsi.php';
                    while ($baris = mysqli_fetch_array($hasil)) {
                        $dekripnmobat = DekripsiHillCipher($baris['Nama_Obat'], $kunci);
                        
                        
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dekripnmobat; ?></td>
                            <td><?php echo $baris['Jenis_Obat']; ?></td>
                            <td><?php echo $baris['Harga']; ?></td>
                            <td><?php echo $baris['Stok']; ?></td>
                            <td>
                                <a href="obat.php?a=edit&id=<?php echo $baris['id_obat']; ?>" class="btn btn-success ">UPDATE</a>
                                <a href="obat.php?a=hapus&id=<?php echo $baris['id_obat']; ?>" class="btn btn-danger ">DELETE</a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    }
                    ?>
                </table>
        </center>
    <?php
        mysqli_free_result($hasil);
    }
    ?>

    <?php
    function formeditor($row)
    {
    ?>
        <center>
            <table>
                <tr>
                    <td width="200px">NAMA OBAT</td>
                    <td><input type="text" name="Nama_Obat" id="Nama_Obat" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                            echo trim(DekripsiHillCipher($row["Nama_Obat"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">JENIS OBAT</td>
                    <td><input type="text" name="Jenis_Obat" id="Jenis_Obat" maxlength="25" size="25" value="<?php echo trim($row["Jenis_Obat"]) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">HARGA</td>
                    <td><input type="number" name="Harga" id="Harga" maxlength="25" size="25" value="<?php echo trim($row["Harga"]) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">STOK</td>
                    <td><input type="number" name="Stok" id="Stok" maxlength="25" size="25" value="<?php echo trim($row["Stok"]) ?>"></td>
                </tr>
            </table>
        </center>
    <?php  } ?>

    <?php
    function curd_create()
    {
    ?><center>
            <h3>Penambahan Data OBAT</h3><br>
            <a href="obat.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="obat.php?a=reset" method="post">
                <input type="hidden" name="sql" value="insert">
                <?php
                $row = array(
                    "Jenis_Obat" => "",
                    "Nama_Obat" => "",
                    "Harga" => "",
                    "Stok" => ""
                );

                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Simpan" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_update($id_obat)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_obat);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <center>
            <h3>Pengubahan Data OBAT</h3><br>
            <a href="obat.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="obat.php?a=reset" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="id_obat" value="<?php echo $id_obat; ?>">
                <?php
                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_delete($id_obat)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_obat);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <h3>Penghapusan Data OBAT</h3><br>
        <a href="obat.php?a=reset" class="btn btn-danger ">Batal</a>
        <br>
        <form action="obat.php?a=reset" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="id_obat" value="<?php echo $id_obat; ?>">
            <h3> Anda yakin akan menghapus data  <?php require_once '../HillCipher/dekripsi.php';
                                                        echo DekripsiHillCipher($row['Nama_Obat'], $kunci); ?> </h3>
            <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
        </form>
    <?php } ?>
    <?php
    function koneksidatabase()
    {
        include('../koneksi/koneksi.php');
        return $kdb;
    }
    function sql_select()
    {
        global $kdb;
        $sql = " select * from obat ";
        $hasil = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil;
    }
    function sql_insert($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednmobat = enkripsiHillCipher($_POST['Nama_Obat'], $kunci);
        $sql = "INSERT INTO `obat` (`Nama_Obat`, `Jenis_Obat`, `Harga`,`Stok`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $encryptednmobat, $_POST['Jenis_Obat'], $_POST['Harga'], $_POST['Stok']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_select_byid($id_obat)
    {
        global $kdb;
        $sql = " select * from obat where id_obat= " . $id_obat;
        $hasil2 = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil2;
    }
    function sql_update($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednmobat = enkripsiHillCipher($_POST['Nama_Obat'], $kunci);
        $id_obat = $_POST["id_obat"];

        $sql  = "UPDATE `obat` SET `Nama_Obat` = ?, `Jenis_Obat` = ?, `Harga` = ?, `Stok` = ? WHERE `id_obat` = ?";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $encryptednmobat, $_POST['Jenis_Obat'], $_POST['Harga'], $_POST['Stok'], $id_obat);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_delete()
    {
        global $kdb;
        global $_POST;
        $sql  = " delete from `obat` where id_obat= " . $_POST["id_obat"];
        mysqli_query($kdb, $sql) or die(mysql_error());
    }

    ?>


    <?php
    include '../layout/F1.php';
    ?>