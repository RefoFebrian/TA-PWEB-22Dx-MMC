<html>
    <?php
    // Mengambil nilai 'a' dari query string jika tidak kosong, jika kosong maka diatur sebagai "reset"
    $a = !empty($_GET['a']) ? $_GET['a'] : "reset";

    // Mengambil nilai 'id' dari query string jika tidak kosong, jika kosong maka diatur sebagai string kosong
    $id_user = !empty($_GET['id']) ? $_GET['id'] : " ";

    // Menggunakan fungsi koneksidatabase() untuk mendapatkan koneksi ke database
    $kdb = koneksidatabase();

    // Mengambil nilai 'a' dari query string tanpa menangani error
    $a = @$_GET["a"];

    // Mengambil nilai 'sql' dari data yang diupload tanpa menangani error
    $sql = @$_POST["sql"];

    // Menggunakan switch case untuk memeriksa nilai dari $sql lalu menjalankan fungsi yang dipanggil
    switch ($sql) {
        case "insert":
            sql_insert();
            break;
        case "update":
            sql_update();
            break;
        case "delete":
            sql_delete();
            break;
    }

    // Menggunakan switch case untuk memeriksa nilai dari $a dan mengeksekusi fungsi yang sesuai
    switch ($a) {
        case "reset":
            curd_read();
            break;
        case "tambah":
            curd_create();
            break;
        case "edit":
            // Memanggil fungsi curd_update() dengan $id_user sebagai parameter
            curd_update($id_user);
            break;
        case "hapus":
            // Memanggil fungsi curd_delete() dengan $id_user sebagai parameter
            curd_delete($id_user);
            break;
        default:
            curd_read();
            break;
    }

    // Lanjutkan pembuatan fungsi CRUD

    
    // Fungsi Koneksi Ke database
    function koneksidatabase()
    {
        // Mengimpor file koneksi.php untuk mendapatkan koneksi ke database
        include('koneksi.php');

        // Mengembalikan koneksi database
        return $kdb;
    }
    ?>

    <!-- Fungsi Formeditor -->
    <?php
function formeditor($row)
{
?>
    <center>
        <table>
            <tr>
                <td width="200px">Nama user</td>
                <td><input type="text" name="username" id="username" maxlength="25" size="25" value="<?php echo trim($row["username"]) ?>"></td>
            </tr>
            <tr>
                <td width="200px">password</td>
                <td><input type="text" name="password" id="password" maxlength="25" size="25" value="<?php echo trim($row["password"]) ?>"></td>
            </tr>
            <tr>
                <td width="200px">hak</td>
                <td>
                    <select name="hak">
                        <option value="admin">Admin</option>
                        <option value="pegawai">Pegawai</option>
                        <option value="apotek">Apotek</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </td>
            </tr>
        </table>
    </center>
<?php
}
?>
