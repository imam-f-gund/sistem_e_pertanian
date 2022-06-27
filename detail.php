<?php
     session_start();
      if(!isset($_SESSION['id'])){
        header("location:login.php");
    }
     include 'db/database.php';
    

     if (!empty($_POST['id']) && !empty($_POST['id_detail']) ) {
        $id_user = $_POST['id'];
        $sql = "select * from user where id='$id_user'";
        $result = $mysqli->query($sql);
        $row = $result->fetch_assoc();
        
        $id_det = $_POST['id_detail'];
        $sql_detail = "select * from detail where id='$id_det'";
        $result_detail = $mysqli->query($sql_detail);
        $row_detail = $result_detail->fetch_assoc();

        if (isset($row)) {

            $nama_lengkap = $_POST["nama_lengkap"];
            $user =$_POST["username"];
            $email =$_POST["email"];
            $pass =md5($_POST["password"]);
            $pass_text =$_POST["password"];
          
            $sql_user = "UPDATE user SET nama_lengkap = '$nama_lengkap', email ='$email' , username='$user', password = '$pass', text_passowd ='$pass_text' where id='$id_user'";
            if ($mysqli->query($sql_user) === TRUE) {

                if (isset($row_detail)) {
                    $date = date("Y-m-d"); 
                    $alamat_lengkap = $_POST["alamat_lengkap"];
                    $no_telpon =$_POST["no_telpon"];
                    $kode_pos =$_POST["kode_pos"];
                
                    $sql_detail = "UPDATE detail SET alamat_lengkap = '$alamat_lengkap', no_telpon ='$no_telpon' , kode_pos='$kode_pos' where id='$id_det'";
                
                    if ($mysqli->query($sql_detail) === TRUE) {
            
                        echo "<script> localStorage.setItem('notif', true); location.href = 'detail.php';</script>";
                        echo "<script>alert('Berhasil');</script>";
                       
                    
                    } else {
                            echo "<script>alert('Tidak Berhasil');</script>";
                            header("location:detail.php");
                    }
            
                        $mysqli->close();
                  
                }
            }else {
                echo "<script>alert('Tidak Berhasil');</script>";
                header("location:detail.php");
            }
           

            $mysqli->close();
       }
    }
    
// tambah
    if (empty($_POST['id']) && isset($_POST["alamat_lengkap"]) && isset($_POST["no_telpon"]) && isset($_POST["kode_pos"])  ) {
        $id_user = $_SESSION['id'];
        $date = date("Y-m-d"); 
        $alamat_lengkap = $_POST["alamat_lengkap"];
        $no_telpon =$_POST["no_telpon"];
        $kode_pos =$_POST["kode_pos"];

        // echo "$nama_lengkap''$email'.'$user'.'$pass'.'$pass_text'.'$date";
        $sql_user = "INSERT INTO detail (alamat_lengkap, no_telpon, kode_pos, id_user, date)
        VALUES ('$alamat_lengkap','$no_telpon','$kode_pos', '$id_user', '$date')";
    
            if ($mysqli->query($sql_user) === TRUE) {
            
                echo "<script> localStorage.setItem('notif', true); location.href = 'detail.php';</script>";
            
            } else {
                // echo $mysqli;
                echo "<script>alert('Pendaftaran Gagal!');</script>";
            }

            
            }
    ?>

