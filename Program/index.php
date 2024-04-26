<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <div class=" text-center mt-4 name">Klinik Pratama Sumbersion</div>
        <form class="p-3 mt-3" action="cek-login.php" method="post">
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span><input type="password" name="pass" id="pass" placeholder="Password">
            </div>
            <button class="btn mt-3">Login</button>
        </form>
    </div>
</body>
</html>