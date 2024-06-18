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
    $ID_Staf = !empty($_GET['id']) ? $_GET['id'] : " ";
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
            curd_update($ID_Staf);
            break;
        case "hapus":
            curd_delete($ID_Staf);
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
            $query = "SELECT * from staf_klinik where nm_staf LIKE ? 
                      or Jabatan LIKE ? 
                      or telp_staf LIKE ?";
            
            // Buat prepared statement
            $stmt = mysqli_prepare($kdb, $query);
            
            // Periksa apakah prepared statement berhasil dibuat
            if ($stmt) {
                // Binding parameter dan eksekusi prepared statement
                $param = "%" . $cari . "%";
                mysqli_stmt_bind_param($stmt, "sss", $param, $param, $param);
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
            <H3> MASTER DATA STAF</H3>
            <br><br><br>
            <ul class="bagan">
                <li class="area_tmbhdta"><a href="staf.php?a=tambah" class="btn btn-warning" style="margin-left: 5px;">+ Tambah Data </a></li>
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
                        <td>Nama Staf</td>
                        <td>Tanggal Lahir</td>
                        <td>Umur</td>
                        <td>Jabatan</td>
                        <td>No. Telp</td>
                        <td>Aksi</td>

                    </tr>
                    <?php
                    require_once '../HillCipher/dekripsi.php';
                    while ($baris = mysqli_fetch_array($hasil)) {
                        $dekripnmstaf = DekripsiHillCipher($baris['nm_staf'], $kunci);
                        $dekriptlstaf = DekripsiHillCipher($baris['tl_staf'], $kunci);
                        $dekripjabatan = DekripsiHillCipher($baris['Jabatan'], $kunci);
                        $dekriptelpstaf = DekripsiHillCipher($baris['telp_staf'], $kunci);
                        $tanggal_lahir = new DateTime($dekriptlstaf);
                        $today = new DateTime();
                        $umur = $today->diff($tanggal_lahir)->y;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dekripnmstaf; ?></td>
                            <td><?php echo $dekriptlstaf; ?></td>
                            <td><?php echo $umur; ?> Tahun</td>
                            <td><?php echo $dekripjabatan; ?></td>
                            <td><?php echo $dekriptelpstaf; ?></td>
                            <td>
                                <a href="staf.php?a=edit&id=<?php echo $baris['ID_Staf']; ?>" class="btn btn-success ">UPDATE</a>
                                <a href="staf.php?a=hapus&id=<?php echo $baris['ID_Staf']; ?>" class="btn btn-danger ">DELETE</a>
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
                    <td width="200px">Nama STAF</td>
                    <td><input type="text" name="nm_staf" id="nm_staf" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                        echo trim(DekripsiHillCipher($row["nm_staf"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Tanggal Lahir</td>
                    <td><input type="Date" name="tl_staf" id="tl_staf" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                        echo trim(DekripsiHillCipher($row["tl_staf"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">JABATAN</td>
                    <td><select name="Jabatan">
                            <option value="PERAWAT">PERAWAT</option>
                            <option value="DOKTER">DOKTER</option>
                            <option value="OPERATOR">OPERATOR</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="200px">No. Telp</td>
                    <td><input type="text" name="telp_staf" id="telp_staf" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                            echo trim(DekripsiHillCipher($row["telp_staf"], $kunci)) ?>"></td>
                </tr>
            </table>
        </center>
    <?php  } ?>

    <?php
    function curd_create()
    {
    ?><center>
            <h3>Penambahan Data Staf</h3><br>
            <a href="staf.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="staf.php?a=reset" method="post">
                <input type="hidden" name="sql" value="insert">
                <?php
                $row = array(
                    "nm_staf" => "",
                    "tl_staf" => "",
                    "Jabatan" => "",
                    "telp_staf" => ""
                );

                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Simpan" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_update($ID_Staf)
    {
        global $kdb;
        $hasil2 = sql_select_byid($ID_Staf);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <center>
            <h3>Pengubahan Data STAF</h3><br>
            <a href="staf.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="staf.php?a=reset" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="ID_Staf" value="<?php echo $ID_Staf; ?>">
                <?php
                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_delete($ID_Staf)
    {
        global $kdb;
        $hasil2 = sql_select_byid($ID_Staf);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <h3>Penghapusan Data STAF</h3><br>
        <a href="staf.php?a=reset" class="btn btn-danger ">Batal</a>
        <br>
        <form action="staf.php?a=reset" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="ID_Staf" value="<?php echo $ID_Staf; ?>">
            <h3> Anda yakin akan menghapus data <?php require_once '../HillCipher/dekripsi.php';
                                                        echo DekripsiHillCipher($row['nm_staf'], $kunci); ?> </h3>
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
        $sql = " select * from staf_klinik ";
        $hasil = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil;
    }
    function sql_insert($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednmstaf = enkripsiHillCipher($_POST['nm_staf'], $kunci);
        $encryptedtlstaf = enkripsiHillCipher($_POST['tl_staf'], $kunci);
        $encryptedjabatan = enkripsiHillCipher($_POST['Jabatan'], $kunci);
        $encryptedtelpstaf = enkripsiHillCipher($_POST['telp_staf'], $kunci);

        $sql = "INSERT INTO `staf_klinik` (`nm_staf`, `tl_staf`,`Jabatan`, `telp_staf`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $encryptednmstaf, $encryptedtlstaf, $encryptedjabatan, $encryptedtelpstaf);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_select_byid($ID_Staf)
    {
        global $kdb;
        $sql = " select * from staf_klinik where ID_Staf= " . $ID_Staf;
        $hasil2 = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil2;
    }
    function sql_update($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednmstaf = enkripsiHillCipher($_POST['nm_staf'], $kunci);
        $encryptedtlstaf = enkripsiHillCipher($_POST['tl_staf'], $kunci);
        $encryptedjabatan = enkripsiHillCipher($_POST['Jabatan'], $kunci);
        $encryptedtelpstaf = enkripsiHillCipher($_POST['telp_staf'], $kunci);
        $ID_Staf = $_POST["ID_Staf"];

        $sql  = "UPDATE `staf_klinik` SET `nm_staf` = ?, `tl_staf` = ?, `Jabatan` = ?, `telp_staf` = ? WHERE `ID_Staf` = ?";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi",  $encryptednmstaf, $encryptedtlstaf, $encryptedjabatan, $encryptedtelpstaf, $ID_Staf);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_delete()
    {
        global $kdb;
        global $_POST;
        $sql  = " delete from `staf_klinik` where ID_Staf= " . $_POST["ID_Staf"];
        mysqli_query($kdb, $sql) or die(mysql_error());
    }

    ?>


    <?php
    include '../layout/F1.php';
    ?>