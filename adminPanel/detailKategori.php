<?php
    include "headerAdmin.php";

    // mengambil id
    if(isset($_GET['x'])){
        $id = $_GET['x'];

        // ambil data dari database
        $sql = $conn->query("SELECT * FROM kategori WHERE id='$id'");
        $data = $sql->fetch_array();
    }
    // simpan data
    if(isset($_POST['simpan'])){
        $kategoriBaru = $_POST['nama'];
        $sqlCek = "SELECT * FROM kategori WHERE nama='$kategoriBaru'";
        $cekKategori = $conn->query($sqlCek);

        do {
            if($kategoriBaru == $data['nama']){
                header("location: kategori.php");
                exit;
            }

            if($cekKategori->num_rows != 0 || empty($kategoriBaru)){
                $erorrPesan = "Kategori Sudah Ada";
                break;
            }

            $sqlSimpan = $conn->query("UPDATE `kategori` SET `nama` = '$kategoriBaru' WHERE `kategori`.`id` = $id;");
            $successPesan = "Berhasil Disimpan!!!";
            $refres =  "<meta http-equiv='refresh' content='1 ; url=kategori.php'>";
            echo $refres;
        } while (false);
    }
    // hapus data
    if(isset($_POST['delete'])){
        $sqlHapus = $conn->query("DELETE FROM `kategori` WHERE id=$id;");
        // hapus foto lama
        $fotoLama = $data['foto'];
        unlink("../image/$fotoLama");
        
        $successPesan = "Berhasil Dihapus!!!";
        $refres =  "<meta http-equiv='refresh' content='1 ; url=kategori.php'>";
        echo $refres;
    }

?>


<!-- breadcrumb -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-black-50 text-decoration-none"><i class="bi bi-house-door-fill"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="kategori.php" class="text-black-50 text-decoration-none">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details Kategori</li>
        </ol>
    </nav>
</div>

<!-- Details kategori -->
<div class="container my-2">
    <h3 class="mt-5">Details Kategori</h3>
    <form action="" method="post">
        <!-- Erorr Pesan -->
        <div class="col-12 col-sm-6">
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
        <!-- success pesan -->
        <div class="col-12 col-sm-6">
            <?php
            if(isset($successPesan)){
                echo "
                <div class='alert alert-success alert-dismissible fade show mt-3'>
                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                    <strong> $successPesan </strong>
                </div>
                ";
            }
            ?>
        </div>

        <div class="col-12 col-sm-6 my-3">
            <input type="text" name="nama" class="form-control" value="<?php echo $data['nama'] ?>">
        </div>
        <div class="row">
            <div class="col-6 col-sm-3">
                <button type="submit" name="simpan" class="btn btn-primary form-control">simpan</button>
            </div>
            <div class="col-6 col-sm-3">
                <button type="submit" name="delete" class="btn btn-outline-danger form-control" onClick="return confirm('Yakin Ingin Menghapus Kategori')">Hapus</button>
            </div>
        </div>
    </form>
</div>

<?php include "footerAdmin.php"; ?> 