<?php
    include "headerAdmin.php";

    // ambil data produk
    $sqlProduk = "SELECT a.*,b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori=b.id ORDER BY terjual DESC";
    $hasil = $conn->query($sqlProduk);
    $jumlahProduk = $hasil->num_rows;


    // tambah produk
    if(isset($_POST['tambah'])){
        $nama = $_POST['nama'];
        $idKategori = $_POST['id_kategori'];
        $harga = $_POST['harga'];
        $details = $_POST['details'];
        
        // foto
        $targetDir = "../image/";
        $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"],PATHINFO_EXTENSION));
        
        
        do {
            if($nama == "" || $idKategori == "" || $harga == "" || $idKategori == "0"){
                $erorrPesan = "Nama,kategori,Harga dan Foto wajib di isi!";
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

            $fileName = randomStr() . "." . $imageFileType; 
            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetDir . $fileName);
            
            // tambah ke data
            $sqlProduk = $conn->query("INSERT INTO `produk` (`id_kategori`, `nama`, `harga`, `foto`, `details`) VALUES ('$idKategori', '$nama', '$harga', '$fileName', '$details');");
            $successPesan = "Berhasil";
            refres("produk.php");
            break;
        } while (false);
    }




    // $tambahProduk = $conn->query("INSERT INTO `produk` (`id_kategori`, `nama`, `harga`, `foto`, `detail`, `stok`)
    // VALUES ('11', 'baju pria lengan pedek', '50000', NULL, NULL, 'tersedia');");


?>

<!-- breadcrumb -->
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-black-50 text-decoration-none"><i class="bi bi-house-door-fill"></i> Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produk</li>
        </ol>
    </nav>
</div>

<div class="container my-2">
    <!-- tambah produk -->
    <div class="row">
        <div class="col-md-6 col-lg-5">
            <h3 class="mt-5">Tambah Produk</h3>
            
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
            
        <form method="post" enctype="multipart/form-data">
            <div class="my-3">
                <label class="form-label" for="nama">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" required>
            </div>
            <div class="my-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select name="id_kategori" id="id_kategori" class="form-control" required>
                    <option value="0">Pilih Id Kategori</option>
                    <?php
                        //ambil data dari tabel kategori
                        $sqlKategori = $conn->query("SELECT * FROM kategori");
                        while($data = $sqlKategori->fetch_assoc()){
                            echo "
                                <option value='{$data['id']}'>{$data['nama']}</option>
                            ";
                        }
                    ?>
                </select>
            </div>
            <div class="my-3">
                <label class="form-label" for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" id="harga" required>
            </div>
            <div class="my-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control" required>
            </div>
            <div class="my-3">
                <label for="details">Details</label>
                <textarea class="form-control" name="details" id="details" rows="5"></textarea>
            </div>
            
            
            <div class="col-6 mt-4">
                <button type="submit" name="tambah" class="btn btn-primary form-control">Tambah</button>
            </div>
        </form>
    </div>

    <!-- List produk -->
    <div class="col-md-6 col-lg-7 mt-5">
        <h3>List Produk</h3>
        <div class="container overflow-scroll">
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>       
                        <th>Total Terjual</th>       
                        <th>Action</th>       
                    </tr>
                </thead>
                <?php
                    if($jumlahProduk==0){
                        echo "
                            <tr>
                                <td colspan='7' class='text-center'>Tidak Ada Produk</td>
                            </tr>
                        ";
                    }
                    $no = 1;
                    while($row = $hasil->fetch_assoc()){
                        echo "
                            <tr>
                                <td>{$no}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['nama_kategori']}</td>
                                <td>{$row['harga']}</td>
                                <td>{$row['stok']}</td>
                                <td>{$row['terjual']}</td>
                                <td>
                                    <a href='detailProduk.php?x={$row['id']}' class='btn btn-info'><i class='bi bi-search'></i></a>
                                </td>
                            </tr>
                        ";
                        $no ++;
                    }
                ?>
            </table>
        </div>
    </div>    
</div>
    

<?php include "footerAdmin.php"; ?>