<?php
    include "headerAdmin.php";

?>

<div class="container mt-5">
    <h2>Details Akun</h2>
    <div class="container mt-4">
        <form action="">
            <div class="row d-block">
                <div class="col-10 col-sm-6 col-md-4">
                    <label class="form-labe">Username</label>
                    <input type="text" class="form-control" disabled value="<?= $_SESSION['admin'] ?>">
                </div>
                <div class="col-10 col-sm-6 col-md-4">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" disabled value="<?= $_SESSION['password_admin'] ?>">
                </div>
            </div>
        </form>
    </div>
</div>

<?php include "footerAdmin.php"; ?>