<?php
    include "headerAdmin.php";

    // ambil data kategori
    $sqlKategori = "SELECT * FROM kategori ORDER BY terjual DESC";
    $hasil = $conn->query($sqlKategori);
    $jumlahKategori = $hasil->num_rows;

    // tambah kategori
    if(isset($_POST['tambah'])){
        $kategoriBaru = $_POST['nama'];
        // cek apakah kategori sudah ada
        $sqlCek = "SELECT * FROM kategori WHERE nama='$kategoriBaru'";
        $cekKategori = $conn->query($sqlCek);

        do {
            if( empty($kategoriBaru)){
                $erorrPesan = "Nama Kategori belum di isi";
                break;
            }
            if($cekKategori->num_rows != 0){
                $erorrPesan = "Kategori Sudah Ada";
                break;
            }
            if($_FILES['foto']['name'] == ''){
                $erorrPesan = "Foto belum di pilih";
                break;
            }

            // foto
            $targetDir = "../image/";
            $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION));

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
            
            $fileName = str_replace(' ','',$kategoriBaru) . "." . $imageFileType; 
            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetDir . $fileName);


            $sqlTambah = $conn->query("INSERT INTO `kategori` (`nama`,`foto`) VALUES ('$kategoriBaru','$fileName');");
            $successPesan = "Berhasil Ditambahkan!!!";
            $refres =  "<meta http-equiv='refresh' content='1 ; url=kategori.php'>";
            echo $refres;
        } while (false);
    }
?>

<!-- breadcrumb -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-black-50 text-decoration-none"><i class="bi bi-house-door-fill"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ol>
    </nav>
</div>

<!-- tambah kategori -->
<div class="container my-2">
    <h3 class="mt-5">Tambah Kategori</h3>
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

    <form action="" method="post" enctype="multipart/form-data">
        <div class="col-sm-6 my-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?php if(isset($kategoriBaru)){echo $kategoriBaru;} ?>">
        </div>
        <div class="col-sm-6 my-3">
            <label class="form-label">Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <div class="col-6 col-sm-3">
            <button type="submit" name="tambah" class="btn btn-primary form-control">Tambah</button>
        </div>
    </form>
</div>
    
<!-- List Kategori -->
<div class="container mt-5">
    <h2>List Kategori</h2>
    <table class="table table-striped mt-3">
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Total Terjual</th>
            <th>Action</th>
        </tr>
        <?php
            if($jumlahKategori==0){
                echo "
                    <tr>
                        <td colspan='4' class='text-center'>Tidak Ada Kategori</td>
                    </tr>
                ";
            }
            $no = 1;
            while($row = $hasil->fetch_array()){
                echo "
                    <tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['terjual']}</td>
                        <td>
                            <a href='detailKategori.php?x={$row['id']}' class='btn btn-info'><i class='bi bi-search'></i></a>
                        </td>
                    </tr>
                ";
                $no ++;
            }
        ?>
    </table>
</div>

<?php include "footerAdmin.php"; ?>