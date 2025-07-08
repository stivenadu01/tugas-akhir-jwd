<?php
    include "koneksi.php";

    // ambil id produk
    if(isset($_GET['produk'])){
        $idProduk = $_GET['produk'];

        // ambil data produk yg dipilih
        $sqlProduk = $conn->query("SELECT * FROM produk WHERE id='$idProduk'");
        
        // ambil id kategori
        $sqlIdKategori = $conn->query("SELECT id_kategori FROM produk WHERE id='$idProduk'");
        $kategori = $sqlIdKategori->fetch_array();
        $idKategori = $kategori['id_kategori'];
    
        // ambil data produk terkait
        $sqlProdukTerkait = $conn->query("SELECT * FROM produk WHERE id_kategori='$idKategori'");
    }
    
    htmlHeader("DetailProduk");
?>
<!-- details produk -->
<div class="container">
    <div class="row">
        <?php
            if(isset($sqlProduk)){
                $dataProduk = $sqlProduk->fetch_array();
                $harga = number_format($dataProduk['harga'],0,'','.');
                echo "
                    <div class='col-sm-5 mt-4 rounded-5'>
                        <img src='image/{$dataProduk['foto']}' alt='foto produk' width='100%'>
                    </div>
                    
                    <div class='col-sm-7 h-100 mt-4'>
                        <h2>{$dataProduk['nama']}</h2>
                        <p>{$dataProduk['details']}</p>
                        <p class='fs-5 text-harga'>Rp {$harga}</p>
                        <p>Stok : <b>{$dataProduk['stok']}</b></p>
                        <p><a href='pemesanan.php?produk={$idProduk}' class='btn btn-outline-primary px-5'>Pesan</a></p>
                    </div>
                ";
            }
        ?>
    </div>
</div>

<!-- produk terkait -->
<div class="container-fluid my-5 bg-1 rounded">
    <div class="container">
        <h2 class="pt-3">Produk terkait</h2>
        <div class="row text-black">
            <?php
            if(isset($sqlProdukTerkait)){
                while($dataProduk = $sqlProdukTerkait->fetch_assoc()){
                    if($dataProduk['id']==$idProduk){
                        continue;
                    }
                    $harga = number_format($dataProduk['harga'],0,'','.');
                    echo "
                        <div class='col-6 col-sm-4 col-lg-3 mt-3 rounded'>
                            <div class='card h-100'>
                                <div class='image-box'>
                                    <img src='image/{$dataProduk['foto']}'>
                                </div>
                                <div class='card-body'>
                                    <div class='nama'>
                                        <h3 class='card-title text-3 text-truncate'>{$dataProduk['nama']}</h3>
                                    </div>
                                    <p class='card-text text-truncate text-2'>{$dataProduk['details']}</p>
                                    <p class='card-text text-harga mt-1'>Rp {$harga}</p>
                                    <a href='detailProduk.php?produk={$dataProduk['id']}' class='btn btn-biru text-white'>Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
    htmlFooter();
?>