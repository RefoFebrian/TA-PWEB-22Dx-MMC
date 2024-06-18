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
    $id_user = !empty($_GET['id']) ? $_GET['id'] : " ";
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
            curd_update($id_user);
            break;
        case "hapus":
            curd_delete($id_user);
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
            $query = "SELECT * from pengguna where id_user LIKE ? 
                      or username LIKE ? 
                      or pass LIKE ?";
            
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
            <H3> MASTER DATA PENGGUNA </H3>
            <br><br><br>
            <ul class="bagan">
               <li class="area_tmbhdta"><a href="pengguna.php?a=tambah" class="btn btn-warning" style="margin-left: 5px;">+ Tambah Data    </a></li>
               <li class="area_cari">
                   <form class="d-flex " role="search" action="" method="post">
                       <input class="form-control me-2" type="text" name="cari" placeholder="Search" aria-label="Search">
                       <button class="btn btn-outline-info" type="submit" name="cari2" value="cari">Search</button>
                    </form>
                </li> 
            </ul>
        </center> 
        <center>
            <table class="table table-bordered">
                <tr>
                    <td>No</td>
                    <td>ID user</td>
                    <td>username</td>
                    <td>Password</td>
                    <td>Aksi</td>

                </tr>
                <?php
                require_once '../HillCipher/dekripsi.php';
                while ($baris = mysqli_fetch_array($hasil)) {
                    $dekripusername = DekripsiHillCipher($baris['username'], $kunci);
                    $dekrippassword = DekripsiHillCipher($baris['pass'], $kunci);
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $baris['id_user']; ?></td>
                        <td><?php echo $dekripusername; ?></td>
                        <td><?php echo $dekrippassword; ?></td>
                        <td>
                            <a href="pengguna.php
            ?a=edit&id=<?php echo $baris['id_user']; ?>" class="btn btn-success ">UPDATE</a>
                            <a href="pengguna.php
            ?a=hapus&id=<?php echo $baris['id_user']; ?>" class="btn btn-danger ">DELETE</a>
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
                    <td width="200px">Nama user</td>
                    <td><input type="text" name="username" id="username" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                            echo trim(DekripsiHillCipher($row["username"], $kunci)) ?>"></td>
                </tr>
                <tr>
                    <td width="200px">password</td>
                    <td><input type="text" name="pass" id="pass" maxlength="25" size="25" value="<?php require_once '../HillCipher/dekripsi.php';
                                                                                                    echo trim(DekripsiHillCipher($row["pass"], $kunci)) ?>"></td>
                </tr>
            </table>
        </center>
    <?php  } ?>

    <?php
    function curd_create()
    {
    ?><center>
            <h3>Penambahan Data user</h3><br>
            <a href="pengguna.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="pengguna.php?a=reset" method="post">
                <input type="hidden" name="sql" value="insert">
                <?php
                $row = array(
                    "username" => "",
                    "pass" => ""
                );

                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Simpan" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_update($id_user)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_user);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <center>
            <h3>Pengubahan Data user</h3><br>
            <a href="pengguna.php?a=reset" class="btn btn-danger ">Batal</a>
            <br>
            <form action="pengguna.php?a=reset" method="post">
                <input type="hidden" name="sql" value="update">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                <?php
                formeditor($row)
                ?>
                <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
            </form>
        </center>
    <?php } ?>
    <?php
    function curd_delete($id_user)
    {
        global $kdb;
        $hasil2 = sql_select_byid($id_user);
        $row = mysqli_fetch_array($hasil2);
    ?>
        <h3>Penghapusan Data user</h3><br>
        <a href="pengguna.php?a=reset" class="btn btn-danger ">Batal</a>
        <br>
        <form action="pengguna.php?a=reset" method="post">
            <input type="hidden" name="sql" value="delete">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
            <h3> Anda yakin akan menghapus data  <?php require_once '../HillCipher/dekripsi.php';
                                                        echo DekripsiHillCipher($row['username'], $kunci); ?> </h3>
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
        $sql = " select * from pengguna ";
        $hasil = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil;
    }
    function sql_insert($kunci)
    {
        global $kdb;
        global $_POST;

        $encryptedUsername = enkripsiHillCipher($_POST["username"], $kunci);
        $encryptedPassword = enkripsiHillCipher($_POST["pass"], $kunci);

        $sql = "INSERT INTO `pengguna` (`username`, `pass`) VALUES (?, ?)";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $encryptedUsername, $encryptedPassword);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_select_byid($id_user)
    {
        global $kdb;
        $sql = " select * from pengguna where id_user= " . $id_user;
        $hasil2 = mysqli_query($kdb, $sql) or die(mysql_error());
        return $hasil2;
    }
    function sql_update($kunci)
    {
        global $kdb;
        global $_POST;
        $encryptedUsername = enkripsiHillCipher($_POST["username"], $kunci);
        $encryptedPassword = enkripsiHillCipher($_POST["pass"], $kunci);
        $id_user = $_POST["id_user"];

        $sql  = "UPDATE `pengguna` SET `username` = ?, `pass` = ? WHERE `id_user` = ?";
        $stmt = mysqli_prepare($kdb, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $encryptedUsername, $encryptedPassword, $id_user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    function sql_delete()
    {
        global $kdb;
        global $_POST;
        $sql  = " delete from `pengguna` where id_user= " . $_POST["id_user"];
        mysqli_query($kdb, $sql) or die(mysql_error());
    }

    ?>


    <?php
    include '../layout/F1.php';
    ?>