<?php

function htmlHeader($title = "Home"){
    echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$title}</title>
            <link rel='stylesheet' href='asset/bootstrap.min.css'>
            <link rel='stylesheet' href='asset/all.min.css'>
            <link rel='stylesheet' href='asset/bootstrap-icons/font/bootstrap-icons.css'>
            <link rel='stylesheet' href='asset/styles.css'>
            <style>
                .btn-biru:hover{
                    background-color: white !important;
                    color: var(--biru-1) !important;
                    border: 1px solid var(--biru-1);
                }
                .list-kategori:not(.list-group-item-aktif):hover{
                    background-color: hsl(213, 100%, 80%);
                    color: black;
                    transition: 100ms;
                }
                .list-group-item-aktif{
                    background-color: #2c8bff;
                    color: white;
                }
            </style>
        </head>
        <body>
            <nav class='bg-biru-1'>
                    <div class='container-fluid text-white'>
                        <nav class='navbar navbar-expand-md navbar-bg-body-tertiary p-0'>
                            <div class='container-fluid'>

                                <!-- <img src='' alt='Logo' width='40px'> -->
                                <a href='akun.php' style='text-decoration : none;' class='m-0 me-3''>
                                    <span class='navbar-brand'><i class='bi bi-person fa-2x text-white opacity-75'></i></span>
                                </a>

                                <span class='navbar-brand text-white'>Toko Online</span>
                                
                                <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                                    <span class='navbar-toggler-icon'></span>
                                </button>
                                
                                <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                                    
                                <ul class='navbar-nav mb-2 mb-lg-0 text-white' style='width: 100%;' >
                                        <li class='nav-item'>
                                            <form action='produk.php' method='get'>
                                                <div class='input-group mt-2 mt-sm-0 w-100'>
                                                <input type='text' name='search' class='form-control' placeholder='Search' aria-label='Recipient's username' aria-describedby='basic-addon2'>
                                                <button class='btn btn-light'><i class='bi bi-search'></i></button>
                                                </div>
                                            </form>
                                        </li>
                                        <li class='nav-item mx-5'>
                                            <a class='nav-link text-white' href='index.php'><i class='bi bi-house'></i> Home</a>
                                        </li>
                                        <li class='nav-item mx-5'>
                                            <a class='nav-link text-white' href='produk.php'><i class='bi bi-list-columns-reverse'></i> Produk</a>
                                        </li>
                                    </ul>
                                </div>

                                </div>
                        </nav>
                    </div>
            </nav>
    ";
}

function htmlFooter(){
    echo "
        <footer>
            <div class='container-fluid bg-biru-2 py-5 mt-5 text-white'>
                <div class='container text-center'>
                    <h3 class='mb-3'>Tentang Kami</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero ipsam qui animi, molestiae aliquam consequuntur expedita necessitatibus assumenda cum placeat minus cumque perspiciatis delectus repellat? Suscipit assumenda inventore est hic?</p>
                    <div class='row justify-content-center'>
                        <div class='col-1 d-flex justify-content-center mb-2 px-4'>
                            <i class='bi bi-facebook fs-4'></i>
                        </div>
                        <div class='col-1 d-flex justify-content-center mb-2 px-4'>
                            <i class='bi bi-instagram fs-4'></i>
                        </div>
                        <div class='col-1 d-flex justify-content-center mb-2 px-4'>
                            <i class='bi bi-twitter fs-4'></i>
                        </div>
                        <div class='col-1 d-flex justify-content-center mb-2 px-4'>
                            <i class='bi bi-whatsapp fs-4'></i>
                        </div>

                    </div>
                </div>
            </div>
        </footer>
        <script src='asset/bootstrap.bundle.min.js'></script>
    </body>
    </html>
    ";
}

function cekSession(){
    if($_SESSION['username'] == ""){
        header('location: login.php');
        exit;
    }
}

function refres($href = 'index.php'){
    echo "<meta http-equiv='refresh' content='1 ; url={$href}'>";
}

function randomStr($length = 10){
    $a = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ";
    $lenA = strlen($a);
    $randomStr = '';
    for($i=0; $i <$length; $i++){
        $randomStr .= $a[rand(0, $lenA -1)];
    }
    return $randomStr;
}
