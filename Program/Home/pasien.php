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
    $ID_Pasien = !empty($_GET['id']) ? $_GET['id'] : " ";
    $kdb = koneksidatabase();
    $a = @$_GET["a"];
    $sql = @$_POST["sql"];
    switch ($sql) {
        case "insert":
            $start_time = microtime(true);
            sql_insert($kunci);
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            echo "Waktu Eksekusi Insert: " . number_format($execution_time, 6) . " detik";
            break;
        case "update":
            $start_time = microtime(true);
            sql_update($kunci);
            $end_time = microtime(true);
            $execution_time = $end_time - $start_time;
            echo "Waktu Eksekusi Update: " . number_format($execution_time, 6) . " detik";
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
            curd_update($ID_Pasien);
            break;
        case "hapus":
            curd_delete($ID_Pasien);
            break;
        default:
            curd_read($kunci);
            break;
    }
    mysqli_close($kdb);
    function curd_read()
    {
        global $kdb;
        if (isset($_POST["cari2"])) {
            $cari = $_POST["cari"];
            $query = "SELECT * from pasien where no_rekammedis LIKE ?";

            // Buat prepared statement
            $stmt = mysqli_prepare($kdb, $query);

            // Periksa apakah prepared statement berhasil dibuat
            if ($stmt) {
                // Binding parameter dan eksekusi prepared statement
                $param = "%" . $cari . "%";
                mysqli_stmt_bind_param($stmt, "s", $param);
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
            <H3> MASTER DATA PASIEN </H3>
            <br><br><br>
            <ul class="bagan">
                <li class="area_tmbhdta"><a href="pasien.php?a=tambah" class="btn btn-warning" id="tmbhdata" style="margin-left: 5px;">+ Tambah Data </a></li>
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
                        <td>No Rekam Medis</td>
                        <td>Nama Pasien</td>
                        <td>Tanggal Lahir</td>
                        <td>Umur</td>
                        <td>Alamat</td>
                        <td>No. Telp</td>
                        <td>No. Asuransi</td>
                        <td>Jenis/Informasi Asurasi</td>
                        <td>Aksi</td>

                    </tr>
                    <?php
                    require_once '../HillCipher/dekripsi.php';
                    while ($baris = mysqli_fetch_array($hasil)) {
                        $dekripnmpasien = DekripsiHillCipher($baris['nm_pasien'], $kunci);
                        $dekripnorekam = $baris['no_rekammedis'];
                        $dekriptlpasien = DekripsiHillCipher($baris['tl_pasien'], $kunci);
                        $dekripalamatpasien = DekripsiHillCipher($baris['Alamat_pasien'], $kunci);
                        $dekriptelppasien = DekripsiHillCipher($baris['telp_pasien'], $kunci);
                        $dekripnoasuransi = DekripsiHillCipher($baris['no_asuransi'], $kunci);
                        $dekripinformasiasuransi = DekripsiHillCipher($baris['Informasi_Asuransi'], $kunci);
                        $tanggal_lahir = new DateTime($dekriptlpasien);
                        $today = new DateTime();
                        $umur = $today->diff($tanggal_lahir)->y;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dekripnorekam; ?></td>
                            <td><?php echo $dekripnmpasien; ?></td>
                            <td><?php echo $dekriptlpasien; ?></td>
                            <td><?php echo $umur; ?> Tahun</td>
                            <td><?php echo $dekripalamatpasien; ?></td>
                            <td><?php echo $dekriptelppasien; ?></td>
                            <td><?php echo $dekripnoasuransi; ?></td>
                            <td><?php echo $dekripinformasiasuransi; ?></td>
                            <td>
                                <a href="pasien.php?a=edit&id=<?php echo $baris['ID_Pasien']; ?>" class="btn btn-success ">UPDATE</a>
                                <a href="pasien.php?a=hapus&id=<?php echo $baris['ID_Pasien']; ?>" class="btn btn-danger ">DELETE</a>
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
                    <td width="200px">No Rekam Medis</td>
                    <td><input type="text" name="no_rekammedis" id="no_rekammedis" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                    echo trim($row["no_rekammedis"]) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Nama Pasien</td>
                    <td><input type="text" name="nm_pasien" id="nm_pasien" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                            echo trim(DekripsiHillCipher($row["nm_pasien"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Tanggal Lahir</td>
                    <td><input type="Date" name="tl_pasien" id="tl_pasien" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                            echo trim(DekripsiHillCipher($row["tl_pasien"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Alamat</td>
                    <td><input type="text" name="Alamat_pasien" id="Alamat_pasien" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                    echo trim(DekripsiHillCipher($row["Alamat_pasien"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">No. Telp</td>
                    <td><input type="text" name="telp_pasien" id="telp_pasien" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                echo trim(DekripsiHillCipher($row["telp_pasien"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">No. Asuransi</td>
                    <td><input type="text" name="no_asuransi" id="no_asuransi" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                echo trim(DekripsiHillCipher($row["no_asuransi"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Jenis/Informasi Asuransi</td>
                    <td><input type="text" name="Informasi_Asuransi" id="Informasi_Asuransi" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                                echo trim(DekripsiHillCipher($row["Informasi_Asuransi"], $kunci)) ?>"></td>
                </tr>
            </table>
        </center>
    <?php  } ?>

    <?php
    function curd_create()
    {
    ?><center>
            <h3>Penambahan Data user</h3><br>
            <a href="pasien.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="pasien.php?a=reset" method="post">
                <input type="hidden" name="sql" value="insert">
                <?php
                $row = array(
                    "no_rekammedis" => "",
                    "nm_pasien" => "",
                    "tl_pasien" => "",
                    "Alamat_pasien" => "",
                    "telp_pasien" => "",
                    "no_asuransi" => "",
                    "Informasi_Asuransi" => ""
                );

                formeditor($row)
                ?>
                <p><input type="submit" name="action" id="smpandata" value="Simpan" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_update($ID_Pasien)
    {
        global $kdb;
        $hasil2 = sql_select_byid($ID_Pasien);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <center>
            <h3>Pengubahan Data user</h3><br>
            <a href="pasien.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="pasien.php?a=reset" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="ID_Pasien" value="<?php echo $ID_Pasien; ?>">
                <?php
                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_delete($ID_Pasien)
    {
        global $kdb;
        $hasil2 = sql_select_byid($ID_Pasien);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <h3>Penghapusan Data user</h3><br>
        <a href="pasien.php?a=reset" class="btn btn-danger ">Batal</a>
        <br>
        <form action="pasien.php?a=reset" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="ID_Pasien" value="<?php echo $ID_Pasien; ?>">
            <h3> Anda yakin akan menghapus data <?php require_once '../HillCipher/dekripsi.php';
                                                        echo DekripsiHillCipher($row['nm_pasien'], $kunci); ?> </h3>
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
        $sql = " select * from pasien ";
        $hasil = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil;
    }

    
    function sql_insert($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednorekam = $_POST['no_rekammedis'];
        $encryptednmpasien = enkripsiHillCipher($_POST['nm_pasien'], $kunci);
        $encryptedtlpasien = enkripsiHillCipher($_POST['tl_pasien'], $kunci);
        $encryptedalamatpasien = enkripsiHillCipher($_POST['Alamat_pasien'], $kunci);
        $encryptedtelppasien = enkripsiHillCipher($_POST['telp_pasien'], $kunci);
        $encryptednoasuransi = enkripsiHillCipher($_POST['no_asuransi'], $kunci);
        $encryptedinformasiasuransi = enkripsiHillCipher($_POST['Informasi_Asuransi'], $kunci);

        $sql = "INSERT INTO `pasien` (`no_rekammedis`,`nm_pasien`, `tl_pasien`,`Alamat_pasien`, `telp_pasien`,`no_asuransi`, `Informasi_Asuransi`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $encryptednorekam, $encryptednmpasien, $encryptedtlpasien, $encryptedalamatpasien, $encryptedtelppasien, $encryptednoasuransi, $encryptedinformasiasuransi);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_select_byid($ID_Pasien)
    {
        global $kdb;
        $sql = " select * from pasien where ID_Pasien= " . $ID_Pasien;
        $hasil2 = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil2;
    }
    function sql_update($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptednorekam = $_POST['no_rekammedis'];
        $encryptednmpasien = enkripsiHillCipher($_POST['nm_pasien'], $kunci);
        $encryptedtlpasien = enkripsiHillCipher($_POST['tl_pasien'], $kunci);
        $encryptedalamatpasien = enkripsiHillCipher($_POST['Alamat_pasien'], $kunci);
        $encryptedtelppasien = enkripsiHillCipher($_POST['telp_pasien'], $kunci);
        $encryptednoasuransi = enkripsiHillCipher($_POST['no_asuransi'], $kunci);
        $encryptedinformasiasuransi = enkripsiHillCipher($_POST['Informasi_Asuransi'], $kunci);
        $ID_Pasien = $_POST["ID_Pasien"];

        $sql  = "UPDATE `pasien` SET `no_rekammedis` = ?, `nm_pasien` = ?, `tl_pasien` = ?, `Alamat_pasien` = ?, `telp_pasien` = ?, `no_asuransi` = ?, `Informasi_Asuransi` = ? WHERE `ID_Pasien` = ?";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $encryptednorekam, $encryptednmpasien, $encryptedtlpasien, $encryptedalamatpasien, $encryptedtelppasien, $encryptednoasuransi, $encryptedinformasiasuransi, $ID_Pasien);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_delete()
    {
        global $kdb;
        global $_POST;
        $sql  = " delete from `pasien` where ID_Pasien= " . $_POST["ID_Pasien"];
        mysqli_query($kdb, $sql) or die(mysql_error());
    }

    ?>


    <?php
    include '../layout/F1.php';
    ?>