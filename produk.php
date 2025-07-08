<?php
    include "koneksi.php";

    // ambil produk 
    $sqlProdukTop = $conn->query("SELECT * FROM `produk` ORDER BY `terjual` DESC;");

    // search
    $jumlahSearch = 0;
    if(isset($_GET['search'])){
        $search = $_GET['search'];
        $search1 = substr($search,0, 4);
        $search2 = substr($search,-4, 4);
        $sqlSearch = $conn->query("SELECT * FROM produk WHERE nama LIKE '%$search1%' OR nama LIKE '%$search2%'");
        $jumlahSearch = $sqlSearch->num_rows;
    }

    $sqlKategori = $conn->query("SELECT * FROM kategori");
    $jumlahSearchKategori = 0;
    if(isset($_GET['kategori'])){
        $idKategori = $_GET['kategori'];
        $sqlSearchKategori = $conn->query("SELECT * FROM produk WHERE id_kategori='$idKategori' ORDER BY terjual DESC");
        $jumlahSearchKategori = $sqlSearchKategori->num_rows;
    }


    htmlHeader('Produk');
?>

<div class="row mt-5 container-fluid">
    <!-- kategori list -->
    <div class="col-sm-3">
        <h3>Kategori</h3>
        <ul class="list-group">
            <?php
            while($dataKategori = $sqlKategori->fetch_array()){
                $Kategoriaktif = "";
                if(isset($idKategori)){
                    if($dataKategori['id'] == $idKategori){
                        $Kategoriaktif = "list-group-item-aktif";
                    }
                }
                echo "
                <a class='text-decoration-none' href='produk.php?kategori={$dataKategori['id']}'><li class='list-group-item list-kategori <?= $Kategoriaktif ?>'>{$dataKategori['nama']}</li></a>
                ";
            }
            ?>
        </ul>
    </div>

    <!-- produk -->
    <div class="col-sm-9 overflow-scroll mt-3 mt-sm-0">
        <h3>Produk</h3>
        <div class="row bg-1 rounded-3">
            <?php
            do {
                if($jumlahSearchKategori > 0){
                    while($dataSearchKategori = $sqlSearchKategori->fetch_array()){
                        $harga = number_format($dataSearchKategori['harga'],0,'','.'); 
                        echo "
                            <div class='col-6 col-sm-4 col-lg-3 mt-3 rounded'>
                                <div class='card h-100'>
                                    <div class='image-box'>
                                        <img src='image/{$dataSearchKategori['foto']}'>
                                    </div>
                                    <div class='card-body'>
                                        <div class='nama'>
                                            <h4 class='card-title text-3 text-truncate'>{$dataSearchKategori['nama']}</h4>
                                        </div>
                                        <p class='card-text text-truncate text-2'>{$dataSearchKategori['details']}</p>
                                        <p class='card-text text-harga text-biru-1 mt-1'>Rp {$harga}</p>
                                        <a href='detailProduk.php?produk={$dataSearchKategori['id']}' class='btn btn-biru text-white'>Lihat Detail</a>
                                    </div>
                                </div>
                            </div>                            
                        ";
                    }
                    break;
                }

                if($jumlahSearch > 0){
                    while($dataSearch = $sqlSearch->fetch_array()){
                        $harga = number_format($dataSearch['harga'],0,'','.'); 
                        echo "
                            <div class='col-6 col-sm-4 col-lg-3 mt-3 rounded'>
                                <div class='card h-100'>
                                    <div class='image-box'>
                                        <img src='image/{$dataSearch['foto']}'>
                                    </div>
                                    <div class='card-body'>
                                        <div class='nama'>
                                            <h4 class='card-title text-3 text-truncate'>{$dataSearch['nama']}</h4>
                                        </div>
                                        <p class='card-text text-truncate text-2'>{$dataSearch['details']}</p>
                                        <p class='card-text text-harga text-biru-1 mt-1'>Rp {$harga}</p>
                                        <a href='detailProduk.php?produk={$dataSearch['id']}' class='btn btn-biru text-white'>Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        ";
                    }
                    break;
                }
                
                while($dataProduk = $sqlProdukTop->fetch_assoc()){
                    $harga = number_format($dataProduk['harga'],0,'','.'); 
                    echo "
                        <div class='col-6 col-sm-4 col-lg-3 mt-3 rounded'>
                            <div class='card h-100'>
                                <div class='image-box'>
                                    <img src='image/{$dataProduk['foto']}'>
                                </div>
                                <div class='card-body'>
                                    <div class='nama'>
                                        <h4 class='card-title text-3 text-truncate'>{$dataProduk['nama']}</h4>
                                    </div>
                                    <p class='card-text text-truncate text-2'>{$dataProduk['details']}</p>
                                    <p class='card-text text-harga text-biru-1 mt-1'>Rp {$harga}</p>
                                    <a href='detailProduk.php?produk={$dataProduk['id']}' class='btn btn-biru text-white'>Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    ";
                }
            } while (false);
            ?>
        </div>
    </div>
</div>

<?php
    htmlFooter();
?>