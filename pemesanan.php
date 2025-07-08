<?php
    include "koneksi.php";

    session_start();
    cekSession();
    // ambil user
    $username = $_SESSION['username'];
    $sqlUser = $conn->query("SELECT * FROM users WHERE username='$username'");
    $dataUser = $sqlUser->fetch_array();
    
    $noHp = $dataUser['no_hp'];
    $alamat = $dataUser['alamat'];
    

    // ambil produk
    $idProduk = $_GET['produk'];
    $sqlProduk = $conn->query("SELECT * FROM produk WHERE id='$idProduk'");
    $dataProduk = $sqlProduk->fetch_assoc();
    
    $idKategori = $dataProduk['id_kategori'];
    
    // pemesanan
    if(isset($_POST['pesan'])){
        $namaPemesanan = $_POST['nama'];
        $noHp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $jumlahProduk = $_POST['jumlah_produk'];
        $metodePembayaran = $_POST['metode_pembayaran'];

        do {
            if(empty($namaPemesanan) || empty($noHp) || empty($alamat) || empty($jumlahProduk) || empty($metodePembayaran)){
                $erorrPesan = "SEMUA WAJIB DI ISI!";
                break;
            }
            $totalPembayaran = $jumlahProduk * $dataProduk['harga'];

            $sqlPesan = $conn->query("INSERT INTO `pemesanan` (`id_produk`, `id_kategori`, `username`, `nama_pemesan`, `no_hp`, `alamat`, `jumlah_produk`, `total_pembayaran`, `metode_pembayaran`)
            VALUES ('$idProduk', '$idKategori', '$username', '$namaPemesanan', '$noHp', '$alamat', '$jumlahProduk', '$totalPembayaran', '$metodePembayaran');");
            
            // tambah terjual di kategori dan produk sesuai jumlah pemesanan
            $conn->query("UPDATE `produk` SET `terjual`=`terjual`+'$jumlahProduk' WHERE `id`='$idProduk'");
            $conn->query("UPDATE `kategori` SET `terjual` = `terjual` + '$jumlahProduk' WHERE `id`='$idKategori'");

            $successPesan = "Pesanan Berhasil Di Buat!";
            refres("akun.php");

        } while (false);
    }



    htmlHeader("Pemesanan");
?>

<div class="container-sm mt-4">
    <h2>Form Pemesanan</h2>

    <!-- alert Pesan -->
    <div class="col-12 col-sm-9">
        <?php
        if(isset($erorrPesan)){
            echo "
            <div class='alert alert-warning alert-dismissible fade show mt-3'>
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                <strong> $erorrPesan </strong>
            </div>
            ";
        }
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

    <form method="post">
        <!-- nama Pemesanan -->
        <div class="row mb-4 mt-4">
            <label class="col-sm-3 form-label">Nama Pemesanan</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="nama" value="<?php if(isset($namaPemesanan)){echo $namaPemesanan;}else{ echo $username;} ?>">
            </div>
        </div>
        
        <!-- no_hp -->
        <div class="row mb-3 mt-3">
            <label class="col-sm-3 form-label">Nomor Hp</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="no_hp" value="<?= $noHp ?>">
            </div>
        </div>
        
        <!-- Alamat -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Alamat</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="alamat" value="<?= $alamat ?>">
            </div>
        </div>

        <!-- nama produk -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Nama Produk</label>
            <div class="col-sm-6">
                <input type="text" name="namaProduk" value="<?= $dataProduk['nama'] ?>" class="form-control" disabled>
            </div>
        </div>

        <!--harga -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Harga</label>
            <div class="col-sm-6">
                <input type="text" name="namaProduk" id="hargaProduk" value="<?= $dataProduk['harga'] ?>" class="form-control" disabled>
            </div>
        </div>
        
        <!-- Jumlah produk -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Jumlah Produk</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" value="" id="jumlahProduk" name="jumlah_produk" onkeyup="hitungTotalBayar()">
            </div>
        </div>
        
        <!-- metode pembayaran -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Metode Pembayaran</label>
            <div class="col-sm-6">
                <select name="metode_pembayaran" class="form-select">
                    <option value="cod" selected>COD</option>
                    <option value="bri" disabled>BRI</option>
                    <option value="bca" disabled>BCA</option>
                </select>
            </div>
        </div>

        <!-- tombol -->
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 d-flex justify-content-end bg-1">
                <div class="p-1">
                    <span class="d-block">Total Pembayaran</span>
                    <span class="text-primary">Rp <input id="totalPembayaran" class="bg-1 border-0 text-primary" disabled></span>
                </div>
                <input type="submit" name="pesan" class="btn btn-primary rounded-0" value="Buat Pesanan">
                <!-- <a href="detailProduk.php?produk=<?= $idProduk ?>" class="btn btn-outline-danger ms-4 w-75">Kembali</a> -->
            </div>
        </div>
    </form>
</div>

<script>
    function hitungTotalBayar(){
        var hargaProduk = document.getElementById('hargaProduk').value;
        var jumlahProduk = document.getElementById('jumlahProduk').value;

        var totalBayar = hargaProduk * jumlahProduk;
        document.getElementById('totalPembayaran').value = totalBayar;
    }
</script>

<?php
    htmlFooter();
?>