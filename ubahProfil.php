<?php
    include "koneksi.php";

    // ambil data users
    session_start();
    cekSession();
    
    $usersname = $_SESSION['username'];
    $sqlUsers = $conn->query("SELECT * FROM users WHERE username='$usersname';");
    $dataUsers = $sqlUsers->fetch_array();

    if(isset($_POST['ubah'])){
        $usersnameBaru = $_POST['username'];
        $passwordLama = $_POST['password_lama'];
        $passwordBaru = $_POST['password_baru'];
        $email = $_POST['email'];
        $noHp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        do {
            if(empty($usersnameBaru) || empty($passwordLama)||empty($passwordBaru) || empty($email) ||empty($noHp) ||empty($alamat)){
                break;
            }
            // cek username agar tidak terjadi duplikat
            $dataUser = $conn->query("SELECT * FROM users WHERE username='$usersnameBaru' AND username != '$usersname'");
            $jumlahUser = $dataUser->num_rows;
            if($jumlahUser > 0){
                $errorPesan = "Username Sudah Terpakai";
                break;
            }
            // cek password lama
            if (password_verify($passwordLama, $dataUsers['password']) == false) {
                $errorPesan = "Password Lama Salah";
                break;
            }

            // hash pw
            $passwordHash = password_hash($passwordBaru, PASSWORD_DEFAULT);

            $conn->query("UPDATE users SET username='$usersnameBaru', `password` = '$passwordHash', `email` = '$email',
            `no_hp` = '$noHp', `alamat` = '$alamat' WHERE username='$usersname'");

            $suksesPesan = "Akun Berhasil Diubah";
            $_SESSION['username'] = $usersnameBaru;
            refres("akun.php");
        } while (false);
    }

    htmlHeader("Ubah Profil");
?>
<div class="container mt-5">
    <h2>Ubah Profil</h2>
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
                <input type="text" class="form-control" name="username" value="<?php if(isset($usersname)){echo $usersname;}else{echo $dataUsers['username'];} ?>" required>
            </div>
        </div>
        <!-- password lama -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password lama</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="password_lama" required>
            </div>
        </div>
        <!-- email -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-6">
                <input type="email" class="form-control" name="email" value="<?php if(isset($email)){echo $email;}else{echo $dataUsers['email'];} ?>" required>
            </div>
        </div>
        <!-- no hp -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Nomor Hp</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="no_hp" value="<?php if(isset($noHp)){echo $noHp;}else{echo $dataUsers['no_hp'];} ?>" required>
            </div>
        </div>
        <!-- alamat -->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="alamat" value="<?php if(isset($alamat)){echo $alamat;}else{echo $dataUsers['alamat'];} ?>" required>
            </div>
        </div>
        <!-- password baru-->
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Password baru</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" name="password_baru" required>
            </div>
        </div>

        <!-- tombol -->
        <div class="row mb-3">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 d-flex justify-content-between">
                <input type="submit" class="btn btn-primary w-100 " name="ubah" value="Ubah">
                <a href="akun.php" class="btn btn-outline-danger w-100 ms-3">Kembali</a>
            </div>
        </div>
    </form>
</div>


<?php
    htmlFooter();
?>