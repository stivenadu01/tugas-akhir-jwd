<?php
$servername = 'localhost';
$dbhost = 'root';
$dbpassword = '';
$database = 'tugas_akhir';

try {
  $conn = new mysqli($servername, $dbhost, $dbpassword, $database);
  if ($conn->connect_errno) {
    throw new Exception($conn->connect_error);
  }
} catch (Exception $e) {
  echo "GAGAL TERKONEKSI DENGAN DATABASE!";
  die;
}

include "fungsi.php";
