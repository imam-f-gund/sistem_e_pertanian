<?php
session_start();
include 'db/database.php';

?>
<?php
    $page = "index.php";
    $title = "Cara Pesan";
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    

    <!-- DataTales Example -->
    <div class="card shadow mt-4 bgtotal">

    <div id="notif"></div>
   
    <section id="iklan" class="mt-5">
     
    </section>
    <?php  $info = "select * from informasi where id_jenis_informasi = 1"; $result_info = $mysqli->query($info);
    $info = $result_info->fetch_assoc(); $text = explode(";",$info["keterangan"]);?>
    <section id="content" class="mt-5 mb-5 bgnav">
        <div class="container">
        <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
            <div class="row">
                <div class="text-justify">
                <!-- <p><?= $info["keterangan"];?></p> -->
                <?php foreach($text as $r){
                    echo '<p> '.$r.'.</p>';
                }?>
                </div>
            </div>
        </div>
    </section>

  

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
   

