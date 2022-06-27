<?php
// $tujuan = "kwtmekarlestari02@gmail.com";
include "classes/class.phpmailer.php";
include 'db/database.php';

if (isset($_POST["nama_lengkap"]) && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])) {
        
    $date = date("Y-m-d"); 
    $nama_lengkap = $_POST["nama_lengkap"];
    $user =$_POST["username"];
    $email =$_POST["email"];
    $pass =md5($_POST["password"]);
    $pass_text =$_POST["password"];

    $sql_user = "INSERT INTO user (nama_lengkap, email, username, password, text_passowd, date, role_id)
    VALUES ('$nama_lengkap','$email','$user', '$pass', '$pass_text', '$date', '2')";
  
    if ($mysqli->query($sql_user) === TRUE) {

        // email
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com"; //host email
        // $mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "imamf0000@gmail.com"; //user email server
        $mail->Password = "gundemmmmM"; //password email server
        $mail->SetFrom("imamf0000@gmail.com", "SIKAWT"); //set email pengirim / server
        $mail->Subject = "Layanan Notifikasi"; //subyek email
        $mail->AddAddress($email);  // email tujuan
        $mail->MsgHTML("Selamat, email ".$email." berhasil Mendaftar");


        if (!$mail->Send()) {
            // echo "Eror: " . $mail->ErrorInfo;
            echo "<script> localStorage.setItem('notif', true); window.location.href='daftar.php';</script>";
            exit;
        } else {
            echo "<script> localStorage.setItem('notif_mail', true); window.location.href='login.php';</script>";
            // echo "<div class='alert alert-success'><strong>Berhasil.</strong> Email telah dikirim.</div>";
            // header("location:login.php");
        }
        // end email
    } else {
        // echo $mysqli;
        echo "<script>alert('Pendaftaran Gagal!');</script>";
    }
}

?>

<!-- Elseif Channel -->