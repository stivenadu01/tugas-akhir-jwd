<?php
    include "koneksi.php";
    session_start();

    // login
    $jumlahUser = 0;

    if(isset($_POST['login'])){
        $username =htmlspecialchars($_POST['username']);
        $password =htmlspecialchars($_POST['password']);

        $sqlUser = "SELECT * FROM users WHERE username='$username'";
        $hasil = $conn->query($sqlUser);
        $jumlahUser = $hasil->num_rows;
        $data = $hasil->fetch_assoc();


        do {
            if($jumlahUser<1){
                $erorrPesan = "Username Tidak Ada";
                break;
            }
            // See the password_hash() example to see where this came from.
            if (password_verify($password, $data['password']) == false || empty($password)){
                $erorrPesan = "Password Salah";
                break;
            }

            $_SESSION['username'] = $data['username'];
            $_SESSION['password'] = $data['password'];

            if(isset($_POST['ingat_saya'])){
                $cookieTime = time()+(60 * 60 * 24 * 30);

                // sintax cookie : setcookie(fieldname, nilai, time, path)
                setcookie("cookie_username",$data['username'],$cookieTime,"/");
                setcookie("cookie_password",$data['password'],$cookieTime,"/");
            }

            header('location: index.php');
            exit;
        } while (false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="asset/bootstrap.min.css">
    <link rel="stylesheet" href="asset/style.css">
    <style>
        .main{
            height: 100vh;
        }
        .login-box{
            width: 30%;
            height: 305px;
            border-radius: 10px;
            box-sizing: border-box;
        }
        .btn{
            height: 40px;
        }
        @media (max-width: 720px) {
            
            .login-box{
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- form login -->
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <!-- Erorr Pesan -->
        <div class="" style="width: 400px;">
            <?php
            if(isset($erorrPesan)){
                echo "
                <div class='alert alert-warning alert-dismissible fade show mt-3'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong> $erorrPesan </strong>
                </div>
                ";
            }
            ?>
        </div>
        
        <div class="login-box shadow">
            <form action="" method="post" class="p-3">
                <div class="">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php if(isset($username) and $jumlahUser > 0){echo $username;} ?>">
                </div>
                <div class="">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="ingatsaya" value="1" name="ingat_saya">
                    <label for="ingatsaya" class="form-check-label">Ingat Saya</label>
                </div>
                <div class="">
                    <button class="btn btn-primary form-control mt-4 h-4" type="submit" name="login" >Login</button>
                </div>
                <div class="mt-3 text-center">
                    <p>Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar sekarang!</a></p>
                </div>
            </form>
        </div>

    </div>

    <script src="asset/bootstrap.bundle.min.js"></script>
</body>
</html>