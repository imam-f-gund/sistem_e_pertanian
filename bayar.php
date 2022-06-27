<?php

include 'db/database.php';
session_start();

if(!isset($_SESSION['id'])){
    header("location:login.php");
}

if(isset($_POST['id_transaksi']) && isset($_POST['keterangan']) && isset($_FILES['file']) && isset($_POST['tgl_bayar']) ){

$output_dir = "asset/upload/";/* Path for file upload */
$RandomNum = time();
$ImageName = str_replace(' ','-',strtolower($_FILES['file']['name'][0]));
$ImageType = $_FILES['file']['type'][0];

$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
$ImageExt = str_replace('.','',$ImageExt);
$ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
$NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
$ret[$NewImageName]= $output_dir.$NewImageName;

/* Try to create the directory if it does not exist */
if (!file_exists($output_dir))
{
    @mkdir($output_dir, 0777);
}               

move_uploaded_file($_FILES["file"]["tmp_name"][0],$output_dir."/".$NewImageName );
           
$date = date("Y-m-d"); 
$id_transaksi = $_POST['id_transaksi'];
$keterangan = $_POST['keterangan'];
$tgl_bayar = $_POST['tgl_bayar'];

$sql_trans = "INSERT INTO pembayaran (id_transaksi, keterangan, file, tgl_bayar,  date)
VALUES ('$id_transaksi','$keterangan','$NewImageName', '$tgl_bayar', '$date')";

$updt = "UPDATE transaksi SET status = 'verifikasi pembayaran' where id = '$id_transaksi'";
if ($mysqli->query($updt) === TRUE) {
    if ($mysqli->query($sql_trans) === TRUE) {
        
    // echo "<script>localStorage.clear();</script>";
     echo "<script>localStorage.setItem('notif', success);</script>";
     echo "<script>location.href = 'pesanan.php';</script>";
    
    } else {
        echo "<script>alert('Gagal!');</script>";
        header("location:index.php");
    }
}else {
    echo "<script>alert('Gagal!');</script>";
    header("location:index.php");
}

}else {
    echo "<script>alert('Gagal form harus terisi semua!');</script>";
    header("location:pesanan.php");
}


?>