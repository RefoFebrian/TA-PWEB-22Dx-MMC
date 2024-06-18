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
    $id_riwayatmedis = !empty($_GET['id']) ? $_GET['id'] : " ";
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
            curd_update($id_riwayatmedis);
            break;
        case "hapus":
            curd_delete($id_riwayatmedis);
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
            $query = "SELECT * from riwayat_medis where nm_pasien LIKE ? 
                      or nm_staf LIKE ? 
                      or Tanggal_Pemeriksaan LIKE ?";
            
            // Buat prepared statement
            $stmt = mysqli_prepare($kdb, $query);
            
            // Periksa apakah prepared statement berhasil dibuat
            if ($stmt) {
                // Binding parameter dan eksekusi prepared statement
                $param = "%" . $cari . "%";
                mysqli_stmt_bind_param($stmt, "ssss", $param, $param, $param, $param);
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
            <H3> MASTER DATA RIWAYAT MEDIS </H3>
            <br><br><br>
            <ul class="bagan">
                <li class="area_tmbhdta"><a href="rekammedis.php?a=tambah" class="btn btn-warning" style="margin-left: 5px;">+ Tambah Data </a></li>
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
                        <td>Nama Staf</td>
                        <td>Tanggal Pemeriksaan</td>
                        <td>DIAGNOSIS</td>
                        <td>Hasil Pemeriksaan</td>
                        <td>Rekomendasi Perawatan</td>
                        <td>Catatan Tambahan</td>
                        <td>Aksi</td>

                    </tr>
                    <?php
                    require_once '../HillCipher/dekripsi.php';
                    while ($baris = mysqli_fetch_array($hasil)) {
                        $dekripnorekam = $baris['no_rekammedis'];;
                        $dekripnmpasien = DekripsiHillCipher($baris['nm_pasien'], $kunci);
                        $dekripnmstaf = DekripsiHillCipher($baris['nm_staf'], $kunci);
                        $dekriptanggalperiksa = DekripsiHillCipher($baris['Tanggal_Pemeriksaan'], $kunci);
                        $dekripdiagnosa = DekripsiHillCipher($baris['Diagnosis'], $kunci);
                        $dekriphasilperiksa = DekripsiHillCipher($baris['Hasil_Pemeriksaan'], $kunci);
                        $dekripanjuranperawatan = DekripsiHillCipher($baris['Perawatan_Yang_Direkomendasikan'], $kunci);
                        $dekripcatatan = DekripsiHillCipher($baris['Catatan_Tambahan'], $kunci);
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dekripnorekam; ?></td>
                            <td><?php echo $dekripnmpasien; ?></td>
                            <td><?php echo $dekripnmstaf; ?></td>
                            <td><?php echo $dekriptanggalperiksa; ?></td>
                            <td><?php echo $dekripdiagnosa; ?></td>
                            <td><?php echo $dekriphasilperiksa; ?></td>
                            <td><?php echo $dekripanjuranperawatan; ?></td>
                            <td><?php echo $dekripcatatan; ?></td>
                            <td>
                                <a href="rekammedis.php?a=edit&id=<?php echo $baris['id_riwayatmedis']; ?>" class="btn btn-success ">UPDATE</a>
                                <a href="rekammedis.php?a=hapus&id=<?php echo $baris['id_riwayatmedis']; ?>" class="btn btn-danger ">DELETE</a>
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
                    <td>Nama Pasien</td>
                    <td>
                        <select name="ID_Pasien" id="ID_Pasien">
                            <?php
                            require_once '../HillCipher/dekripsi.php';
                            $kdb = koneksidatabase();
                            $sqlquery   = "select `ID_Pasien`, `nm_pasien` from pasien ORDER BY `ID_Pasien` DESC ";
                            $hasilquery = mysqli_query($kdb, $sqlquery) or die(mysql_error());
                            while ($baris = mysqli_fetch_assoc($hasilquery)) {
                                $value = $baris["ID_Pasien"];
                                $caption = DekripsiHillCipher($baris["nm_pasien"], $kunci);
                                if ($row["ID_Pasien"] == $baris["ID_Pasien"]) {
                                    $selstr = "selected";
                                } else {
                                    $selstr = "";
                                }
                            ?>
                                <option value="<?php echo $value ?>" <?php echo $selstr ?>>
                                    &nbsp; <?php echo $caption; ?> &nbsp;
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Nama STAF</td>
                    <td>
                        <select name="ID_Staf" id="ID_Staf">
                            <?php
                            require_once '../HillCipher/dekripsi.php';
                            $kdb = koneksidatabase();
                            $sqlquery   = "select `ID_Staf`, `nm_staf` from staf_klinik ORDER BY `ID_Staf` DESC ";
                            $hasilquery = mysqli_query($kdb, $sqlquery) or die(mysql_error());
                            while ($baris = mysqli_fetch_assoc($hasilquery)) {
                                $value = $baris["ID_Staf"];
                                $caption = DekripsiHillCipher($baris["nm_staf"], $kunci);
                                if ($row["ID_Staf"] == $baris["ID_Staf"]) {
                                    $selstr = "selected";
                                } else {
                                    $selstr = "";
                                }
                            ?>
                                <option value="<?php echo $value ?>" <?php echo $selstr ?>>
                                    &nbsp; <?php echo $caption; ?> &nbsp;
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="200px">Tanggal Pemeriksaan</td>
                    <td><input type="Date" name="Tanggal_Pemeriksaan" id="Tanggal_Pemeriksaan" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                                echo trim(DekripsiHillCipher($row["Tanggal_Pemeriksaan"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Diagnosis</td>
                    <td><input type="text" name="Diagnosis" id="Diagnosis" maxlength="1000" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                echo trim(DekripsiHillCipher($row["Diagnosis"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Hasil Pemeriksaan</td>
                    <td><input type="text" name="Hasil_Pemeriksaan" id="Hasil_Pemeriksaan" maxlength="1000" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                                echo trim(DekripsiHillCipher($row["Hasil_Pemeriksaan"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">Rekomendasi Perawatan</td>
                    <td><input type="text" name="Perawatan_Yang_Direkomendasikan" id="Perawatan_Yang_Direkomendasikan" maxlength="1000" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                                                            echo trim(DekripsiHillCipher($row["Perawatan_Yang_Direkomendasikan"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">CATATAN TAMBAHAN</td>
                    <td><input type="text" name="Catatan_Tambahan" id="Catatan_Tambahan" maxlength="1000" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                                            echo trim(DekripsiHillCipher($row["Catatan_Tambahan"], $kunci)) ?>"></td>
                </tr>
            </table>
        </center>
    <?php  } ?>

    <?php
    function curd_create()
    {
    ?><center>
            <h3>Penambahan Data Riwayat Medis</h3><br>
            <a href="rekammedis.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="rekammedis.php?a=reset" method="post">
                <input type="hidden" name="sql" value="insert">
                <?php
                $row = array(
                    "ID_Pasien" => "",
                    "ID_Staf" => "",
                    "Tanggal_Pemeriksaan" => "",
                    "Diagnosis" => "",
                    "Hasil_Pemeriksaan" => "",
                    "Perawatan_Yang_Direkomendasikan" => "",
                    "Catatan_Tambahan" => ""
                );

                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Simpan" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_update($id_riwayatmedis)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_riwayatmedis);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <center>
            <h3>Pengubahan Data Riwayat Medis</h3><br>
            <a href="rekammedis.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="rekammedis.php?a=reset" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="id_riwayatmedis" value="<?php echo $id_riwayatmedis; ?>">
                <?php
                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_delete($id_riwayatmedis)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_riwayatmedis);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <h3>Penghapusan Data Riwayat Medis</h3><br>
        <a href="rekammedis.php?a=reset" class="btn btn-danger ">Batal</a>
        <br>
        <form action="rekammedis.php?a=reset" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="id_riwayatmedis" value="<?php echo $id_riwayatmedis; ?>">
            <h3> Anda yakin akan menghapus data? </h3>
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
        $sql = " select * from riwayat_medis join pasien on riwayat_medis.ID_Pasien=pasien.ID_Pasien join staf_klinik on riwayat_medis.ID_Staf=staf_klinik.ID_Staf";
        $hasil = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil;
    }
    function sql_insert($kunci)
    {
        global $kdb;
        global $_POST;
        $enkriptanggalperiksa = enkripsiHillCipher($_POST['Tanggal_Pemeriksaan'], $kunci);
        $enkripdiagnosa = enkripsiHillCipher($_POST['Diagnosis'], $kunci);
        $enkriphasilperiksa = enkripsiHillCipher($_POST['Hasil_Pemeriksaan'], $kunci);
        $enkripanjuranperawatan = enkripsiHillCipher($_POST['Perawatan_Yang_Direkomendasikan'], $kunci);
        $enkripcatatan = enkripsiHillCipher($_POST['Catatan_Tambahan'], $kunci);
        $idpasien =  $_POST['ID_Pasien'];
        $idstaf = $_POST['ID_Staf'];

        $sql = "INSERT INTO `riwayat_medis` (`ID_Pasien`, `ID_Staf`, `Tanggal_Pemeriksaan`, `Diagnosis`, `Hasil_Pemeriksaan`, `Perawatan_Yang_Direkomendasikan`, `Catatan_Tambahan`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $idpasien, $idstaf, $enkriptanggalperiksa, $enkripdiagnosa, $enkriphasilperiksa, $enkripanjuranperawatan, $enkripcatatan);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_select_byid($id_riwayatmedis)
    {
        global $kdb;
        $sql = " select * from riwayat_medis where id_riwayatmedis= " . $id_riwayatmedis;
        $hasil2 = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil2;
    }
    function sql_update($kunci)
    {
        global $kdb;
        global $_POST;
        $enkriptanggalperiksa = enkripsiHillCipher($_POST['Tanggal_Pemeriksaan'], $kunci);
        $enkripdiagnosa = enkripsiHillCipher($_POST['Diagnosis'], $kunci);
        $enkriphasilperiksa = enkripsiHillCipher($_POST['Hasil_Pemeriksaan'], $kunci);
        $enkripanjuranperawatan = enkripsiHillCipher($_POST['Perawatan_Yang_Direkomendasikan'], $kunci);
        $enkripcatatan = enkripsiHillCipher($_POST['Catatan_Tambahan'], $kunci);
        $idpasien =  $_POST['ID_Pasien'];
        $idstaf = $_POST['ID_Staf'];
        $id_riwayatmedis = $_POST["id_riwayatmedis"];

        $sql  = "UPDATE `riwayat_medis` SET `ID_Pasien` = ?, `ID_Staf` = ?, `Tanggal_Pemeriksaan` = ?, `Diagnosis` = ?, `Hasil_Pemeriksaan` = ?, `Perawatan_Yang_Direkomendasikan` = ?, `Catatan_Tambahan` = ? WHERE `id_riwayatmedis` = ?";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "sssssssi", $idpasien, $idstaf, $enkriptanggalperiksa, $enkripdiagnosa, $enkriphasilperiksa, $enkripanjuranperawatan, $enkripcatatan, $id_riwayatmedis);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_delete()
    {
        global $kdb;
        global $_POST;
        $sql  = " delete from `riwayat_medis` where id_riwayatmedis= " . $_POST["id_riwayatmedis"];
        mysqli_query($kdb, $sql) or die(mysql_error());
    }

    ?>


    <?php
    include '../layout/F1.php';
    ?>