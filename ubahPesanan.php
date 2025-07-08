<?php
    include "koneksi.php";
    // cek sesion
    cekSession();

    // hanya bisa diakses oleh
    if(!isset($_GET['ubah'])){
        header("Location: index.php");
        die;
    }

    // get pesanan
    $idPesan = $_GET['ubah'];
    $dataPesan = $conn->query("SELECT produk.nama as nama_produk,produk.harga as harga_produk,pemesanan.* FROM pemesanan
    INNER JOIN produk ON produk.id = pemesanan.id_produk WHERE pemesanan.id='$idPesan'")->fetch_assoc();


    // ubah pesanan
    if(isset($_POST['ubah'])){
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
            $totalBayar = $jumlahProduk * $dataPesan['harga_produk'];

            // sql ubah pesanan
            $conn->query("UPDATE `pemesanan` SET `nama_pemesan`='$namaPemesanan',`no_hp`='$noHp',`alamat`= '$alamat',
            `jumlah_produk` = '$jumlahProduk',`total_pembayaran`='$totalBayar',`metode_pembayaran`='$metodePembayaran'
            WHERE `pemesanan`.`id`='$idPesan'");

            // tambah atau kurangi terjual sesuai perubahan jumlah produk
            $idKategori = $dataPesan['id_kategori'];
            $idProduk = $dataPesan['id_produk'];
            $x = $dataPesan['jumlah_produk'] - $jumlahProduk ;

            $conn->query("UPDATE kategori SET terjual = terjual - $x WHERE id='$idKategori'");
            $conn->query("UPDATE produk SET terjual = terjual - $x WHERE id='$idProduk'");
            
            header("Location: akun.php?pesan=1&x=PESANAN BERHASIL DI UBAH");

        } while (false);

    }


    htmlHeader("Merubah Pesanan")
?>


<div class="container-sm mt-4">
    <h2>Ubah Pesanan</h2>

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
                <input type="text" class="form-control" name="nama" value="<?= $dataPesan['nama_pemesan'] ?>">
            </div>
        </div>
        
        <!-- no_hp -->
        <div class="row mb-3 mt-3">
            <label class="col-sm-3 form-label">Nomor Hp</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" name="no_hp" value="<?= $dataPesan['no_hp'] ?>">
            </div>
        </div>
        
        <!-- Alamat -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Alamat</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="alamat" value="<?= $dataPesan['alamat'] ?>">
            </div>
        </div>

        <!-- nama produk -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Nama Produk</label>
            <div class="col-sm-6">
                <input type="text" name="namaProduk" value="<?= $dataPesan['nama_produk'] ?>" class="form-control" disabled>
            </div>
        </div>

        <!--harga -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Harga</label>
            <div class="col-sm-6">
                <input type="text" name="namaProduk" id="hargaProduk" value="<?= $dataPesan['harga_produk'] ?>" class="form-control" disabled>
            </div>
        </div>
        
        <!-- Jumlah produk -->
        <div class="row mb-4">
            <label class="col-sm-3 form-label">Jumlah Produk</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" value="<?= $dataPesan['jumlah_produk'] ?>" id="jumlahProduk" name="jumlah_produk" onkeyup="hitungTotalBayar()">
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
                    <span class="text-primary">Rp <input id="totalPembayaran" class="bg-1 border-0 text-primary" value="<?= $dataPesan['total_pembayaran'] ?>" disabled></span>
                </div>
                <input type="submit" name="ubah" class="btn btn-primary rounded-0" value="Ubah Pesanan" onclick="return confirm('Yakin Ingin Mengubah Pesanan?')">
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