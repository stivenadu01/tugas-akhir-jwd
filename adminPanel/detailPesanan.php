<?php
    include "headerAdmin.php";

    $idPesanan = $_GET['id'];
    $sqlPesanan = $conn->query("SELECT produk.harga,produk.foto,produk.nama as nama_produk ,pemesanan.* FROM pemesanan
    INNER JOIN produk ON produk.id=pemesanan.id_produk
    WHERE pemesanan.id='$idPesanan'");
    $dataPesanan = $sqlPesanan->fetch_assoc();

    if(isset($_POST['kirim'])){
        $sqlkirim = $conn->query("UPDATE pemesanan SET `status`='DALAM PENGIRIMAN' WHERE id='$idPesanan'");
        $successPesan = "PESANAN TERKIRIM SILAHKAN LAKUKAN PENGIRIMAN SECEPATNYA";
        echo "<meta http-equiv='refresh' content='3 ; url=index.php'>";
    }
?>

<div class="container mt-3">
    <h2>Detail Pesanan <?= $idPesanan ?></h2>
    <div class="row">
        <div class="col-sm-4">
            <img class="w-100" src="../image/<?= $dataPesanan['foto'] ?>">
        </div>

        <!-- list pemesanan -->
        <div class="col-sm-8">
            <!-- success pesan -->
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

            <table class="table table-striped">
                <tr>
                    <th>Nama Produk</th>
                    <td><?= $dataPesanan['nama_produk'] ?></td>
                </tr>
                <tr>
                    <th>Harga Produk</th>
                    <td><?= $dataPesanan['harga'] ?></td>
                </tr>
                <tr>
                    <th>Nama Pemesanan</th>
                    <td><?= $dataPesanan['nama_pemesan'] ?></td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td><?= $dataPesanan['no_hp'] ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= $dataPesanan['alamat'] ?></td>
                </tr>
                <tr>
                    <th>Jumlah Produk</th>
                    <td><?= $dataPesanan['jumlah_produk'] ?></td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td><?= $dataPesanan['total_pembayaran'] ?></td>
                </tr>
                <tr>
                    <th>Metode Bayar</th>
                    <td><?= $dataPesanan['metode_pembayaran'] ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?= $dataPesanan['status'] ?></td>
                </tr>
                <tr>
                    <th>Waktu Pesanan</th>
                    <td><?= $dataPesanan['waktu_pesanan'] ?></td>
                </tr>
            </table>

            <!-- tombol -->
            <div class="">
                <form method="post">
                    <?php
                    if($dataPesanan['status'] == "SEDANG DIKEMAS"){
                        echo "<input type='submit' name='kirim' class='btn btn-primary rounded-0' value='Kirim Sekarang'>";
                    } 
                    elseif($dataPesanan['status'] == "SUDAH DITERIMA"){
                        echo "<a class='btn btn-success rounded-0'>PESANAN SUDAH DITERIMA PEMBELI</a>";
                    } else {
                        echo "<a class='btn btn-warning rounded-0'>PESANAN SUDAH ANDA KIRIM</a>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
    include "footerAdmin.php";
?>