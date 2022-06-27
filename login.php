<?php
session_start();
?>
<!doctype php>
<php lang="en">
<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

   
    <!-- DataTales Example -->
   
        <div class="card shadow mt-4">
        <div id="notif"></div>
   

    <section id="content" class="mt-5">
        <div class="container">
            <div class="row">
            <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md">
                <div class="card border-3 border-dark" style="max-width:500px;margin:0 auto;">
                    <div class="card-body" style="background-color:LightGray;">
                        <div class="card-title text-center"><b>LOGIN</b></div>
                        <form class="mt-5" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control text-center" name="username" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control text-center" name="password" id="exampleInputPassword1"
                                    placeholder="kata Sandi">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">ingat saya</label>
                                <a href="lupa_sandi.php" style="float:right;"><span style="color:black;">Lupa kata
                                sandi?</span></a>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </section>

    <?php include 'layouts/footer.php';?>
    
    <?php
    include 'db/database.php';
      if($_SESSION){
        if($_SESSION["id_role"] != 1){
            header("location: index.php", true, 301);
        }elseif($_SESSION["id_role"] == 1){
            header("location: admin/dashboard.php", true, 301);
        }
    }

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $user =$_POST["username"];
        $pass =md5($_POST["password"]);
        // echo $user.$pass;
        $hasil = $mysqli -> query("select * from user where username='$user' and password='$pass'");
        $baris = $hasil -> fetch_array(MYSQLI_BOTH);
    
       if (!empty($baris)) {
        $_SESSION["id"] = $baris[0];
        $_SESSION["id_role"] = $baris[5];
       
        if ($baris[5] == 1) {
            echo '<script>'.
            ' window.location.href="admin/dashboard.php";'.
            '</script>';
          }else{
          // echo  $_SESSION["id"];
            echo '<script>'.
            'localStorage.setItem("notif_success", false);'.
            ' window.location.href="index.php";'.
            '</script>';
        }
       }else{
        echo '<script>'.
        'localStorage.setItem("notif", true);'.
        '</script>';
      }
    }
    // echo $user.$pass;
    ?>

    <script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/all.min.js"></script>
    <script src="assets/js/scroll.js"></script>
    <script src="assets/js/jquery.easing.1.3.js"></script>
     <script>
        console.log("Hello World!");
        
     var notif_mail = localStorage.getItem("notif_mail");
     var notif = localStorage.getItem("notif");
     var notif_s = localStorage.getItem("notif_success");
        if (notif == "true") {
          $('#notif').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error! </strong> Password atau Username salah!<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }else if(notif_s == 'true'){
            $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil! </strong> Password Telah Direset..! <br> Password sekarang <strong> 12345678 </strong> Segera Ubah Password Dimenu User>Detail <button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }else if(notif_mail == 'true'){
            $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil! </strong> Pendaftaran sukses  <button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        
        $(".close").click(function(){
          localStorage.clear();
        });
       
       
    </script>

</body>

</php>