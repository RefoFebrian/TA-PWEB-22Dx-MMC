<!DOCTYPE html>
<html>
<head>
  <title>Form Login</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../bootstrap/css/all.css">
  <link href="../bootstrap/css/bootstraapap.min.css" rel="stylesheet">
  <link href="../bootstrap/css/docccss.css" rel="stylesheet">
  <link rel="stylesheet" href="ds.css">
  <script src="../bootstrap/js/bootstraaappp.bundle.min.js"></script>
  <script src="../bootstrap/js/jquery.min.js"></script>
</head>
<body>

<div class="wrapper">
        <div class="logo">
            <img src="logo.png" alt="">
        </div>
        <div class="text-center mt-4 name">
            LOGIN
        </div>
        <form class="p-3 mt-3" action="cek.php" method="post">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="pass" id="pass" placeholder="Password">
            </div>
            <button class="btn mt-3">Login</button>
        </form>
    </div>

</body>
</html>