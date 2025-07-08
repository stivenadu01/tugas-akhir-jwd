<?php
    include "koneksi.php";

    if(isset($_POST['kirim'])){
        $usersname = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $noHp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        do {
            if(empty($usersname) || empty($password) || empty($email) ||empty($noHp) ||empty($alamat)){
                $errorPesan = "Semua Wajib Di Isi";
                break;
            }
            // cek username minimal 5 dan tidak boleh diawali oleh angka
            if(strlen($usersname) < 5 || preg_match("/^[0-9]/",$usersname)){
                $errorPesan = "Username minimal 5 karakter dan tidak boleh diawali oleh angka!";
                break;
            }
            // cek username agar tidak terjadi duplikat
            $dataUser = $conn->query("SELECT * FROM users WHERE username='$usersname'");
            $jumlahUser = $dataUser->num_rows;
            if($jumlahUser > 0){
                $errorPesan = "Username Sudah Terpakai";
                break;
            }
            
            // cek format penulisan email
            if(!preg_match("/.+@.+\..+/",$email)){
                $errorPesan = "Format Penulisan Email Salah";
                break;
            }
            // cek email agar tidak terjadi duplikat
            $dataEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
            $jumlahEmail = $dataEmail->num_rows;
            if($jumlahEmail > 0){
                $errorPesan = "Email Sudah Terpakai";
                break;
            }

            // hash pw
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            

            $sqlRegister = "INSERT INTO `users` (`username`, `password`, `email`, `no_hp`, `alamat`)
            VALUES ('$usersname', '$passwordHash', '$email', '$noHp', '$alamat');";
            $register = $conn->query($sqlRegister);

            $suksesPesan = "Akun Berhasil Dibuat";
            refres("login.php");
        } while (false);
    }

    htmlHeader("Register");
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Register</h2>
    <form action="" method="post">
        <?php
            if (isset($errorPesan)){
                echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>$errorPesan</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
            if (isset($suksesPesan)){
                echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>$suksesPesan</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                ";
            }
        ?>

        <!-- nama -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Username</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="username" value="<?php if(isset($usersname)){echo $usersname;} ?>" required>
            </div>
        </div>
        <!-- password -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="password" value="<?php if(isset($password)){echo $password;} ?>" required>
            </div>
        </div>
        <!-- email -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="email" value="<?php if(isset($email)){echo $email;} ?>" required>
            </div>
        </div>
        <!-- no hp -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nomor Hp</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="no_hp" value="<?php if(isset($noHp)){echo $noHp;} ?>" required>
            </div>
        </div>
        <!-- alamat -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="alamat" value="<?php if(isset($alamat)){echo $alamat;} ?>" required>
            </div>
        </div>

        <!-- tombol -->
        <div class="row mb-3">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 d-flex justify-content-between">
                <input type="submit" class="btn btn-primary w-100" name="kirim" value="Kirim">
                <a href="index.php" class="btn btn-outline-danger w-100 ms-5">Kembali</a>
            </div>
        </div>
    </form>
</div>


<?php
    htmlFooter();
?>