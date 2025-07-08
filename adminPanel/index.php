<?php
    include "headerAdmin.php";

    // ambil jumlah kategori
    $sqlKategori = $conn->query("SELECT id FROM kategori");
    $jumlahKategori = $sqlKategori->num_rows;

    // ambil jumlah produk
    $sqlProduk = $conn->query("SELECT id FROM produk");
    $jumlahProduk = $sqlProduk->num_rows;

    // logout
    if(isset($_GET['logout'])){
        $_SESSION['admin'] = "";
        $_SESSION['password_admin'] = '';
        session_destroy();
        header('location: ../');
        exit;
    }

    // data pemesanan
    $sqlPemesanan = $conn->query("SELECT produk.nama as nama_produk,users.username,pemesanan.* FROM pemesanan
    INNER JOIN produk ON produk.id=pemesanan.id_produk INNER JOIN users ON users.username=pemesanan.username ORDER BY waktu_pesanan DESC;");

?>

    
<!-- breadcrumb --> 
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-house-door-fill"></i> Home</li>
        </ol>
    </nav>      
</div>

<div class="container">
    <h2>Hallo <?= $_SESSION['admin'] ?></h2>
    <div class="row">

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="row warna-1 p-4 m-1 rounded-4">
                <div class="col-4">
                    <i class="fas fa-align-justify fa-5x text-black-50"></i>
                </div>
                <div class="col-8 text-white">
                    <h2 class="fs-2">Kategori</h2>
                    <p class="fs-4"><?= $jumlahKategori ?> Kategori</p>
                    <p><a href="kategori.php" class="no-d text-white">Lihat Details</a></p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="row warna-2 p-4 m-1 rounded-4">
                <div class="col-4">
                    <i class="fas fa-box fa-5x"></i>
                </div>
                <div class="col-8 text-white">
                    <h2 class="fs-2">Produk</h2>
                    <p class="fs-4"><?= $jumlahProduk ?> Produk</p>
                    <p><a href="produk.php" class="text-white no-d">Lihat Details</a></p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container-sm mt-3">
    <div class="">
        <h2>List Pemesanan</h2>
        <table class="table table-striped">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Produk</th>
                <th>Jumlah Produk</th>
                <th>Total Bayar</th>
                <th>Metode Bayar</th>
                <th>Waktu Pesan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            $no = 1;
            while($row = $sqlPemesanan->fetch_assoc()){
                echo "
                <tr>
                    <td>{$no}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['nama_produk']}</td>
                    <td>{$row['jumlah_produk']}</td>
                    <td>{$row['total_pembayaran']}</td>
                    <td>{$row['metode_pembayaran']}</td>
                    <td>{$row['waktu_pesanan']}</td>
                    <td>{$row['status']}</td>
                    <td><a href='detailPesanan.php?id={$row['id']}' class='btn btn-info'><i class='bi bi-search'></i></a></td>
                </tr>
                ";
                $no++;
            }
            ?>
         
        </table>
    </div>
</div>
    

<?php include "footerAdmin.php"; ?>