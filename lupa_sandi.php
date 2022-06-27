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
                        <div class="card-title text-center"><b>Lupa Sandi</b></div>
                        <form class="mt-5" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control text-center" name="username" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Username">
                            </div>
                           
                            <button type="submit" class="btn btn-block btn-secondary">Reset</button>
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

    if (isset($_POST["username"])) {
        $user =$_POST["username"];
        $pass_text ='12345678';
        $pass =md5(12345678);
        // echo $user.$pass;
        $hasil = $mysqli -> query("select * from user where username='$user'");
        $baris = $hasil -> fetch_array(MYSQLI_BOTH);
        
        if ($baris !=  null) {
           

            $sql_user = "UPDATE user SET password = '$pass', text_passowd ='$pass_text' where username='$user'";
            if ($mysqli->query($sql_user) === TRUE) {
        
                echo '<script>'.
                'localStorage.setItem("notif_success", true);'.
                ' window.location.href="login.php";'.
                '</script>';
        
            }else{
                echo '<script>'.
                'localStorage.setItem("notif", true);'.
                '</script>';
            }
        }else{
            echo '<script>'.
            'localStorage.setItem("notif_not_found", true);'.
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
        
     var notif = localStorage.getItem("notif");
     var notif_not_found = localStorage.getItem("notif_not_found");
        if (notif == "true") {
          $('#notif').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error! </strong> Username Tidak Boleh Kosong..!<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }if (notif_not_found == "true") {
          $('#notif').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error! </strong> Username Tidak Ditemukan<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        $(".close").click(function(){
          localStorage.clear();
        });
       
       
    </script>

</body>

</php>