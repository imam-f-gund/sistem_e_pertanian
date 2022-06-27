<?php
session_start();
include 'db/database.php';

?>
<?php
    $page = "index.php";
    $title = "Informasi KWT/Pertanian";
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid text-center">

    <!-- Page Heading -->
    

    <!-- DataTales Example -->
    <div class="card shadow mt-4">

    <div id="notif"></div>
   
    <section id="iklan" class="mt-5">
     
    </section>
    <section id="content" class="mt-5 mb-5">
        
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
    <?php  $info = "select * from informasi where id_jenis_informasi = 2"; $result_info = $mysqli->query($info);
    // $info = $result_info->fetch_assoc(); 
    if ($result_info->num_rows > 0) {

     while($data = $result_info->fetch_assoc()) { ?>
  <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="text-center">
                        <img src="asset/upload/<?= $data['gambar']?>" class="d-block w-50" alt="..." style="max-height:50;margin: 0 auto;">
                    </div>
                    <p><?= $data["keterangan"];?></p>
                </div>
            </div>
        </div>
    </section>
     <?php }} ?>

  

    <?php include 'layouts/footer.php';?>
    <script>
        // console.log("Hello World!");
        localStorage.removeItem('adress');
         $(".show").on( "click", function() {
            
        var data = $(this).attr('value');
        data = data.split('|');
        // alert(data[0]);
        //  console.log(data);
 
        $("#id_produk").val(data[0]);
        // $("#idd").val(data[1]);
        $("#nama_produk").text(data[1]);
        $("#img").html('<img src="asset/upload/'+data[2]+'" alt="" style="width:180px;height:180px;">');
        $("#harga").text(data[3]);
        $("#satuan").text(data[4]);
        $("#keterangan").text(data[5]);
        $("#stok").text(data[6]);

        });
            
    //  var notif = localStorage.getItem("notif");
    //     if (notif == "true") {
    //       $('#notif').append('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Holy guacamole!</strong> You should check in on some of those fields below.<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    //     }
    //     $(".close").click(function(){
    //       localStorage.clear();
    //     });

       
       
    </script>
   

