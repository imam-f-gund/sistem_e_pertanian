<?php
session_start();
include 'db/database.php';

?>
<?php
    $page = "index.php";
    $title = "Kelompok Wanita Tani (KWT) Mekar Sari";
    
    if($_GET){
        $query = $_GET['query'];
    }
    
    $sql = "SELECT iklan.* FROM iklan";

    $result = $mysqli->query($sql);
    
    $iklans = [];
    while($row = $result->fetch_assoc()) {
        $iklans[] = $row;
    }
    // $mysqli -> close();
?>

<?php include 'layouts/header.php';?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1> -->

    <!-- DataTales Example -->
    <div class="card shadow mt-4">

    <div id="notif"></div>
   
    <section id="iklan" class="">
        <div class="">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($iklans as $iklan) : ?>
                        <div class="carousel-item <?php if($iklan['status'] == 'utama'){ echo 'active'; }?>">
                            <img src="asset/upload/<?= $iklan['file']?>" class="d-block w-100" alt="..." style="max-height:600px;">
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <section id="content" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <label for="" ><strong>Produk</strong></label>

                    <?php 
                           $sql = "select *  from jenis_produk";
                        
                            $result = $mysqli->query($sql);
                            $no = 1;
                           
                            if ($result->num_rows > 0) {

                                // output data of each row
                                while($data = $result->fetch_assoc()) {
                    ?>
                    <a href="index.php?query=<?=$data['id'];?>" style="text-decoration:none;color:black;"><div class="card mb-2"> <?php echo $data["nama"]; ?></div></a>
                   
                    <?php }} ?>
                     <a href="infokwt.php" style="text-decoration:none;color:black;"><div class="card mb-2"> Info KWT/Pertanian </div></a>
                </div>
                <div class="col-md-8">
                    <div class="row">
                    <?php   
                       
                       
                        if (empty($query)) {
                            $conten = "select produk.id, produk.keterangan, produk.stok, produk.file, produk.nama, produk.harga, jenis_produk.nama as jenis, jenis_produk.satuan from produk  INNER JOIN jenis_produk on produk.id_jenis_produk = jenis_produk.id where produk.id_jenis_produk limit 9 ";
                               
                        }else{
                            $conten = "select produk.id, produk.keterangan, produk.stok, produk.file, produk.nama, produk.harga, jenis_produk.nama as jenis, jenis_produk.satuan from produk INNER JOIN jenis_produk on produk.id_jenis_produk = jenis_produk.id where produk.id_jenis_produk = '$query'  limit 9";
                        }
                        
                            $result_conten = $mysqli->query($conten);
                            $no = 1;
                           
                            if ($result_conten->num_rows > 0) {

                                // output data of each row
                                while($rowss = $result_conten->fetch_assoc()) {
                                    // var_dump($rowss);
                    ?>
                        <div class="col-md-4 d-flex">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <label for=""><strong><?php echo $rowss["nama"]; ?></strong></label>
                                    <img src="asset/upload/<?php echo $rowss["file"]; ?>" alt="" style="width:180px;height:180px;">
                                    <label for="">Rp.<strong><?php echo $rowss["harga"]; ?></strong> / <?php echo $rowss["satuan"]; ?> </label>
                                    <div class="row mt-3">
                                        <div class="col-md-6 text-center">
                                        <button class="btn btn-block show btn-danger btn-sm"  value="<?php echo $rowss['id'].'|'.$rowss['nama'].'|'.$rowss['file'].'|'.$rowss['harga'].'|'.$rowss['satuan'].'|'.$rowss['keterangan'].'|'.$rowss['stok'];?>" data-toggle="modal" id="detail_produk" data-target="#exampleModal">
                                        Detail
                                        </button>
                                           
                                        </div>
                                        <div class="col-md-6 text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-block btn-primary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Beli
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                               <form action="keranjang.php" method="get">
                                                <div class="card-body text-center">
                                                    <input type="text" id="idd" name="id_produk" value="<?php echo $rowss['id'];?>" hidden>
                                                    <input type="number" class="form-group" name="jml_produk" placeholder="Jumlah Produk">
                                                    <button type="submit" class="form-group btn btn-primary">Lanjutkan</button>
                                                </div>
                                               </form>
                                            </div>
                                            
                                        </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    <?php }} ?>
                </div>
                    <div class="text-right mt-3 mb-5">
                        <a href="produk.php" class="btn btn-success">Selanjutnya</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="mt-6" action="keranjang.php" method="get">
        <div class="modal-body">
        <div class="card-body text-center">
            <input type="text" id="id_produk" name="id_produk" hidden>
            <label for=""><strong id="nama_produk"></strong></label>
            <div id="img"></div>
            <label for="">Rp.<strong id="harga"></strong> / <span id="satuan"></span> <p>Stok Produk : <strong id="stok"></strong></p></label>
            <p id="keterangan" ></p>
           
        </div>
      <div class="modal-footer">
        <input type="number" class="form-group" name="jml_produk" placeholder="Jumlah Produk">
        <button type="submit" class="btn btn-primary">Beli</button>
      </div>
      </form>
    </div>
  </div>
</div>   

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
            
     var notif = localStorage.getItem("notif");
        if (notif == "true") {
          $('#notif').append('<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Info!</strong> Harap Pilih Provinsi Dan Kota terlebih dahulu.<button type="button" class="close" id="closed" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        }
        $(".close").click(function(){
          localStorage.clear();
        });

       
       
    </script>
   

