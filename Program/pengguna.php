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

/**
 * Fungsi untuk mengambil data pengguna dari database berdasarkan ID pengguna.
 *
 * @param int $id_user ID pengguna yang akan dicari dalam database.
 * @return mixed Hasil query dari data pengguna yang ditemukan atau null jika tidak ada data.
 */
function sql_select_byid($id_user)
{
    // Mengakses variabel koneksi database global
    global $kdb;

    // Membuat query SQL untuk mengambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM pengguna WHERE id_user= " . $id_user;

    // Menjalankan query SQL dan menyimpan hasilnya
    $hasil2 = mysqli_query($kdb, $sql) or die(mysqli_error($kdb));

    // Mengembalikan hasil query
    return $hasil2;
}

/**
 * Fungsi untuk menyisipkan data pengguna baru ke dalam database.
 */
function sql_insert()
{
    // Mengakses variabel koneksi database global
    global $kdb;

    // Mengakses data yang dikirim melalui metode POST
    global $_POST;

    // Mengambil data username, password, dan hak dari data POST
    $encryptedUsername = $_POST["username"];
    $encryptedPassword = $_POST["password"];
    $encryptedhak = $_POST["hak"];

    // Membuat query SQL untuk menyisipkan data pengguna baru
    $sql = "INSERT INTO `pengguna` (`username`, `password`, `hak`) VALUES (?, ?, ?)";

    // Persiapan statement SQL
    $stmt = mysqli_prepare($kdb, $sql);

    // Binding parameter ke dalam statement SQL
    mysqli_stmt_bind_param($stmt, "sss", $encryptedUsername, $encryptedPassword, $encryptedhak);

    // Menjalankan statement SQL
    mysqli_stmt_execute($stmt);

    // Menutup statement SQL
    mysqli_stmt_close($stmt);
}


/**
 * Fungsi untuk mengambil semua data pengguna dari database.
 *
 * @return mixed Hasil query dari semua data pengguna yang ditemukan atau null jika tidak ada data.
 */
function sql_select()
{
    // Mengakses variabel koneksi database global
    global $kdb;

    // Membuat query SQL untuk mengambil semua data pengguna
    $sql = "SELECT * FROM pengguna";

    // Menjalankan query SQL dan menyimpan hasilnya
    $hasil = mysqli_query($kdb, $sql) or die(mysqli_error($kdb));

    // Mengembalikan hasil query
    return $hasil;
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
                <td><select name="hak">
                        <option value="admin">Admin</option>
                        <option value="pegawai">Pegawai</option>
                        <option value="apotek">Apotek</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </td>
            </tr>
        </table>
    </center>
<?php  } ?>

<!-- fungsi crud create -->

<!-- CRUD CREATE -->
<?php
// Fungsi untuk membuat tampilan form penambahan data pengguna
function curd_create()
{
?><center>
        <!-- Judul form -->
        <h3>Penambahan Data user</h3><br>

        <!-- Tombol untuk membatalkan penambahan data -->
        <a href="pengguna.php?a=reset" class="btn btn-danger">Batal</a>
        <br>

        <!-- Form untuk mengirimkan data penambahan pengguna -->
        <form action="pengguna.php?a=reset" method="post">
            <!-- Input tersembunyi untuk menandai tipe operasi SQL -->
            <input type="hidden" name="sql" value="insert">

            <?php
            // Data pengguna awal dengan nilai default
            $row = array(
                "username" => "",
                "password" => "",
                "hak" => ""
            );

            // Memanggil fungsi untuk menampilkan form pengisian data pengguna
            formeditor($row)
            ?>

            <!-- Tombol untuk menyimpan data pengguna yang ditambahkan -->
            <p><input type="submit" name="action" value="Simpan" class="btn btn-success "></p>
        </form>
    </center>

<?php } ?>

<?php
// Fungsi untuk menampilkan formulir pengubahan data pengguna
function curd_update($id_user)
{
    // Mengakses variabel koneksi database global
    global $kdb;

    // Mengambil data pengguna berdasarkan ID dari database
    $hasil2 = sql_select_byid($id_user);

    // Mengambil satu baris data pengguna dari hasil query
    $row = mysqli_fetch_array($hasil2);
?>
    <!-- Mulai form untuk pengubahan data pengguna -->
    <center>
        <!-- Judul form -->
        <h3>Pengubahan Data user</h3><br>

        <!-- Tombol untuk membatalkan pengubahan data -->
        <a href="pengguna.php?a=reset" class="btn btn-danger">Batal</a>
        <br>

        <!-- Form untuk mengirimkan data pengubahan pengguna -->
        <form action="pengguna.php?a=reset" method="post">
            <!-- Input tersembunyi untuk menandai tipe operasi SQL -->
            <input type="hidden" name="sql" value="update">

            <!-- Input tersembunyi untuk menyimpan ID pengguna yang akan diubah -->
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">

            <?php
            // Memanggil fungsi untuk menampilkan form pengisian data pengguna
            formeditor($row)
            ?>

            <!-- Tombol untuk menyimpan data pengguna yang telah diubah -->
            <p><input type="submit" name="action" value="Update" class="btn btn-success "></p>
        </form>
    </center>
<?php } ?>