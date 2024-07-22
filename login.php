<?php
session_start();
require "config.php";

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);

    // Query untuk memeriksa kecocokan username, password, dan status cek
    $sql = "SELECT * FROM users WHERE username='$username' AND pass='$pass'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // Periksa status kolom cek
        if ($row["cek"] === 'on') {
            // Login Berhasil
            $_SESSION['username'] = $row["username"];
            $_SESSION['level'] = $row["level"];
            $_SESSION['status'] = "y";
            header("Location:index.php");
        } else {
            // Akun belum aktif
            header("Location:?msg=inactive");
        }
    } else {
        // Login gagal
        header("Location:?msg=n");
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>
    <link rel="stylesheet" href="src/style.css">
</head>

<body>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Login Ke Akun Anda</h2>
            <!-- Validasi Login Gagal -->
            <?php
            if (isset($_GET['msg'])) {
                if ($_GET['msg'] == "n") {
            ?>
                    <div class="alert alert-danger" align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Login Gagal</strong>
                    </div>
                <?php
                } elseif ($_GET['msg'] == "inactive") {
                ?>
                    <div class="alert alert-warning" align="center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Akun Belum Aktif</strong>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <form class="space-y-6" method="POST">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                        <div class="mt-2">
                            <input name="username" type="text" autocomplete="off" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <label for="pass" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input name="pass" type="password" autocomplete="off" required class="p-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        </div>
                    </div>

                    <div>
                        <input type="submit" name="submit" value="Sign in" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    </div>
                </form>

                <div>
                    <div class="relative mt-10">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm font-medium leading-6">
                            <span class="bg-white px-6 text-gray-900">Belum Punya Akun? <a class="text-indigo-600 hover:text-indigo-900" href="register.php">Daftar</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.0.min.js"></script>
</body>

</html>