<?php
    include "headerAdmin.php";
    
    if(isset($_GET['x'])){
        $id = $_GET['x'];
    }
    // ambil data yg mau di edit
    $sqlProduk = $conn->query("SELECT * FROM produk WHERE id='$id'");
    $dataProduk = $sqlProduk->fetch_array();
    $fotoLama = $dataProduk['foto'];

    // update data produk
    if(isset($_POST['simpan'])){
        $nama = $_POST['nama'];
        $idKategori = $_POST['id_kategori'];
        $harga = $_POST['harga'];
        $details = $_POST['details'];
        // foto
        $target_dir = "../image/";
        $target_file = $target_dir . $_FILES["foto"]["name"];
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $newName = randomStr() . "." . $imageFileType; 
        $target_save = $target_dir . $newName;

        do {
            if($nama == "" || $idKategori == "" || $harga == ""){
                $erorrPesan = "Nama,kategori dan harga wajib di isi!";
                break;
            }
            $sqlProduk = $conn->query("UPDATE `produk` SET `nama` = '$nama',`id_kategori` = '$idKategori' ,
                        `harga`= '$harga',`details` = '$details' WHERE `produk`.`id` = '$id';");
            
            if($_FILES['foto']['name'] != ''){
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["foto"]["tmp_name"]);
                if($check === false) {
                    $erorrPesan = "File is not an image.";
                    break;
                } 
                // Check file size
                if ($_FILES["foto"]["size"] > 2000000) {
                    $erorrPesan = "File Terlalu Besar";
                    break;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                    $erorrPesan = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    break;
                }
      
                $x = move_uploaded_file($_FILES["foto"]["tmp_name"], $target_save);
                $sqlfoto = $conn->query("UPDATE `produk` SET `foto` = '$newName' WHERE `produk`.`id` = '$id';");
                
                // hapus foto lama
                unlink("../image/$fotoLama");
            }

            $successPesan = "Berhasil";
            $refres =  "<meta http-equiv='refresh' content='0.5 ; url=produk.php'>";
            echo $refres;
            break;

        } while (false);
    }
    
    // hapus produk
    if(isset($_POST['hapus'])){
        $sqlHapus = $conn->query("DELETE FROM produk WHERE id='$id'");
        // hapus foto
        unlink("../image/$fotoLama");
        $successPesan = "BERHASIL DI HAPUS!";
        $refres =  "<meta http-equiv='refresh' content='1 ; url=produk.php'>";
        echo $refres;
    }
?>
<!-- breadcrumb -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-black-50 text-decoration-none"><i class="bi bi-house-door-fill"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="produk.php" class="text-black-50 text-decoration-none">Produk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
        </ol>
    </nav>
</div>

<div class="container my-2">
    <div class="row">
        <div class="col-sm-5 overflow-hidden mt-3">
            <img src="../image/<?= $dataProduk['foto'] ?>" alt="Foto Produk" width="100%">
        </div>
        <!-- Details produk -->
        <form action="" method="post" enctype="multipart/form-data" class="col-sm-7">
            <h3 class="mt-1">Details Produk</h3>
            <!-- Erorr Pesan -->
            <div class="">
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
            <div class="">
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
            <div class="my-3">
                <label class="form-label" for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" value="<?= $dataProduk['nama'] ?>">
            </div>
            <div class="my-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select name="id_kategori" id="id_kategori" class="form-control">
                    <?php
                        //ambil data dari tabel kategori
                        $sqlKategori = $conn->query("SELECT * FROM kategori");
                        while($dataKategori = $sqlKategori->fetch_assoc()){
                            $cek = "";
                            if($dataKategori['id'] == $dataProduk['id_kategori']){
                                $cek = "selected";
                            }
                            echo "
                                <option value='{$dataKategori['id']}' $cek>{$dataKategori['nama']}</option>
                            ";
                        }
                    ?>
                </select>
            </div>
            <div class="my-3">
                <label class="form-label" for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" id="harga" value="<?= $dataProduk['harga'] ?>">
            </div>
            <div class="my-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="my-3">
                <label for="details">Details</label>
                <textarea class="form-control" name="details" id="details" rows="5"><?= $dataProduk['details'] ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <input type="submit" name="simpan" class="btn btn-primary form-control" value="Simpan">
                </div>
                <div class="col-6">
                    <input type="submit" name="hapus" onClick="return confirm('Yakin Ingin Menghapus Produk')" class="btn btn-outline-danger form-control" value="Hapus">
                </div>
            </div>
        </form >
        
    </div>
</div>

<?php include "footerAdmin.php"; ?>