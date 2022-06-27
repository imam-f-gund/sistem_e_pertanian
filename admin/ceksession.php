<?php
    session_start();
    if($_SESSION["id_role"] != 1){
        header("location: ../index.php", true, 301);
    }
?>