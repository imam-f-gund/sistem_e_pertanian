<?php

session_start();

if(!isset($_SESSION['id'])){
    header("location:login.php");
}
if(!isset($_POST['id_kota'])){
    echo "<script> localStorage.setItem('notif', true); location.href = 'index.php';</script>";
}
include 'db/database.php';

$date = date("Y-m-d"); 
$id_detail = $_POST['id_detail'];
$id_kota = $_POST['id_kota'];
$id_produk = $_POST['id_produk'];
$jml_order = $_POST['jml_order'];
$id_informasi = $_POST['id_informasi'];
$total_bayar = $_POST['total_bayar'];

// echo $id_detail.$id_produk.$jml_order.$id_informasi.$total_bayar.$id_kota;
$sql_trans = "INSERT INTO transaksi (id_detail, id_produk, jml_order, id_informasi, jml_bayar, date, status, id_kota, id_jasa_pengiriman)
VALUES ('$id_detail','$id_produk','$jml_order', '$id_informasi', '$total_bayar', '$date', 'menunggu pembayaran','$id_kota','1')";

if ($mysqli->query($sql_trans) === TRUE) {
            
    echo "<script> localStorage.setItem('notif', true); location.href = 'pesanan.php';</script>";

} else {
    // echo $mysqli;
    echo "<script> localStorage.setItem('notif', true); location.href = 'index.php';</script>";
    // header("location:index.php");
}


?>