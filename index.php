<?php
    include "koneksi.php";
    session_start();

    // cekcookie kalau belum login
    if(isset($_COOKIE['cookie_username']) AND !isset($_SESSION['username'])){
        $cookieUsername = $_COOKIE['cookie_username'];
        $cookiePassword = $_COOKIE['cookie_password'];
        $sqlUserCookie = $conn->query("SELECT * FROM users WHERE username='$cookieUsername'");
        $jumlahUserCookie = $sqlUserCookie->num_rows;
        if($jumlahUserCookie > 0){
            $dataUserCookie = $sqlUserCookie->fetch_assoc();
            if($cookiePassword === $dataUserCookie['password']){
                $_SESSION['username'] = $cookieUsername;
                $_SESSION['password'] = $cookiePassword;
            }
        }
    }

    // ambil 3 kategori terlaris
    $sqlKategoriTop3 = $conn->query("SELECT * FROM `kategori` ORDER BY `terjual` DESC LIMIT 3;");

    // ambil 8 produk terlaris
    $sqlProdukTop8 = $conn->query("SELECT * FROM `produk` ORDER BY `terjual` DESC LIMIT 8;");

    htmlHeader();
?>
<!-- kategori terlaris -->
<div class="container-fluid bg-1 py-4 text-center rounded">
    <h2>Kategori Terlaris</h2>
    <div class="row text-white">
        <?php
        while($dataKategori = $sqlKategoriTop3->fetch_array()){
            echo "
            <div class='col-md-4 mt-3'>
                <div class='kategori-image d-flex justify-content-center align-items-center' style='background:linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3)),url(image/{$dataKategori['foto']}); background-size: cover; background-position: center;'>
                    <a href='produk.php?kategori={$dataKategori['id']}' class='text-decoration-none text-white text-opacity-75'><h4 class='p-5'>{$dataKategori['nama']}</h4></a>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>

<!-- produk terlaris -->
<div class="mt-3 container-fluid container-sm">
    <div class="row bg-1 rounded-3">
        <h3 class="nama pt-4 ">Produk pilihan terpopuler</h3>
        <?php
        while($dataProduk = $sqlProdukTop8->fetch_assoc()){
            $harga = number_format($dataProduk['harga'],0,'','.');
            echo "
                <div class='col-6 col-sm-4 col-lg-3 mt-3 rounded'>
                    <div class='card h-100'>
                        <div class='image-box'>
                            <img src='image/{$dataProduk['foto']}'>
                        </div>
                        <div class='card-body'>
                            <div class=''>
                                <p class='card-title text-3 text-truncate'>{$dataProduk['nama']}</p>
                            </div>
                            <p class='card-text text-truncate text-2'>{$dataProduk['details']}</p>
                            <p class='card-text text-harga'>Rp {$harga}</p>
                            <a href='detailProduk.php?produk={$dataProduk['id']}' class='btn btn-biru text-white'>Lihat Detail</a>
                        </div>
                    </div>
                </div>
            ";
        }
        ?>
    </div>
</div>



<?php
    htmlFooter();
?>