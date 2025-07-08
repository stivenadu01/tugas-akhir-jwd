<?php
$servername = "localhost";
$username = "root";
$password = "";
$dataBase = "tugas_akhir";

$conn = new mysqli($servername, $username, $password, $dataBase);

if ($conn->connect_error) {
  die("Connection failed : " . $conn->connect_error);
}

// sesion
session_start();
if ($_SESSION['admin'] == "") {
  header("location: login.php");
  exit;
}

function randomStr($length = 10)
{
  $a = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ";
  $lenA = strlen($a);
  $randomStr = '';
  for ($i = 0; $i < $length; $i++) {
    $randomStr .= $a[rand(0, $lenA - 1)];
  }
  return $randomStr;
}
function refres($href = 'index.php')
{
  echo "<meta http-equiv='refresh' content='1 ; url={$href}'>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../asset/bootstrap.min.css">
  <link rel="stylesheet" href="../asset/bootstrap-icons/font/bootstrap-icons.min.css">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../asset/style.css">
  <style>
    .overflow-scroll {
      overflow: scroll;
      height: 100vh;
    }
  </style>
</head>

<body>
  <nav class='bg-dark'>
    <div class='container'>
      <nav class='navbar navbar-expand-md navbar-dark bg-dark p-1'>
        <div class='container-fluid'>
          <div class='margin-0'>
            <a href='akun.php' style='text-decoration : none;' class='margin-0''>
                            <!-- <img src='' alt=' Logo' width='40px'> -->
              <span class='navbar-brand'><i class='bi bi-person h1 text-white-50'></i></span>
            </a>
          </div>
          <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
          </button>
          <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav mb-2 mb-lg-0' style='width: 100%;'>
              <li class='nav-item mx-5'>
                <a class='nav-link' href='index.php'>Home</a>
              </li>
              <li class='nav-item mx-5'>
                <a class='nav-link' href='kategori.php'>Kategori</a>
              </li>
              <li class='nav-item mx-5'>
                <a class='nav-link' href='produk.php'>Produk</a>
              </li>
              <li class='nav-item mx-5'>
                <a class='nav-link' href='index.php?logout=logout'>Logout <i class='bi bi-arrow-right'></i></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </nav>