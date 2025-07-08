<?php
    include "koneksi.php";

    // batalkan pesanan
    if(isset($_GET['pemesanan'])){
        try{
            $idBatalPesanan = $_GET['pemesanan'];
            $dataBatalPesanan = $conn->query("SELECT jumlah_produk,id_kategori,id_produk FROM pemesanan WHERE id='$idBatalPesanan'")->fetch_assoc();
            $jumlahBatalPesanan = $dataBatalPesanan['jumlah_produk'];
            $idBatalProduk = $dataBatalPesanan['id_produk'];
            $idBatalKategori = $dataBatalPesanan['id_kategori'];
            // set terjual kurang jumlah produk yang dibatal
            $conn->query("UPDATE produk SET terjual=terjual - $jumlahBatalPesanan WHERE id='$idBatalProduk'");
            $conn->query("UPDATE kategori SET terjual=terjual - $jumlahBatalPesanan WHERE id='$idBatalKategori'");
            // hapus pesanan
            $conn->query("DELETE FROM pemesanan WHERE id='$idBatalPesanan'");
            if($conn->connect_errno){
                throw new Exception($conn->connect_errno);
            }
        } catch(Exception $e){
            header("Location: akun.php?pesan=0&x=GAGAL MEMBATALKAN PESANAN!");
            die;
        } 
    }


    header("Location: akun.php?pesan=1&x=BERHASIL MEMBATALKAN PESANAN");
    die;