<?php
    $page = "detail.php";
    $title = "Detail Akun";
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->

    <!-- DataTales Example -->
    <div class="card shadow mt-4">

    <div id="notif"></div>
    <section id="iklan" class="mt-5">
        <div class="container">
           
        </div>
    </section>
                <?php 
                   $sql = "select * from user where id='$id'";
                   $result = $mysqli->query($sql);
                   $row_user = $result->fetch_assoc();
                 ?>
                
                <?php 
                   $sql_det = "select * from detail where id_user='$id'";
                   $result_detail = $mysqli->query($sql_det);
                   $row = $result_detail->fetch_assoc();
                ?>
                
    <section id="content" class="mt-5">
        <div class="container">
            <div class="row">
            <h1 class="h3 mb-4 text-gray-800 text-center"><?= $title ?></h1>
            <div class="container mt-5 mb-5">
        <div class="row ">
            <div class="card-body" style="background-color:Lightblue;">
            <div class="card text-center">
            
            <ul class="list-group list-group-flush">
                <?php if (isset($row_user)) { ?>
                   <li class="list-group-item card-title">Nama Lengkap : <p class="card-text"> <strong><?php echo $row_user['nama_lengkap']; ?></strong></p> </li>
                   <li class="list-group-item card-title">Email : <p class="card-text"> <strong><?php echo $row_user['email']; ?></strong></p> </li>
                   <li class="list-group-item card-title">Username : <p class="card-text"> <strong><?php echo $row_user['username']; ?></strong></p> </li>
                   <li class="list-group-item card-title">Password : <p class="card-text"> <strong><?php echo $row_user['text_passowd']; ?></strong></p> </li>
                  
                   <?php } if(!isset($row)){ ?>
                   <br>
                   <strong>Mohon Lengkapi Data Diri Anda !</strong>
                   <br>
                   <form method="post">
                   <li class="list-group-item card-title">Alamat Lengkap : <p class="card-text"><?php echo '<textarea type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap"></textarea>';?> </p> </li>
                   
                   <li class="list-group-item card-title">Nomer Telpon : <p class="card-text"><?php echo '<input type="text" class="form-control" id="no_telpon" name="no_telpon">'; ?> </p> </li>

                   <li class="list-group-item card-title">Kode Pos : <p class="card-text"><?php echo '<input type="text" class="form-control" id="kode_pos" name="kode_pos">';  ?> </p> </li>
                    <button type="submit" class="btn btn-success">Simpan</button>

                   </form>
                   <?php }else{?>
                    <li class="list-group-item card-title">Alama Lengkap : <p class="card-text"> <strong><?php echo $row['alamat_lengkap']; ?></strong></p> </li>
                    <li class="list-group-item card-title">No Telpon : <p class="card-text"> <strong><?php echo $row['no_telpon']; ?></strong></p> </li>
                    <li class="list-group-item card-title">Kode Pos : <p class="card-text"> <strong><?php echo $row['kode_pos']; ?></strong></p> </li>
                    <button type="button"  value="<?php echo $row_user['id'].'|'.$row_user['nama_lengkap'].'|'.$row_user['email'].'|'.$row_user['username'].'|'.$row_user['text_passowd'].'|'.$row['alamat_lengkap'].'|'.$row['no_telpon'].'|'.$row['kode_pos'].'|'.$row['id'];?>" class="btn btn-warning" data-toggle="modal" id="edit" data-target="#exampleModal">
                       Edit
                    </button>
                   <?php }?>
            </ul>
            </div>
            </div>
        </div>
        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Detail User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="mt-6" method="post">
        <div class="modal-body">
        <div class="row">
         <div class="col-md-10">
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">Nama Lengkap</label>
                 <div class="col-sm-12">
                     <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                     <input type="text" class="form-control" id="id" name="id" hidden>
                     <input type="text" class="form-control" id="id_detail" name="id_detail" hidden>
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">Email</label>
                 <div class="col-sm-12">
                     <input type="email" class="form-control" id="email" name="email">
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">username</label>
                 <div class="col-sm-12">
                     <input type="text" class="form-control" id="username" name="username">
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">password</label>
                 <div class="col-sm-12">
                     <input type="password" class="form-control" id="password" name="password">
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">Alamat Lengkap</label>
                 <div class="col-sm-12">
                     <textarea type="text" class="form-control" id="alamat_lengkap" name="alamat_lengkap"></textarea>
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">Nomer Telpon</label>
                 <div class="col-sm-12">
                     <input type="text" class="form-control" id="no_telpon" name="no_telpon">
                 </div>
             </div>
             <div class="form-group row">
                 <label for="staticEmail" class="col-sm-5 col-form-label">Kode Pos</label>
                 <div class="col-sm-12">
                     <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                 </div>
             </div>
            
         </div>
        </div>                    
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

    <?php include 'layouts/footer.php';?>
    <script>
        console.log("Hello World!");
        
              
        var notif = localStorage.getItem("notif");
        if (notif == "true") {
          $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Berhasil! </strong>Berhasil Disimpan<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        $(".close").click(function(){
          localStorage.clear();
        });
        $("#edit").on( "click", function() {
        var data = $(this).attr('value');
        data = data.split('|');
         console.log(data);
  
        $("#id").val(data[0]);
        $("#nama_lengkap").val(data[1]);
        $("#email").val(data[2]);
        $("#username").val(data[3]);
        $("#password").val(data[4]);
        $("#alamat_lengkap").val(data[5]);
        $("#no_telpon").val(data[6]);
        $("#kode_pos").val(data[7]);
        $("#id_detail").val(data[8]);
    
        });
       
    </script>
   
<!-- </body>
</html> -->
