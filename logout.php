<?php
    session_start();
    session_unset();
    session_destroy();

    $cookie_time = time()-(60 * 60 * 24 * 30);
                    
    // sintax cookie : setcookie(fieldname, nilai, time, path)
    setcookie("cookie_username",$username,$cookie_time,"/");
    setcookie("cookie_password",password_hash($password, PASSWORD_DEFAULT),$cookie_time,"/");
    
    header('location: index.php');
    exit;