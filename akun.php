<?php
    include "koneksi.php";


    // cekSession();
    session_start();
    
    cekSession();

    $username = $_SESSION['username'];
    // ambil data pesanan
    $sqlPesanan = $conn->query("SELECT produk.nama,produk.harga,produk.foto,produk.details, pemesanan.* FROM pemesanan
    INNER JOIN produk ON produk.id = pemesanan.id_produk WHERE username='$username' ORDER BY pemesanan.waktu_pesanan DESC");
    
    if(isset($_GET['konfirmasi'])){
        $idPesanan = $_GET['konfirmasi'];
        $sqlKonfirPesanan = $conn->query("UPDATE pemesanan SET `status` = 'SUDAH DITERIMA' WHERE id='$idPesanan';");
    }

    htmlHeader("Saya");
?>
<div class="container-fluid p-5 bg-opacity-50 bg-biru-1 text-white rounded-bottom">
    <div style="width: fit-content; min-width: 225px;">
        <h2>Hallo <?php echo $_SESSION['username'] ?></h2>
        <div class="d-flex justify-content-between">
            <a href="ubahProfil.php" class="text-white opacity-75 text-decoration-none"><i class="bi bi-pencil-fill"></i> Ubah Profil</a>
            <a href="logout.php" class="text-white opacity-75 text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-3">
        <h4>Pesanan Saya</h4>
    </div>
</div>

<!-- tangkap pesan dari membatalkan pesanan -->
<?php
    if(isset($_GET['pesan'])){
        $pesan = $_GET['pesan'];
        $x = $_GET['x'];
        if($pesan=="1"){
            echo "
                <div class='py-3 container-sm'>
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$x</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>           
            ";
        } else{
            echo "
                <div class='py-3 container-sm'>
                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>$x</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
            ";
        }
    }

?>

<?php
    while($dataPesanan = $sqlPesanan->fetch_array()){ 
        $harga = number_format($dataPesanan['harga'],0,'','.');
        $totalPembayaran = number_format($dataPesanan['total_pembayaran'],0,'','.');

        $status = $dataPesanan['status'];
        if($status=="DALAM PENGIRIMAN"){
            $textStatus = "text-danger";
        } elseif ($status == "SUDAH DITERIMA"){
            $textStatus = "text-success";
        }
        ?>
        <div class="container-sm mt-3 bg-1 py-3">
            <div class="row border-bottom border-3">
                <div class="col ms-lg-5">
                    <span class="h5"><?= $dataPesanan['nama'] ?></span>
                </div>
                <div class="col-6">
                    <span style="font-size: 1rem;" class="d-flex justify-content-end <?= $textStatus ?> "><?= $status ?></span>
                </div>
            </div>
            <div class="row mx-sm-5 pt-1">
                <div class="col-4">
                    <img src="image/<?= $dataPesanan['foto'] ?>" class="w-100">
                </div>
                <div class="col-8">
                    <p class="text-truncate mt-1"><?= $dataPesanan['details'] ?></p>
                    <span><b>x<?= $dataPesanan['jumlah_produk'] ?></b></span>
                </div>
            </div>
            <div class="row my-1 border-top border-2">
                <span class="d-flex justify-content-end">
                    Total Pesanan: <span class="text-primary ms-2" style="font-size: 1.3rem;">Rp <?= $totalPembayaran ?></span>
                </span>
            </div>
        
            <div class="row mt-1">
                <div class="d-flex justify-content-end">
                    <?php if($status=="DALAM PENGIRIMAN"){
                        echo "<a href='akun.php?konfirmasi={$dataPesanan['id']}' class='btn btn-danger rounded-0 me-1'>Konfirmasi Penerimaan</a>";
                    } elseif($status=="SUDAH DITERIMA"){
                        echo "<span class='btn btn-success rounded-0 me-1'>PESANAN SUDAH DITERIMA</span>";
                    } else{
                        echo "
                        <a href='ubahPesanan.php?ubah={$dataPesanan['id']}' class='btn btn-primary rounded-0 me-1'>Ubah Pesanan</a>
                        <a href='proses.php?pemesanan={$dataPesanan['id']}' onClick=\"return confirm('Yakin Ingin Membatalkan Pesanan')\" class='btn btn-outline-danger rounded-0'>Batalkan Pesanan</a>
                        ";
                    }
                    
                    ?>
                </div>
            </div>
        </div>
<?php } ?>

<script>
    
</script>
<?php
    htmlFooter();
?>